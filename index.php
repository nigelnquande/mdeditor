<?php require_once(__DIR__ .'/mdeditor.class.php'); ?><!DOCTYPE html>
<html>
    <!-- demonstration form that uses a markdown editor with live preview -->
    <title>MD Editor with live Preview</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="./mdeditor.jquery.js"></script>
    
    <form id="test_frm" action="<?php print $_SERVER['PHP_SELF']; ?>" method="get" >
        <div class="form-item">
            <label for="title">Title: <span class="required-item">*</span></label> <input type="text" id="title" name="title" required="required" />
        </div>
        <?php
            $editor = new mdEditor(); // editor instance, for adding md editor widgits
            print $editor->get_form_components('body', 'body', 'Body', TRUE);
        ?>
        <div class="form-item form-submit">
            <input type="submit" value="Save" />
        </div>
    </form>
</html>
