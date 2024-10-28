<!-- Include editor.md CSS -->
<link rel="stylesheet" href="https://cdn.rawgit.com/pandao/editor.md/master/css/editormd.preview.min.css" />
<link rel="stylesheet" href="https://cdn.rawgit.com/pandao/editor.md/master/css/editormd.min.css" />


<!-- Include editor.md JS -->
<script src="https://cdn.rawgit.com/pandao/editor.md/master/editormd.min.js"></script>
<script src="https://pandao.github.io/editor.md/languages/en.js"></script>
<script>
    var editor;
    $(document).ready(function() {
        // Initialize the editor.md editor
        editor = editormd("editor", {
            width: "100%",
            height: 400,
            path: "https://cdn.rawgit.com/pandao/editor.md/master/lib/",
            toolbarIcons: function() {
                return [
                    "undo", "redo", "|", 
                    "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase", "|", 
                    "h1", "h2", "h3", "h4", "h5", "h6", "|", 
                    "list-ul", "list-ol", "|", 
                    "link", "reference-link", "image", "code", "preformatted-text", "code-block", "|", 
                    "table", "hr", "page-break", "|", 
                    "watch", "preview", "fullscreen", "|", 
                    "clear", "help"
                ];
            },
            onchange: function() {
                // Update hidden input with markdown content
                var markdownContent = this.getMarkdown();
                $('#editor-content').val(markdownContent);
            },
            onload: function() {
                // Set initial markdown content
                var markdownContent = $('#editor-content').val();
                this.setMarkdown(markdownContent);
            }
        });
    });

</script>