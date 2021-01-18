//Define function to update position
function updatePositionKatasList() {
    $( ".lessonKataElement" ).each(function( index, element ) {
        //Select element with id title (lesson title textarea)
        let title = document.getElementById("title");
        //get lesson uuid
        let lesson_uuid = title.getAttribute("data-uuid");
        let kata_uuid = element.getAttribute("data-uuid");
        let position = index;
        let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + lesson_uuid + '/katas/' + kata_uuid;

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

function addKataToLessonByDragAndDrop (kataToBeAddedTitle, kataToBeAddedUuid, availableKataSortable, sortablesender) {
    function calculatePositionOfNewLessonKata() {
        var katasInLesson = $('.lessonKataElement');
        return katasInLesson.length;
    }
    //Select element with id title (lesson title textarea)
    let title = document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas';

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

            if (sortablesender) {
                //define newLessonKata
                let newLessonKata = `<li class="ui-state-highlight lessonKataElement ui-sortable-handle" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">${kataToBeAddedTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">clear</i></a></li>`;
                availableKataSortable.replaceWith(newLessonKata);
            }
            updatePositionKatasList();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function removeKataFromLessonByDragAndDrop (kataToBeReturnedToAvailableTitle, kataToBeReturnedToAvailableUuid, lessonKataSortable, sortablesender) {
    //Select element with id title (lesson title textarea)
    let title= document.getElementById("title");
    //get lesson uuid
    let uuid = title.getAttribute("data-uuid");
    let updateLessonWebService = 'https://localhost:8000/api/v1/lessons/' + uuid + '/katas/' + kataToBeReturnedToAvailableUuid ;


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
            if (sortablesender) {
                //define kataToBeReturned
                let kataToBeReturned = `<li class="ui-state-highlight availableKataElement ui-sortable-handle" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">${kataToBeReturnedToAvailableTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">add_circle</i></a></li>`;
                lessonKataSortable.replaceWith(kataToBeReturned);
            }
            updatePositionKatasList();
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}
function makeKataListSortable() {

    $( "#availableKatasList, #lessonKatasList").sortable({
        connectWith: ".connectedSortable",
        receive: function (event, ui) {
            //define element to be moved class
            let elementClass = (ui.item.context).getAttribute("class");
            //If the moved element is an lesson Kata
            if (elementClass.includes("lessonKataElement")) {
                //define kataToBeReturnedToAvailableTitle and kataToBeReturnedToAvailableUuid
                let kataToBeReturnedToAvailableTitle = (ui.item.context).getAttribute("data-title");
                let kataToBeReturnedToAvailableUuid = (ui.item.context).getAttribute("data-uuid");
                let lessonKataSortable = ui.item;
                let sortablesender = ui.sender;
                removeKataFromLessonByDragAndDrop (kataToBeReturnedToAvailableTitle, kataToBeReturnedToAvailableUuid, lessonKataSortable, sortablesender);
            }
            //else (if the moved element is an available kata)
            else {
                //define kataToBeAddedTitle and kataToBeAddedTitle
                let kataToBeAddedTitle = (ui.item.context).getAttribute("data-title");
                let kataToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
                let availableKataSortable = ui.item;
                let sortablesender = ui.sender;
                addKataToLessonByDragAndDrop (kataToBeAddedTitle, kataToBeAddedUuid, availableKataSortable, sortablesender);
            }
        },
        revert:true,
    }).disableSelection();
}
$(document).ready(function() {
    makeKataListSortable();
});

