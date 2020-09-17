
$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid")

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid;

    console.log(updateLessonWebService)

    $('#title').focusout(function() {
        let title_text = $('#title').val();
        $.ajax({
            url : updateLessonWebService,
            data : {
                'title' : title_text,
            },
            type : 'PATCH',
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
