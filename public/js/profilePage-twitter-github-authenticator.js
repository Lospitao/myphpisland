$(document).ready(function() {

    let element = document.getElementById("username");
    let username = element.getAttribute("class")

    let updateLessonWebService = 'https://localhost:8000/api/v1/users/' + username;



    $('#github-link').click(function() {

        $.ajax({
            url : 'https://github.com/login/oauth/authorize',
            data : {

            },
            type : 'FETCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data)
                alert(data['result_message'])
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });

    $('#twitter.link').click(function() {

        $.ajax({
            url : updateLessonWebService,
            data : {

            },
            type : 'POST',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data)
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });
});

