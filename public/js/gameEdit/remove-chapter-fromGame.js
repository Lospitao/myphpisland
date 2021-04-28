function removeChapterEvent(chapterToBeRemovedUuid, chapterTitleToBeRemovedFromGame, chapterToRemoveFromGame) {
    //Select element with id title (lesson title textarea)
    let title= document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");

    let updateLessonWebService = API_DOMAIN+'/api/v1/games/' + uuid + '/chapters/' + chapterToBeRemovedUuid ;

    $.ajax({

        url : updateLessonWebService,
        data : {
            'chapterToBeRemovedUuid' : chapterToBeRemovedUuid,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let chapterToReturnToAvailable =`<li class="ui-state-highlight availableChapterElement" data-title="${chapterTitleToBeRemovedFromGame}" data-uuid="${chapterToBeRemovedUuid}">${chapterTitleToBeRemovedFromGame}<a href="#"><i class="tiny material-icons availableChapter" data-title="${chapterTitleToBeRemovedFromGame}" data-uuid="${chapterToBeRemovedUuid}">add_circle</i></a></li>`;
            $( ".availableChapters" ).append(chapterToReturnToAvailable);
            $('.availableChapter[data-uuid="'+chapterToBeRemovedUuid+'"]').click(function() {
                let chapterToBeAddedTitle = $(this).attr("data-title");
                let chapterToBeAddedUuid = $(this).attr("data-uuid");
                let chapterToRemoveFromAvailable = $('.availableChapter[data-uuid="'+chapterToBeRemovedUuid+'"]').parent().parent();
                addChapterEvent(chapterToBeAddedUuid, chapterToBeAddedTitle, chapterToRemoveFromAvailable)
            });
            $(chapterToRemoveFromGame).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function removeChapterFromGameEvent() {

    $('.gameChapterRemoveIcon').click(function() {
        let chapterToBeRemovedUuid = $(this).attr("data-uuid");
        let chapterTitleToBeRemovedFromGame = $(this).attr("data-title");
        let chapterToRemoveFromGame = $(this).parent().parent();
        console.log("chapterToBeRemovedUuid");
        console.log(chapterToBeRemovedUuid);
        console.log("chapterTitleToBeRemovedFromGame");
        console.log(chapterTitleToBeRemovedFromGame);
        console.log("chapterToRemoveFromGame");
        console.log(chapterToRemoveFromGame)
        removeChapterEvent(chapterToBeRemovedUuid, chapterTitleToBeRemovedFromGame, chapterToRemoveFromGame);
    });
}

$(document).ready(function() {
    removeChapterFromGameEvent();
});
