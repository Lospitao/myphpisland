
    $(document).ready(function() {

        var codeElementCodeEditor = $('.sample-test .code')[0];

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



