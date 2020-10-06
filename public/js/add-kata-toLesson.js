
$(document).ready(function() {

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;



    $('.addAvailableKataToLesson').click(function() {


        let kataUuid = $(this).attr("data-uuid");


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






/*




$(document).ready(function() {
    //Get lesson_uuid to build url

    let title = document.getElementById("title");
    let uuid = title.getAttribute("data-uuid")

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas/';

    $(".addAvailableKataToLesson").on("click", function(){

        $.ajax({
            url : updateLessonWebService,
            data : {
                'message': 'it worked'
            },
            type : 'POST',
            dataType : 'json',
            success: function (data) {
                console.log('Kata added successfully.');
                console.log(data)

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })

    });

});


 */