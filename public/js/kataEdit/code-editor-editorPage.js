$(document).ready(function() {
    $('#code-editor').each(function (index) {


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
       editor.on("blur", function () {
           let title = document.getElementById("title");
           let uuid = title.getAttribute("data-uuid")

           let updateKataWebService = '/api/v1/katas/' + uuid;

           let editorCode = editor.getValue(index);
           $.ajax({
               url : updateKataWebService,
               data : {
                   'editorCode' : editorCode,
               },
               type : 'PATCH',
               dataType : 'json',
               success: function (data) {
                   console.log('Submission was successful.')
                   console.log(data);
               },
               error: function (data) {
                   console.log('An error occurred.');
                   console.log(data);
               },
           })

       })
    })
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