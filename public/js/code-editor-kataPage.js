$(document).ready(function() {
    $('#code-editor').each(function (index) {
        let editor = CodeMirror.fromTextArea(this, {
            lineNumbers: true,
            mode: {
                name: 'php',
                startOpen: true,
            },
            mime: "application/x-httpd-php",
            theme: "eclipse",
            extraKeys: {"Ctrl-Space": "autocomplete",}
        });

    document.getElementById("test-executor").addEventListener("click", function () {
        //Get uuid
        let title = document.getElementById("title");
        let uuid = title.getAttribute("data-uuid")
        //Define Controller
        let updateKataWebService = 'https://localhost:8000/api/v1/test_executions/' + uuid;
        //Get value of Textarea
        let editorCode = editor.getValue(index);

        if (editorCode.length === 0) {
            alert ("Escribe tu código antes de ejecutar el test")
        }
        else {
            $.ajax({
                url: updateKataWebService,
                data: {
                    'kataId': uuid,
                    'code': editorCode,
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {

                },
                error: function (data) {

                },
            })
        }
    });

    })
});
