
$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;



    $('.addAvailableKataToLesson').click(function() {


        let kataUuid = $(this).attr("data-uuid");
        let kataToBeAdded = $("#relevantKAta").text();

        console.log("kataToBeAdded: " + kataToBeAdded);

        $.ajax({

            url : updateLessonWebService,
            data : {
                'kataUuid' : kataUuid,
                'kataToBeAdded' : kataToBeAdded,
            },
            type : 'POST',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');

                $( "#lessonKatasList" ).append(kataToBeAdded+"<a>" + "<i class=\"tiny material-icons addAvailableKataToLesson\">" + "clear" + "</i>" + "</a>" );

            },
            error: function (data) {
                console.log('An error occurred.');

            },
        })
    });
});

