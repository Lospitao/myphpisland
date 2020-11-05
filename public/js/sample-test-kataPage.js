$(document).ready(function() {
    $('#sample-test').each(function (index) {


        var editor = CodeMirror.fromTextArea(this, {
            lineNumbers: true,
            mode: {
                name: 'php',
                startOpen: true,
            },
            mime: "application/x-httpd-php",
            theme: "eclipse",
            extraKeys: {"Ctrl-Space": "autocomplete",}
        });

    })
});
