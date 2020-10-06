$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;



    $('deleteKataFromLesson').click(function() {

        let kataUuid = $(this).attr("data-uuid");
        console.log(kataUuid);

        $.ajax({
            url : updateLessonWebService,
            data : {
                'kataUuid' : kataUuid,
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