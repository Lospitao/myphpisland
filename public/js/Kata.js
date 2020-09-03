$(document).ready(function() {
    $('.title').focusout(function() {
        $.ajax({
            url : '/api/v1/katas/{uuid}',
            data : {
                "title": $this.text(),
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });

    $('.description').focusout(function() {
        $.ajax({
            url : '/api/v1/katas/{uuid}',
            data : {
                "title": $this.text(),
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });

    $('.code-editor').focusout(function() {
        $.ajax({
            url : '/api/v1/katas/{uuid}',
            data : {
                "title": $this.text(),
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });

    $('.sample-test').focusout(function() {
        $.ajax({
            url : '/api/v1/katas/{uuid}',
            data : {
                "title": $this.text(),
            },
            type : 'PATCH',
            dataType : 'json',
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        })
    });
});

