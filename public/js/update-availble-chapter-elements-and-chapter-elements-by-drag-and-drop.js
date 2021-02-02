/*COMMON FUNCTIONALITIES*/

function updatePositionOfChapterElementsAfterSorting (ui) {
    $( ".ChapterLessonAndStageElement" ).each(function( index, element ) {

        let chapterTitle = document.getElementById("chapter-title");
        let chapterUuid = chapterTitle.getAttribute("data-uuid");
        let chapterElementId = element.getAttribute("data-id")
        let position = index;
        let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/chapterelements/' + chapterElementId;
        $.ajax({

            url : updateChapterWebService,
            data : {
                'position': position,
                'chapterElementId': chapterElementId,
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
            },
            error: function (data) {
                console.log('An error occurred.');

            },
        })

    });
}
/*STAGE SORTABLE FUNCTIONALITY*/

function removeStageFromChapterByDragAndDrop(ui) {

    let chapterStageToBeRemovedTitle = (ui.item.context).getAttribute("data-title");
    let chapterStageToBeRemovedUuid = (ui.item.context).getAttribute("data-uuid");
    let chapterStageToBeRemovedId = (ui.item.context).getAttribute("data-id");
    let chapterStageSortable = ui.item;
    let sortableSender = ui.sender;

    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid");
    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/chapterelements/' + chapterStageToBeRemovedId;

    $.ajax({

        url : updateChapterWebService,
        data : {
            'chapterStageToBeRemovedTitle' : chapterStageToBeRemovedTitle,
            'chapterStageToBeRemovedUuid' : chapterStageToBeRemovedUuid,
            'idChapterElement' : chapterStageToBeRemovedId,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            if (sortableSender) {
                let chapterStageToBeReturnedToAvailable = `<li class="ui-state-default availableStageElement ui-sortable-handle" data-title="${chapterStageToBeRemovedTitle}" data-uuid="${chapterStageToBeRemovedUuid}">${chapterStageToBeRemovedTitle}<a href="#"><i class="tiny material-icons availableStage" data-title="${chapterStageToBeRemovedTitle}" data-uuid="${chapterStageToBeRemovedUuid}">add_circle</i></a></li>`;
                chapterStageSortable.replaceWith(chapterStageToBeReturnedToAvailable);
            }
            updatePositionOfChapterElementsAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function addStageToChapterByDragAndDrop(ui) {
    function calculatePositionOfNewChapterElement(ui) {
        let elementsInChapter = $('.ChapterLessonAndStageElement');
        return elementsInChapter.length;
    }
    let stageToBeAddedTitle = (ui.item.context).getAttribute("data-title");
    let stageToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
    let availableStageSortable = ui.item;
    let sortableSender = ui.sender;

    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid");
    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/chapterelements';

    $.ajax({
        url : updateChapterWebService,
        data : {
            'stageToBeAddedTitle' : stageToBeAddedTitle,
            'stageToBeAddedUuid' : stageToBeAddedUuid,
            'positionOfNewChapterStage' : calculatePositionOfNewChapterElement(),
        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            console.log('Stage properly added');
            let idChapterElement = data.idChapterElement;
            if (sortableSender) {
                //define newLessonKata
                let newChapterStage = `<li class="ui-state-highlight ChapterLessonAndStageElement" data-title="${stageToBeAddedTitle}" data-uuid="${stageToBeAddedUuid}" data-id="${idChapterElement}">${stageToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterStage" data-title="${stageToBeAddedTitle}" data-uuid="${stageToBeAddedUuid}">clear</i></a></li>`;
                availableStageSortable.replaceWith(newChapterStage);
            }
            updatePositionOfChapterElementsAfterSorting ();
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log('Problem adding stage');
        },
    })
}

/*LESSON SORTABLE FUNCTIONALITY*/

function addLessonToChapterByDragAndDrop (ui) {
    function calculatePositionOfNewChapterElement() {
        let elementsInChapter = $('.ChapterLessonAndStageElement');
        return elementsInChapter.length;
    }
    let lessonToBeAddedTitle = (ui.item.context).getAttribute("data-title");
    let lessonToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
    let availableLessonSortable = ui.item;
    let sortableSender = ui.sender;

    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid");
    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/chapterelements';

    $.ajax({
        url : updateChapterWebService,
        data : {
            'lessonToBeAddedUuid' : lessonToBeAddedUuid,
            'lessonToBeAddedTitle' : lessonToBeAddedTitle,
            'positionOfNewChapterLesson' : calculatePositionOfNewChapterElement(),
        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            console.log('Lesson properly added');
            let idChapterElement = data.idChapterElement;
            if (sortableSender) {
                //define newLessonKata
                let newChapterLesson = `<li class="ui-state-highlight ChapterLessonAndStageElement" data-title="${lessonToBeAddedTitle}" data-uuid="${lessonToBeAddedUuid}" data-id="${idChapterElement}">${lessonToBeAddedTitle}<a href="#"><i class="tiny material-icons chapterLesson" data-title="${lessonToBeAddedTitle}" data-uuid="${lessonToBeAddedUuid}">clear</i></a></li>`;
                availableLessonSortable.replaceWith(newChapterLesson);
            }
            updatePositionOfChapterElementsAfterSorting ();
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log('Problem adding lesson');
        },
    })
}
function removeLessonFromChapterByDragAndDrop (ui) {

    let chapterLessonToBeRemovedTitle = (ui.item.context).getAttribute("data-title");
    let chapterLessonToBeRemovedUuid = (ui.item.context).getAttribute("data-uuid");
    let chapterLessonToBeRemovedId = (ui.item.context).getAttribute("data-id");
    let chapterLessonSortable = ui.item;
    let sortableSender = ui.sender;

    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid");
    let updateChapterWebService = 'https://localhost:8000/api/v1/chapters/' + chapterUuid + '/chapterelements/' + chapterLessonToBeRemovedId;

    $.ajax({

        url : updateChapterWebService,
        data : {
            'chapterLessonToBeRemovedTitle' : chapterLessonToBeRemovedTitle,
            'chapterLessonToBeRemovedUuid' : chapterLessonToBeRemovedUuid,
            'idChapterElement': chapterLessonToBeRemovedId,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            if (sortableSender) {
                let chapterLessonToBeReturnedToAvailable = `<li class="ui-state-default availableLessonElement ui-sortable-handle" data-title="${chapterLessonToBeRemovedTitle}" data-uuid="${chapterLessonToBeRemovedUuid}">${chapterLessonToBeRemovedTitle}<a href="#"><i class="tiny material-icons availableLesson" data-title="${chapterLessonToBeRemovedTitle}" data-uuid="${chapterLessonToBeRemovedUuid}">add_circle</i></a></li>`;
                chapterLessonSortable.replaceWith(chapterLessonToBeReturnedToAvailable);
            }
            updatePositionOfGameChaptersAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function draggedElementIsALesson(ui) {
    let elementClass = (ui.item.context).getAttribute("class");
    return elementClass.includes("availableLessonElement");
}
function draggedElementIsAChapterElement (ui) {
    let elementClass = (ui.item.context).getAttribute("class");
    return elementClass.includes("ChapterLessonAndStageElement");
}

function makeListsSortable () {
    $( "#availableLessonsList, #availableStagesList, #ChapterLessonsAndStagesCollectionList").sortable({
        connectWith: ".connectedSortable",
        receive: function (event, ui) {
            if (draggedElementIsALesson(ui)) {
                if (draggedElementIsAChapterElement(ui)) {
                    removeLessonFromChapterByDragAndDrop(ui);
                }
                else addLessonToChapterByDragAndDrop(ui);
            }
            else {
                if (draggedElementIsAChapterElement(ui)) {
                    removeStageFromChapterByDragAndDrop(ui);
                }
                else addStageToChapterByDragAndDrop(ui);
            }

        },
        update: function (event,ui) {
            updatePositionOfChapterElementsAfterSorting();
        },

        revert:true,
    }).disableSelection();
}

$(document).ready(function() {
    makeListsSortable();
});