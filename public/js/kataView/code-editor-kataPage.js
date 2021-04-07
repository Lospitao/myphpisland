$(document).ready(function() {
    let codeMirrorEditor = addCodeEditorComponentsToCodeMirror();
    addClickActionToExecuteButton(codeMirrorEditor);
});

function addCodeEditorComponentsToCodeMirror()
{
    let codeEditor = document.getElementById("code-editor");
    let codeMirrorEditor = CodeMirror.fromTextArea(codeEditor, {
        lineNumbers: true,
        mode: {
            name: 'php',
            startOpen: true,
        },
        mime: "application/x-httpd-php",
        theme: "eclipse",
        extraKeys: {"Ctrl-Space": "autocomplete",}
    });

    return codeMirrorEditor;
}

function addClickActionToExecuteButton(codeMirrorEditor)
{
    document.getElementById("test-executor").addEventListener("click", function () {
        // Kata identifier
        let uuid = this.getAttribute("data-uuid");

        // Test execution web service path
        let testExecutionWebServicePath = '/api/v1/test_executions/' + uuid;

        // Get uuid
        let testExecutionWebServiceData = {
            'kataId': uuid,
            'code': codeMirrorEditor.getValue(),
        }

        if (isCodeEmpty(testExecutionWebServiceData)) {
            alert ("Escribe tu código antes de ejecutar el test");
            return ;
        }
        submitRequestToTestExecutionWebService(testExecutionWebServicePath, testExecutionWebServiceData);
    });
}

function isCodeEmpty(testExecutionWebServiceData)
{
    return testExecutionWebServiceData.code.length === 0;
}

function submitRequestToTestExecutionWebService(testExecutionWebServicePath, testExecutionWebServiceData)
{
    $.ajax({
        url: testExecutionWebServicePath,
        data: testExecutionWebServiceData,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            console.log('Submission was successful.')
            console.log(data);

            if ( !data.isTestPassed) {
                $('#modal-fail-message').modal('open');
                return ;
            }
            $('#modal-success-message').modal('open');
        },
        error: function (data) {
            console.log('An error occurred.');
            console.log(data);
            console.log(testExecutionWebServiceData);
        },
    })
}