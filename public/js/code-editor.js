
    $(document).ready(function() {

        var codeElementCodeEditor = $('.code-editor .code')[0];

            var editorCodeEditor = CodeMirror.fromTextArea(codeElementCodeEditor, {
                lineNumbers: true,
                mode: {
                    name: 'php',
                    startOpen: true,
                },
                mime: "application/x-httpd-php",
                theme: "eclipse",
                extraKeys: {"Ctrl-Space": "autocomplete",}
            });
        });



/********************************************************
    //when form submitted
    $("#preview-form").submit(function(e) {
        var value = editor.getValue();
        if(value.length == 0) {
            alert("Missing code!");
        }
    });
 */