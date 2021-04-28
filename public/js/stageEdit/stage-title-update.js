
$(document).ready(function() {

    let title = document.getElementById("stage-title");
    let stageUuid = title.getAttribute("data-uuid")

    let updateLessonWebService = API_DOMAIN+'/api/v1/stages/' + stageUuid + '/title';



    $('#title').focusout(function() {
        let title_text = $('#stage-title').val();
        $.ajax({
            url : updateLessonWebService,
            data : {
                'title' : title_text,
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data)

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data['stageUuidDevuelto']);
            },
        })
    });
});
