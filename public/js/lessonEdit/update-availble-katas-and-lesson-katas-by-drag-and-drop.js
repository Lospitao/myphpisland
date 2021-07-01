function kataIsALessonKata (ui) {
    let elementClass = (ui.item.context).getAttribute("class");
    return elementClass.includes("lessonKataElement");
}
//Define function to update position
function updatePositionOfLessonKatasAfterSorting() {
    $( ".lessonKataElement" ).each(function( index, element ) {
        //Select element with id title (lesson title textarea)
        let title = document.getElementById("title");
        //get lesson uuid
        let lesson_uuid = title.getAttribute("data-uuid");
        let kata_uuid = element.getAttribute("data-uuid");
        let position = index;
        let updateLessonWebService = API_DOMAIN+'/api/v1/lessons/' + lesson_uuid + '/katas/' + kata_uuid;

        $.ajax({

            url : updateLessonWebService,
            data : {
                'kataUuid' : kata_uuid,
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

function addKataToLessonByDragAndDrop (ui) {

    function calculatePositionOfNewLessonKata() {
        var katasInLesson = $('.lessonKataElement');
        return katasInLesson.length;
    }
    let kataToBeAddedTitle = (ui.item.context).getAttribute("data-title");
    let kataToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
    let availableKataSortable = ui.item;
    let sortableSender = ui.sender;
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = API_DOMAIN+'/api/v1/lessons/' + uuid + '/katas';

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

            if (sortableSender) {
                //define newLessonKata
                let newLessonKata = `<li class="ui-state-highlight lessonKataElement ui-sortable-handle" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">${kataToBeAddedTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">clear</i></a></li>`;
                availableKataSortable.replaceWith(newLessonKata);
            }
            updatePositionOfLessonKatasAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function removeKataFromLessonByDragAndDrop (ui) {

    let kataToBeReturnedToAvailableTitle = (ui.item.context).getAttribute("data-title");
    let kataToBeReturnedToAvailableUuid = (ui.item.context).getAttribute("data-uuid");
    let lessonKataSortable = ui.item;//Select element with id title (lesson title textarea)
    let sortableSender = ui.sender;
    let title= document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = API_DOMAIN+'/api/v1/lessons/' + uuid + '/katas/' + kataToBeReturnedToAvailableUuid ;


    $.ajax({

        url : updateLessonWebService,
        data : {
            'kataToBeRemovedUuid' : kataToBeReturnedToAvailableUuid,
            'kataTitleToBeRemovedFromLesson' : kataToBeReturnedToAvailableTitle,
        },
        type : 'DELETE',
        dataType : 'json',
        success: function (data) {
            console.log('Submission was successful.');
            if (sortableSender) {
                //define kataToBeReturned
                let kataToBeReturned = `<li class="ui-state-highlight availableKataElement ui-sortable-handle" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">${kataToBeReturnedToAvailableTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">add_circle</i></a></li>`;
                lessonKataSortable.replaceWith(kataToBeReturned);
            }
            updatePositionOfLessonKatasAfterSorting();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function makeKataListSortableFromAndToAvailableAndLessonSections() {

    $( "#availableKatasList, #lessonKatasList").sortable({
        connectWith: ".connectedSortable",
        cursor: "pointer",
        receive: function (event, ui) {

            if (kataIsALessonKata(ui)) {
                removeKataFromLessonByDragAndDrop(ui);
            }
            else addKataToLessonByDragAndDrop(ui);

        },
        update: function (event,ui) {
          updatePositionOfLessonKatasAfterSorting();
        },
        revert:true,
    }).disableSelection();
}
$(document).ready(function() {
    makeKataListSortableFromAndToAvailableAndLessonSections();
});

