

$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid")

    let updateKataWebService = 'https://localhost:8000/api/v1/katas/' + uuid +'/editor';


    $('#title').focusout(function() {
        let title_text = $('#title').val();
        $.ajax({
            url : updateKataWebService,
            data : {
                'title' : title_text,
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
    });

    $('#description').focusout(function() {
        let description = $('#description').val();
        $.ajax({
            url : updateKataWebService,
            data : {
                'description' : description,
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
    });

    $('#code-editor').focusout(function() {
        let editorCode = $('#code-editor').val();

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
    });

    $('#sample-test').focusout(function() {
        let sampleTest = $('#sample-test').val();

        $.ajax({
            url : updateKataWebService,
            data : {
                'sampleTest' : sampleTest,
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
    });

});



