function removeKataEvent (kataUuid, kataToBeRemovedFromLesson, removingKata) {
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;


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
            let kataToRemoveFromLesson =`<li>${kataToBeRemovedFromLesson}<a><i class="tiny material-icons addAvailableKataToLesson" data-title="${kataToBeRemovedFromLesson}" data-uuid="${kataUuid}">add_circle</i></a></li>`;
            $( ".availableKatas" ).append(kataToRemoveFromLesson);
            $('.addAvailableKataToLesson[data-uuid="'+kataUuid+'"]').click(function() {
                let kataToBeAdded = $(this).attr("data-title");
                let removingKata = $('.addAvailableKataToLesson[data-uuid="'+kataUuid+'"]').parent().parent();
                addKataEvent(kataUuid, kataToBeAdded, removingKata);
            });
            $(removingKata).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function removeKataFromLessonEventToClickEvents() {

    $('.removeKataFromLesson').click(function() {
        let kataUuid = $(this).attr("data-uuid");
        let kataToBeRemovedFromLesson = $(this).attr("data-title");
        let removingKata = $(this).parent().parent();
        removeKataEvent(kataUuid, kataToBeRemovedFromLesson, removingKata);
    });
}

$(document).ready(function() {
    removeKataFromLessonEventToClickEvents();
});
