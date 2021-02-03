$(document).ready(function() {
    $('.code').each(function (index) {


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