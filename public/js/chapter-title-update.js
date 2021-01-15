
$(document).ready(function() {

    let chapterTitle = document.getElementById("chapter-title");
    let chapterUuid = chapterTitle.getAttribute("data-uuid")

    let updateLessonWebService = 'http://localhost:8000/api/v1/chapters/' + chapterUuid + '/title';



    $('#chapter-title').focusout(function() {
        let chapter_title_text = $('#chapter-title').val();
        $.ajax({
            url : updateLessonWebService,
            data : {
                'chapter_title' : chapter_title_text,
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
