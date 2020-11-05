function updateStageTitle() {
    let title = document.getElementById("stage-title");
    let stageUuid = title.getAttribute("data-uuid")

    let updateLessonWebService = 'https://localhost:8000/api/v1/stages/' + stageUuid;


    $.ajax({

        url : updateLessonWebService,
        data : {

        },
        type : 'PATCH',
        dataType : 'file',
        success: function (data) {
            console.log('Submission was successful.');
        },
        error: function (data) {
            console.log('An error occurred.');
        },
    })
}

function uploadStageAmbientSound() {
    $('#uploadSoundButton').click(function() {
        let stageUuid = $(this).getAttribute("data-uuid");
    });
}
function uploadStageDialog() {
    $('#uploadDialogButton').click(function() {
        let stageUuid = $(this).getAttribute("data-uuid");
    });
}
function uploadStageBackgroundImage() {
    $('#uploadBackgroundImageButton').click(function() {
        let stageUuid = $(this).getAttribute("data-uuid");
    });
}
$(document).ready(function() {
    uploadStageAmbientSound();
    uploadStageDialog();
    uploadStageBackgroundImage();
});