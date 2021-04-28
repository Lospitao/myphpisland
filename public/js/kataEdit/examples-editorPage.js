$(document).ready(function() {
    $('#examples').each(function (index) {


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

            let updateKataWebService = API_DOMAIN+'/api/v1/katas/' + uuid;

            let examples = editor.getValue(index);
            $.ajax({
                url : updateKataWebService,
                data : {
                    'examples' : examples,
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
