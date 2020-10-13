
$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;



    $('.addAvailableKataToLesson').click(function() {


        let kataUuid = $(this).attr("data-uuid");
        let kataToBeAdded = $("#relevantKata").text();
        console.log(kataToBeAdded);

        $.ajax({
            statusCode: {
                204: function() {
                    $( "#lessonKatasList" ).append("<li>" + kataToBeAdded + "</li>");
                }
            },
            url : updateLessonWebService,
            data : {
                'kataUuid' : kataUuid,
                'kataToBeAdded' : kataToBeAdded,
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

