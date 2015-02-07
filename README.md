# mdeditor
A PHP-based markdown editor widget offering a live preview (based on [Emanuil Rusev's Markdown Extra Parser](https://github.com/erusev/markdown-extra))

## Overview ##

This markdown editor allows you to insert a markdown editor widget (text area with live preview) into a form. The live preview is updated as text is entered into the text area.

Through the use of [Emanuil Rusev's Markdown Extra Parser](https://github.com/erusev/parsedown-extra){.extlink}  library, the editor supports Markdown Extra and Github-flavoured Markdown.

## Conversion ##

The conversion comes in one of two formats:

1. HTML (default), via [Emanuil Rusev's Markdown Extra Parser](https://github.com/erusev/parsedown-extra){.extlink} library
2. PDF, via Parsedown Extra and Nicola Asuni's [TCPDF](http://www.tcpdf.org/)

### Parameters ###

Parameters are passed to `parser.php` (either through GET or POST), the engine that parses the provided markdown text.

+ The minimum required parameter is `text`, a string of markdown to convert. Output will be a string of HTML.
+ `format`: 'H' for HTML or 'P' for PDF
+ `json`: 1 (output JSON) or 0 (output HTML, not JSON); only applies if format is 'H'
+ `title`: Title to show in header section of PDF (only applies if format is 'P')
+ `method`: Output method for PDF
  - 'D' for download
  - 'F' to save as file
  - 'I' for inline display
+

## Installation ##

1. [Install composer](https://getcomposer.org/doc/00-intro.md), if you don't already have it.
2. download the markdown editor
3. Change dir (`cd`) into the editor directory and run `php /path/to/composer.phar composer.json`

## Demonstration ##

A demonstration form is available in `index.php`. This file can be used as a template for any forms that implement the markdown editor widget. Logic for form submission has not been created in this file.

*Note*: The content that will be submitted by the form is markdown text, not the resultant HTML in the preview.
