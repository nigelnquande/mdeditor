// A $( document ).ready() block.
$( document ).ready(function() {
    if ($('div.md-editor-wrapper').length > 0) {
        $('div.md-editor-wrapper div.md-editor-box textarea.markdown-editor').bind('blur keyup change', function() {
            var text = $(this).val(), preview = $(this).parents('.md-editor-wrapper').find('.md-editor-preview');
            // use AJAX to populate the preview pane
            $.ajax({
                url: "./parser.php",
                data: {
                    'text': text
                },
                success: function (result) {
                    preview.html(result);
                },
                error: function (xhr,status,error) {
                    preview.html('<div class="error">Failed to convert markdown to HTML</div>');
                }
            });
        });
    }
    
    $('a.extlink').click(function (e) {
        e.preventDefault();
        window.open($(this).prop('href'), '_blank');
    });
});
