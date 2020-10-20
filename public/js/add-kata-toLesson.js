
$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;



    $('.addAvailableKataToLesson').click(function() {


        let kataUuid = $(this).attr("data-uuid");
        let kataToBeAdded = $(this).attr("data-title");
        let removingKata = $(this).parent().parent();



        $.ajax({

            url : updateLessonWebService,
            data : {
                'kataUuid' : kataUuid,
                'kataToBeAdded' : kataToBeAdded,

            },
            type : 'POST',
            dataType : 'json',
            success: function (data, thisParameter) {
                console.log('Submission was successful.');
                let newLessonKata = kataToBeAdded + "<a>" + "<i class=\"tiny material-icons addAvailableKataToLesson\">" + "clear" + "</i>" + "</a>"+ "<br>";

                $( ".lessonKatasList" ).append(newLessonKata);
                $(removingKata).remove();
            },
            error: function (data) {
                console.log('An error occurred.');

            },
        })
    });
});

