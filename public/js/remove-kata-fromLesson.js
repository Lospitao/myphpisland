function removeKataEvent(kataToBeRemovedUuid, kataTitleToBeRemovedFromLesson, kataToRemoveFromLesson) {
    //Select element with id title (lesson title textarea)
    let title= document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas/' + kataToBeRemovedUuid;



    $.ajax({

        url : updateLessonWebService,
        data : {
            'kataToBeRemovedUuid' : kataToBeRemovedUuid,
            'kataTitleToBeRemovedFromLesson' : kataTitleToBeRemovedFromLesson,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let kataToReturnToAvailable =`<li class="ui-state-default availableKataElement" data-title="${kataTitleToBeRemovedFromLesson}" data-uuid="${kataToBeRemovedUuid}">${kataTitleToBeRemovedFromLesson}<a href="#"><i class="tiny material-icons availableKata" data-title="${kataTitleToBeRemovedFromLesson}" data-uuid="${kataToBeRemovedUuid}">add_circle</i></a></li>`;
            $( ".availableKatas" ).append(kataToReturnToAvailable);
            $('.availableKata[data-uuid="'+kataToBeRemovedUuid+'"]').click(function() {
                let kataToBeAddedTitle = $(this).attr("data-title");
                let kataToBeAddedUuid = $(this).attr("data-uuid");
                let kataToRemoveFromAvailable = $('.availableKata[data-uuid="'+kataToBeRemovedUuid+'"]').parent().parent();
                addKataEvent(kataToBeAddedUuid, kataToBeAddedTitle, kataToRemoveFromAvailable);
            });
            $(kataToRemoveFromLesson).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function removeKataFromLessonEvent() {

    $('.lessonKata').click(function() {
        let kataToBeRemovedUuid = $(this).attr("data-uuid");
        let kataTitleToBeRemovedFromLesson = $(this).attr("data-title");
        let kataToRemoveFromLesson = $(this).parent().parent();
        removeKataEvent(kataToBeRemovedUuid, kataTitleToBeRemovedFromLesson, kataToRemoveFromLesson);
    });
}

$(document).ready(function() {
    removeKataFromLessonEvent();
});