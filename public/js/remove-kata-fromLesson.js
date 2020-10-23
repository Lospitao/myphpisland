
$(document).ready(function() {

    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;

    $('.removeKataFromLesson').click(function() {

        let kataUuid = $(this).attr("data-uuid");
        let kataToBeRemovedFromLesson = $(this).attr("data-title");
        let removingKata = $(this).parent().parent();

        $.ajax({

            url : updateLessonWebService,
            data : {
                'kataUuid' : kataUuid,
                'kataToBeRemovedFromLesson' : kataToBeRemovedFromLesson,

            },
            type : 'POST',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
                let kataToRemoveFromLesson =`<li>${kataToBeRemovedFromLesson}<a><i class="tiny material-icons addAvailableKataToLesson" data-title="${kataToBeRemovedFromLesson}" data-uuid="${kataUuid}">add_circle</i></a><br></li>`;
                $( ".availableKatasList" ).append(kataToRemoveFromLesson);
                $(removingKata).remove();

                //IT IS NECESSARY TO ASSING THE CLICK EVENT AS DOCUMENT IS ALREADY READY WHEN WE ADD THE NEW EVENT TO THE DOM AND OTHERWISE THE EVENT WOULD NOT TRIGGER
                $('.addAvailableKataToLesson').click(function() {

                    //Select element with id title (lesson title textarea)
                    let title = document.getElementById("title");
                    //get lesson uuid
                    let uuid = title.getAttribute("data-uuid");

                    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;
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
                        success: function (data) {
                            console.log('Submission was successful.');
                            let newLessonKata = `<li>${kataToBeAdded}<a href="#"><i class="tiny material-icons removeKataFromLesson data-title="${kataToBeAdded}" data-uuid="${kataUuid}"">clear</i></a></li><br>`;
                            $( ".lessonKatas" ).append(newLessonKata);
                            $(removingKata).remove();
                        },
                        error: function (data) {
                            console.log('An error occurred.');

                        },
                    })
                });

            },
            error: function (data) {
                console.log('An error occurred.');

            },
        })

    });
});

