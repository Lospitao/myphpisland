
function uploadStageAmbientSound(stageUuid, updateStageWebService) {

    $.ajax({

        url : updateStageWebService,
        data : {
            stageUuid: stageUuid,
        },
        type : 'PATCH',
        dataType : 'file',
        success: function (data) {
            console.log('Submission was successful.');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    })
}

function uploadStageDialog(stageUuid, updateStageWebService) {
    $.ajax({

        url : updateStageWebService,
        data : {
            stageUuid: stageUuid,
        },
        type : 'PATCH',
        dataType : 'file',
        success: function (data) {
            console.log('Submission was successful.');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    })
}

function uploadStageBackgroundImage(stageUuid, updateStageWebService) {
    $.ajax({

        url : updateStageWebService,
        data : {
            stageUuid: stageUuid,
        },
        type : 'PATCH',
        dataType : 'file',
        success: function (data) {
            console.log('Submission was successful.');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
        },
    })
}

function uploadStageAmbientSoundEvent(stageUuid, updateStageWebService) {
    $('#uploadSoundButton').change(function() {
        uploadStageAmbientSound(stageUuid);
    });
}

function uploadStageDialogEvent(stageUuid, updateStageWebService) {
    $('#uploadDialogButton').change(function() {
        uploadStageDialog(stageUuid);

    });
}

function uploadStageBackgroundImageEvent(stageUuid, updateStageWebService) {
    $('#uploadBackgroundImageButton').change(function() {
        uploadStageBackgroundImage(stageUuid);
    });
}

$(document).ready(function() {
    let title = document.getElementById("stage-title");
    let stageUuid = title.getAttribute("data-uuid");
    let updateStageWebService = API_DOMAIN+'/api/v1/stages/' + stageUuid;
    uploadStageAmbientSoundEvent(stageUuid, updateStageWebService);
    uploadStageDialogEvent(stageUuid, updateStageWebService);
    uploadStageBackgroundImageEvent(stageUuid, updateStageWebService);
});