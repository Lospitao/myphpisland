function updatePositionKatasList() {


    $( ".lessonKataElement" ).each(function( index ) {
        return index;
    });
}

function makeKataListSortable() {

    $( "#availableKatasList, #lessonKatasList").sortable({
        connectWith: ".connectedSortable",
        receive: function (event, ui) {
            //define element to be moved class
            let elementClass = (ui.item.context).getAttribute("class");
            console.log(elementClass);
            //If the moved element is an available Kata
            if (elementClass.includes("availableKataElement")) {
                //define kataToBeAddedTitle and kataToBeAddedTitle
                let kataToBeAddedTitle = (ui.item.context).getAttribute("data-title");
                let kataToBeAddedUuid = (ui.item.context).getAttribute("data-uuid");
                //define newLessonKata
                let newLessonKata = `<li class="ui-state-highlight lessonKataElement ui-sortable-handle" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">${kataToBeAddedTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeAddedTitle}" data-uuid="${kataToBeAddedUuid}">clear</i></a></li>`;
                //if an element was moved from one sortable list to a different one
                if (ui.sender) {
                    let availableKataSortable= ui.item ;
                    availableKataSortable.replaceWith(newLessonKata);
                }
            }
            //else (if the moved element is a lesson Kata)
                //define kataToBeReturnedToAvailableTitle and kataToBeReturnedToAvailableUuid
                let kataToBeReturnedToAvailableTitle = (ui.item.context).getAttribute("data-title");
                let kataToBeReturnedToAvailableUuid = (ui.item.context).getAttribute("data-uuid");
                //define kataToBeReturned
                let kataToBeReturned = `<li class="ui-state-highlight lessonKataElement ui-sortable-handle" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">${kataToBeReturnedToAvailableTitle}<a href="#"><i class="tiny material-icons lessonKata" data-title="${kataToBeReturnedToAvailableTitle}" data-uuid="${kataToBeReturnedToAvailableUuid}">add_circle</i></a></li>`;
                //if an element was moved from one sortable list to a different one
                if (ui.sender) {
                    let lessonKataSortable= ui.item ;
                    lessonKataSortable.replaceWith(kataToBeReturned);
                }
        },
        update: function (event, ui) {
            updatePositionKatasList();
        },
        revert:true,
    }).disableSelection();



}
$(document).ready(function() {
    makeKataListSortable();
});

