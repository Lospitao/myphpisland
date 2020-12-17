function addChapterEvent(chapterToBeAddedUuid, chapterToBeAddedTitle, chapterToRemoveFromAvailable) {
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get game uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/games/' + uuid + '/chapters' ;


    $.ajax({

        url : updateLessonWebService,
        data : {
            'ChapterToBeAddedUuid' : chapterToBeAddedUuid,
            'ChapterToBeAddedTitle' : chapterToBeAddedTitle,
        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newGameChapter = `<li >${chapterToBeAddedTitle}<a href="#"><i class="tiny material-icons gameChapter" data-title="${chapterToBeAddedTitle}" data-uuid="${chapterToBeAddedUuid}">clear</i></a></li>`;
            $( ".gameChapters" ).append(newGameChapter);
            $('.gameChapter[data-uuid="'+chapterToBeAddedUuid+'"]').click(function() {
                let chapterTitleToBeRemovedFromGame = $(this).attr("data-title");
                let chapterToBeRemovedUuid = $(this).attr("data-uuid");
                let chapterToRemoveFromGame = $('.gameChapter[data-uuid="'+chapterToBeAddedUuid+'"]').parent().parent();
                removeChapterEvent(chapterToBeRemovedUuid, chapterTitleToBeRemovedFromGame, chapterToRemoveFromGame);
            });
            $(chapterToRemoveFromAvailable).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function addAvailableChapterToGameEvent() {

    $('.availableChapter').click(function() {
        let chapterToBeAddedUuid = $(this).attr("data-uuid");
        let chapterToBeAddedTitle = $(this).attr("data-title");
        let chapterToRemoveFromAvailable = $(this).parent().parent();
        addChapterEvent(chapterToBeAddedUuid, chapterToBeAddedTitle, chapterToRemoveFromAvailable);

    });
}

$(document).ready(function() {
    addAvailableChapterToGameEvent();
});
