$(document).ready(function() {

    let element = document.getElementById("username");
    let username = element.getAttribute("class")

    let updateLessonWebService = 'https://localhost:8000/api/v1/users/' + username;



    $('#update_password').click(function() {
        let current_password = $('#current_password').val();
        let new_password = $('#new_password').val();
        let repeat_password = $('#repeat_password').val();
        $.ajax({
            url : updateLessonWebService,
            data : {
                'username' : username,
                'current_password' : current_password,
                'new_password' : new_password,
                'repeat_password' : repeat_password,
            },
            type : 'POST',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
                alert(data['laura']);

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });
});
