<?php
/* parser: takes sent text and converts it into HTML. HTML can also be converted into PDF (via TCPDF) */
// allow autoloading classes; fails if required libraries haven't been installed with composer
require_once(__DIR__ ."/vendor/autoload.php"); // may need to change to '../../autoload.php'

// check that we have been given the markdown to parse and the format.

$formats = array('H' => 'HTML', 'P' => 'PDF');
$methods = array('D' => 'Download', 'F' => 'Save File', 'I' => 'Inline');

// return output as JSON? (only valid for HTML)
$use_json = (isset($_REQUEST['json']) && ($_REQUEST['json'] == 1));

$format = (isset($_REQUEST['format']) && array_key_exists($_REQUEST['format'], $formats))? $_REQUEST['format'] : 'H';
$method = (isset($_REQUEST['method']) && array_key_exists($_REQUEST['method'], $methods))? $_REQUEST['method'] : 'D';

$out = '';

$title = (isset($_REQUEST['title']) && strlen($_REQUEST['title']))? strip_tags($_REQUEST['title']) : 'Converted from Markdown';

$Extra = new ParsedownExtra(); // Markdown parser

if (isset($_REQUEST['text']) && strlen($_REQUEST['text'])) {
    $replace = str_ireplace(array('[_]', '[ ]'), '<input type="checkbox" /> ', $_REQUEST['text']);
    $replace = str_ireplace(array('[x]', '[+]', '[-]'), '<input type="checkbox" checked="checked" /> ', $replace);
    $out = $Extra->text($replace);
    /* replace double hyphen with mdash and single hyphen with ndash 
     * Parser must evaluate md first, for the sake of correctly making list items and horizontal rules
     */
     $out = str_ireplace(' -- ', '&nbsp;&mdash;&nbsp;', $out);
     $out = str_ireplace(' - ', '&nbsp;&ndash;&nbsp;', $out);
}
else { // no text to parse
    $out = $Extra->text('No markdown text was sent for parsing.');
}

if ($format == 'P') { // PDF logic
    $file_name = (isset($_REQUEST['file_name']) && strlen($_REQUEST['file_name']))?
        preg_replace('|(?mi-Us)[^a-z0-9_]|', '_', $_REQUEST['file_name']) .'.pdf' : 'downloaded_'. date("Y-m-d_H-i-s") .'.pdf';
    //header("Content-Type: application/pdf");
    // It will be called downloaded.pdf
    //header('Content-Disposition:attachment;filename="'. $file_name .'"');
    // do what needs to be done to convert html to PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE);
    
    // Document information
    $pdf->SetCreator(PDF_CREATOR);
    /** @todo: in a system with users, set author to user's name 
     * (or read in from an INI/YAML configuration file)
     */
    $author = 'Nigel Nquande';
    $pdf->SetAuthor($author); 
    $pdf->SetTitle($title);
    $pdf->SetSubject('PDF generated from Markdown converted to HTML; converted on '. date("Y-m-d @ H:i:s") .' (using TCPDF by Nicola Asuni)');
    $pdf->SetKeywords('Markdown, PDF');
    
    // set default header data
    $header_string = "Generated for $author on ". date("Y-m-d @ H:i:s");
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, $header_string);
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // add a page and output PDF from HTML content
    $pdf->AddPage();
    $html = str_ireplace('<input type="checkbox" />', '[_]', $out);
    $html = str_ireplace('<input type="checkbox" checked="checked" />', '[X]', $html);
    $pdf->writeHTML($html, TRUE, FALSE, FALSE, FALSE, '');
    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document
    $pdf->Output($file_name, $method); // Download; I for inline, F to save file
}
else { // HTML logic
    if ($use_json) {header('Content-Type: application/json'); print json_encode($out, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT, 1024); } 
    else print $out;
    exit();
}
