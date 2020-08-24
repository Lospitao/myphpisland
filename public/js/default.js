



$(document).ready(function() {
    //code goes here...
    var code = $(".codemirror-textarea")[0];
    var editor = CodeMirror.fromTextArea(code, {
        lineNumbers: true,
        mode: "php",
        mime: "application/x-httpd-php",
        extraKeys: {"Ctrl-Space": "autocomplete",}
    });
    //when form submitted
    $("#preview-form").submit(function(e) {
       var value = editor.getValue();
       if(value.length == 0) {
           alert("Missing code!");
       }
    });
});