function removeLessonEvent(lessonToBeRemovedUuid, lessonTitleToBeRemovedFromChapter, idElementChapter, lessonToRemoveFromChapter) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid+ '/chapterelements/' + idElementChapter;

    $.ajax({

        url : updateChapterWebService,
        data : {
            'lessonToBeRemovedUuid' : lessonToBeRemovedUuid,
            'lessonTitleToBeRemovedFromChapter' : lessonTitleToBeRemovedFromChapter,
            'idElementChapter' : idElementChapter,

        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let lessonToReturnToAvailable =`<li class="ui-state-default availableLessonElement" data-title="${lessonTitleToBeRemovedFromChapter}" data-uuid="${lessonToBeRemovedUuid}">${lessonTitleToBeRemovedFromChapter}<a href="#"><i class="tiny material-icons availableLesson" data-title="${lessonTitleToBeRemovedFromChapter}" data-uuid="${lessonToBeRemovedUuid}">add_circle</i></a></li>`;
            $( ".availableLessons" ).append(lessonToReturnToAvailable);
            $('.availableLesson[data-uuid="'+lessonToBeRemovedUuid+'"]').click(function() {
                let lessonToBeAddedTitle = $(this).attr("data-title");
                let lessonToBeAddedUuid = $(this).attr("data-uuid");
                let lessonToRemoveFromAvailable = $('.availableLesson[data-uuid="'+lessonToBeRemovedUuid+'"]').parent().parent();
                addLessonEvent(lessonToBeAddedUuid, lessonToBeAddedTitle, lessonToRemoveFromAvailable);
            });
            $(lessonToRemoveFromChapter).remove();
        },

        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function removeStageEvent(stageToBeRemovedUuid, stageTitleToBeRemovedFromChapter, idElementChapter, stageToRemoveFromChapter) {
    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid+ '/chapterelements/' + idElementChapter;


    $.ajax({

        url : updateChapterWebService,
        data : {
            'stageToBeRemovedUuid' : stageToBeRemovedUuid,
            'stageTitleToBeRemovedFromChapter' : stageTitleToBeRemovedFromChapter,
            'idElementChapter' : idElementChapter,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            let stageToReturnToAvailable =`<li class="ui-state-default availableStageElement" data-title="${stageTitleToBeRemovedFromChapter}" data-uuid="${stageToBeRemovedUuid}">${stageTitleToBeRemovedFromChapter}<a href="#"><i class="tiny material-icons availableStage" data-title="${stageTitleToBeRemovedFromChapter}" data-uuid="${stageToBeRemovedUuid}">add_circle</i></a></li>`;
            $( ".availableStages" ).append(stageToReturnToAvailable);
            $('.availableStage[data-uuid="'+stageToBeRemovedUuid+'"]').click(function() {
                let stageToBeAddedTitle = $(this).attr("data-title");
                let stageToBeAddedUuid = $(this).attr("data-uuid");
                let stageToRemoveFromAvailable = $('.availableStage[data-uuid="'+stageToBeRemovedUuid+'"]').parent().parent();
                addStageEvent(stageToBeAddedUuid, stageToBeAddedTitle, stageToRemoveFromAvailable);

            });
            $(stageToRemoveFromChapter).remove();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function removeStageFromChapterEvent() {

    $('.chapterStage').click(function() {
        let stageToBeRemovedUuid = $(this).attr("data-uuid");
        let stageTitleToBeRemovedFromChapter = $(this).attr("data-title");
        let idElementChapter = $(this).parent().parent().attr("data-id");
        let stageToRemoveFromChapter = $(this).parent().parent();
        removeStageEvent(stageToBeRemovedUuid, stageTitleToBeRemovedFromChapter, idElementChapter, stageToRemoveFromChapter);
    });
}
function removeLessonFromChapterEvent() {

    $('.chapterLesson').click(function() {
        let lessonToBeRemovedUuid = $(this).attr("data-uuid");
        let lessonTitleToBeRemovedFromChapter = $(this).attr("data-title");
        let idElementChapter = $(this).parent().parent().attr("data-id");
        let lessonToRemoveFromChapter = $(this).parent().parent();
        removeLessonEvent(lessonToBeRemovedUuid, lessonTitleToBeRemovedFromChapter, idElementChapter, lessonToRemoveFromChapter);
    });
}
$(document).ready(function() {
    removeStageFromChapterEvent();
    removeLessonFromChapterEvent();
});