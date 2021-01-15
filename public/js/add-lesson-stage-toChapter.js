function addStageEvent(stageToBeAddedUuid, stageToBeAddedTitle, stageToRemoveFromAvailable) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateLessonWebService = 'http://localhost:8000/api/v1/chapters/' + chapterUuid + '/element';


    $.ajax({

        url : updateLessonWebService,
        data : {
            'stageToBeAddedUuid' : stageToBeAddedUuid,
            'stageToBeAddedTitle' : stageToBeAddedTitle,

        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newChapterStage = `<li >${stageToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterStage" data-title="${stageToBeAddedTitle}" data-uuid="${stageToBeAddedUuid}">clear</i></a></li>`;
            $( ".chapter_lessons_stages_collection" ).append(newChapterStage);
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

function addLessonEvent(lessonToBeAddedUuid, lessonToBeAddedTitle, lessonToRemoveFromAvailable) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateLessonWebService = 'http://localhost:8000/api/v1/chapters/' + chapterUuid + '/element';


    $.ajax({

        url : updateLessonWebService,
        data : {
            'lessonToBeAddedUuid' : lessonToBeAddedUuid,
            'lessonToBeAddedTitle' : lessonToBeAddedTitle,

        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let newChapterLesson = `<li >${lessonToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterLesson" data-title="${lessonToBeAddedTitle}" data-uuid="${lessonToBeAddedUuid}">clear</i></a></li>`;
            $( ".chapter_lessons_stages_collection" ).append(newChapterLesson);
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
        let stageToRemoveFromAvailable = $(this).parent().parent();
        addStageEvent(stageToBeAddedUuid, stageToBeAddedTitle, stageToRemoveFromAvailable);
    });
}

function addAvailableLessonToChapterEvent() {

    $('.availableLesson').click(function() {
        let lessonToBeAddedUuid = $(this).attr("data-uuid");
        let lessonToBeAddedTitle = $(this).attr("data-title");
        let lessonToRemoveFromAvailable = $(this).parent().parent();
        addLessonEvent(lessonToBeAddedUuid, lessonToBeAddedTitle, lessonToRemoveFromAvailable);
    });
}


$(document).ready(function() {
    addAvailableStageToChapterEvent();
    addAvailableLessonToChapterEvent();
});