


function addKataEvent(kataToBeAddedUuid, kataToBeAddedTitle, kataToRemoveFromAvailable) {
    function calculatePositionOfNewLessonKata() {
        var katasInLesson = $('.lessonKataElement');
        var totalKatasInLesson = katasInLesson.length;
        return totalKatasInLesson;
    }
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'http://localhost:8000/api/v1/lessons/' + uuid + '/katas' ;

    $.ajax({

        url : updateLessonWebService,
        data : {
            'kataToBeAddedUuid' : kataToBeAddedUuid,
            'kataToBeAddedTitle' : kataToBeAddedTitle,
            'positionOfNewLessonKata' : calculatePositionOfNewLessonKata(),
            },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newLessonKata = `<li class="ui-state-highlight lessonKataElement" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">${kataToBeAddedTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">clear</i></a></li>`;
            $( ".lessonKatas" ).append(newLessonKata);
            $('.lessonKata[data-uuid="'+kataToBeAddedUuid+'"]').click(function() {
               let kataTitleToBeRemovedFromLesson = $(this).attr("data-title");
               let kataToBeRemovedUuid = $(this).attr("data-uuid");
               let kataToRemoveFromLesson = $('.lessonKata[data-uuid="'+kataToBeAddedUuid+'"]').parent().parent();
                removeKataEvent(kataToBeRemovedUuid, kataTitleToBeRemovedFromLesson, kataToRemoveFromLesson);
            });
            $(kataToRemoveFromAvailable).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function addAvailableKataToLessonEvent() {

    $('.availableKata').click(function() {
        let kataToBeAddedUuid = $(this).attr("data-uuid");
        let kataToBeAddedTitle = $(this).attr("data-title");
        let kataToRemoveFromAvailable = $(this).parent().parent();
        addKataEvent(kataToBeAddedUuid, kataToBeAddedTitle, kataToRemoveFromAvailable);
    });
}

$(document).ready(function() {
    addAvailableKataToLessonEvent();
});
