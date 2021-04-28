function chapterIsAGameChapter(ui) {
    let elementClass = (ui.item.context).getAttribute("class");
    return elementClass.includes("gameChapterElement");
}
function updatePositionOfGameChaptersAfterSorting() {
    $( ".gameChapterElement" ).each(function( index, element ) {
        let title = document.getElementById("title");

        let uuid = title.getAttribute("data-uuid");
        let chapter_uuid = element.getAttribute("data-uuid");

        let position = index;
        let updateGameWebService = API_DOMAIN+'/api/v1/games/' + uuid + '/chapters/' + chapter_uuid;

        $.ajax({

            url : updateGameWebService,
            data : {
                'chapterUuid' : chapter_uuid,
                'position': position,
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
function addChapterToGameByDragAndDrop(ui) {
    function calculatePositionOfNewGameChapter() {
        var chaptersInGame = $('.gameChapterElement');
        return chaptersInGame.length;
    }
    let chapterToBeAddedTitle = (ui.item.context).getAttribute("data-title");
    let chapterToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
    let availableChapterSortable = ui.item;
    let sortableSender = ui.sender;
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateGameWebService = API_DOMAIN+'/api/v1/games/' + uuid + '/chapters';

    $.ajax({
        url : updateGameWebService,
        data : {
            'chapterToBeAddedUuid' : chapterToBeAddedUuid,
            'chapterToBeAddedTitle' : chapterToBeAddedTitle,
            'positionOfNewGameChapter' : calculatePositionOfNewGameChapter(),
        },
        type : 'POST',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');

            if (sortableSender) {
                //define newLessonKata
                let newGameChapter = `<li class="ui-state-highlight gameChapterElement ui-sortable-handle" data-title="${chapterToBeAddedTitle}" data-uuid="${chapterToBeAddedUuid}">${chapterToBeAddedTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${chapterToBeAddedTitle}" data-uuid="${chapterToBeAddedUuid}">clear</i></a></li>`;
                availableChapterSortable.replaceWith(newGameChapter);
            }
            updatePositionOfGameChaptersAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function removeChapterFromGameByDragAndDrop(ui) {
    let chapterToBeReturnedToAvailableTitle = (ui.item.context).getAttribute("data-title");
    let chapterToBeReturnedToAvailableUuid = (ui.item.context).getAttribute("data-uuid");
    let gameChapterSortable = ui.item;//Select element with id title (lesson title textarea)
    let sortableSender = ui.sender;
    let title= document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateChapterWebService = API_DOMAIN+'/api/v1/games/' + uuid + '/chapters/' + chapterToBeReturnedToAvailableUuid ;


    $.ajax({

        url : updateChapterWebService,
        data : {
            'chapterToBeRemovedUuid' : chapterToBeReturnedToAvailableUuid,
            'chapterTitleToBeRemovedFromLesson' : chapterToBeReturnedToAvailableTitle,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            if (sortableSender) {
                //define kataToBeReturned
                let chapterToBeReturned = `<li class="ui-state-highlight availableChapterElement ui-sortable-handle" data-title="${chapterToBeReturnedToAvailableTitle}" data-uuid="${chapterToBeReturnedToAvailableUuid}">${chapterToBeReturnedToAvailableTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${chapterToBeReturnedToAvailableTitle}" data-uuid="${chapterToBeReturnedToAvailableUuid}">add_circle</i></a></li>`;
                gameChapterSortable.replaceWith(chapterToBeReturned);
            }
            updatePositionOfGameChaptersAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function makeChapterListSortableFromAndToAvailableAndGameSections(){
    $( "#availableChaptersList, #gameChaptersList").sortable({
        connectWith: ".connectedSortable",
        receive: function (event, ui) {

            if (chapterIsAGameChapter (ui)) {
                removeChapterFromGameByDragAndDrop(ui);
            }
            else addChapterToGameByDragAndDrop(ui);
        },
        update: function (event,ui) {
            updatePositionOfGameChaptersAfterSorting();
        },
        revert:true,
    }).disableSelection();
}
$(document).ready(function() {
    makeChapterListSortableFromAndToAvailableAndGameSections();
});