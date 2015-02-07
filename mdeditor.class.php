<?php
/* Include this file in a page to provide a markdown editor. */

class mdEditor {
    
    /** use this to insert a markdown editor widget into a form
     * @param String id: The ID to give to the widget
     * @param String name: The name to give to the widget
     * @param String title: Ther label/title to give to the field
     * @param bool required: Is this a required field?
     * @return String: A string of HTML to insert into the form
    */
    public function get_form_components($id = 'body', $name='body', $title = 'Body', $required = FALSE) {
        $safe_id = preg_replace('|(?mi-Us)[^a-z0-9]|', '-', $id);
        $req = '';
        $label_req = '';
        if ($required) { $req = 'required="required"'; $label_req = '<span class="required-item">*</span>'; }
        $form_components = '
        <div class="md-editor-wrapper form-item">
            <div class="md-editor-box" style="float:left; margin-right:4%; width: 48%;">
                <label for="'. $safe_id .'">'. htmlspecialchars($title) .': '. $label_req .'</label> 
                <textarea class="markdown-editor" id="'. $safe_id .'" name="'. $name .'" style="width: 100%; height: auto; resize: vertical; max-height: 750px;" '. $req .' ></textarea>
            </div>
            <div style="float:right; width: 44%;"><label for="'. $safe_id.'-preview">Preview</label></div>
            <div class="md-editor-preview" id="'. $safe_id.'-preview" style="float:right; margin:0; width: 44%; padding:1%; border: 2px solid #000;">&#0160;</div>
            <div class="md-editor-clearit" style="clear:both; height:1 em !important; display:block !important;>&#0160;</div>
            <div class="description help"><a href="http://daringfireball.net/projects/markdown/syntax" class="extlink">Basic Markdown Syntax</a> | <a href="https://help.github.com/articles/github-flavored-markdown/" class="extlink">Github-flavoured Markdown Syntax</a> | <a href="https://michelf.ca/projects/php-markdown/extra/" class="extlink">Markdown Extra Syntax</a></div>
        </div>';
        
        return $form_components;
    }
    
    public function __construct() {
        $this->id = $i;
    }
}
