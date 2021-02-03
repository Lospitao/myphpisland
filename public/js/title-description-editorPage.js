

$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid")

    let updateKataWebService = '/api/v1/katas/' + uuid;


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
    $('#kata-test.code').focusout(function() {
        let kata_test_code = $('#kata-test.code').val();
        $.ajax({
            url : updateKataWebService,
            data : {
                'kataTestCode' : kata_test_code,
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



