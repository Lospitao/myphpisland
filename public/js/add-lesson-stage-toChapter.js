function calculatePositionOfNewElementAdded() {
    var ElementsInChapter = $('.ChapterLessonAndStageElement');
    return ElementsInChapter.length;
}
function addStageEvent(stageToBeAddedUuid, stageToBeAddedTitle, idInChapterElementTable, stageToRemoveFromAvailable) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/ChapterElements';


    $.ajax({

        url : updateChapterWebService,
        data : {
            'stageToBeAddedUuid' : stageToBeAddedUuid,
            'stageToBeAddedTitle' : stageToBeAddedTitle,
            'positionOfNewStageAdded' : calculatePositionOfNewElementAdded(),

        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newChapterStage = `<li class="ui-state-highlight ChapterLessonAndStageElement" data-id="${idInChapterElementTable}" data-title="${stageToBeAddedTitle}" data-uuid="${stageToBeAddedUuid}">${stageToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterStage" data-title="${stageToBeAddedTitle}" data-uuid="${stageToBeAddedUuid}">clear</i></a></li>`;
            $( ".ChapterLessonsAndStages" ).append(newChapterStage);
            $('.chapterStage[data-uuid="'+stageToBeAddedUuid+'"]').click(function() {
                let stageTitleToBeRemovedFromChapter = $(this).attr("data-title");
                let stageToBeRemovedUuid = $(this).attr("data-uuid");
                let stageToRemoveFromChapter = $('.chapterStage[data-uuid="'+stageToBeAddedUuid+'"]').parent().parent();
                removeStageEvent(stageToBeRemovedUuid, stageTitleToBeRemovedFromChapter, stageToRemoveFromChapter);
            });
            $(stageToRemoveFromAvailable).remove();
        },
        error: function (data) {
            console.log('An error occurred.');

        },
    })
}

function addLessonEvent(lessonToBeAddedUuid, lessonToBeAddedTitle, idInChapterElementTable,lessonToRemoveFromAvailable) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/ChapterElements';


    $.ajax({

        url : updateChapterWebService,
        data : {
            'lessonToBeAddedUuid' : lessonToBeAddedUuid,
            'lessonToBeAddedTitle' : lessonToBeAddedTitle,
            'positionOfNewLessonAdded' : calculatePositionOfNewElementAdded(),
        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newChapterLesson = `<li class="ui-state-highlight ChapterLessonAndStageElement" data-id="${idInChapterElementTable}" data-title="${lessonToBeAddedTitle}" data-uuid="${lessonToBeAddedUuid}">${lessonToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterLesson" data-title="${lessonToBeAddedTitle}" data-uuid="${lessonToBeAddedUuid}">clear</i></a></li>`;
            $( ".ChapterLessonsAndStages" ).append(newChapterLesson);
            $('.chapterLesson[data-uuid="'+lessonToBeAddedUuid+'"]').click(function() {
                let lessonTitleToBeRemovedFromChapter = $(this).attr("data-title");
                let lessonToBeRemovedUuid = $(this).attr("data-uuid");
                let lessonToRemoveFromChapter = $('.chapterLesson[data-uuid="'+lessonToBeAddedUuid+'"]').parent().parent();
                removeLessonEvent(lessonToBeRemovedUuid, lessonTitleToBeRemovedFromChapter, lessonToRemoveFromChapter);
            });
            $(lessonToRemoveFromAvailable).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function addAvailableStageToChapterEvent() {

    $('.availableStage').click(function() {
        let stageToBeAddedUuid = $(this).attr("data-uuid");
        let stageToBeAddedTitle = $(this).attr("data-title");
        let idInChapterElementTable = $(this).attr("data-id");
        let stageToRemoveFromAvailable = $(this).parent().parent();
        addStageEvent(stageToBeAddedUuid, stageToBeAddedTitle, idInChapterElementTable, stageToRemoveFromAvailable);
    });
}

function addAvailableLessonToChapterEvent() {

    $('.availableLesson').click(function() {
        let lessonToBeAddedUuid = $(this).attr("data-uuid");
        let lessonToBeAddedTitle = $(this).attr("data-title");
        let idInChapterElementTable = $(this).attr("data-id");
        let lessonToRemoveFromAvailable = $(this).parent().parent();
        addLessonEvent(lessonToBeAddedUuid, lessonToBeAddedTitle, idInChapterElementTable, lessonToRemoveFromAvailable);
    });
}


$(document).ready(function() {
    addAvailableStageToChapterEvent();
    addAvailableLessonToChapterEvent();
});