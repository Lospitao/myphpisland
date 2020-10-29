function addKataEvent (kataUuid, kataToBeAdded, removingKata) {
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;


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
            let newLessonKata = `<li >${kataToBeAdded}<a href="#"><i class="tiny material-icons removeKataFromLesson" data-title="${kataToBeAdded}" data-uuid="${kataUuid}">clear</i></a></li>`;
            $( ".lessonKatas" ).append(newLessonKata);

            $('.removeKataFromLesson[data-uuid="'+kataUuid+'"]').click(function() {
               let kataToBeRemovedFromLesson = $(this).attr("data-title");
                let removingKata = $('.removeKataFromLesson[data-uuid="'+kataUuid+'"]').parent().parent();
                removeKataEvent(kataUuid, kataToBeRemovedFromLesson, removingKata);
            });
            $(removingKata).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function addAvailableKataToLessonEventToClickEvents() {

    $('.addAvailableKataToLesson').click(function() {
        let kataUuid = $(this).attr("data-uuid");
        let kataToBeAdded = $(this).attr("data-title");
        let removingKata = $(this).parent().parent();
        addKataEvent(kataUuid, kataToBeAdded, removingKata);
    });
}

$(document).ready(function() {
    addAvailableKataToLessonEventToClickEvents();
});
