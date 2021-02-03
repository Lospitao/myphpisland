
$(document).ready(function() {
    let title = document.getElementById("stage-title");
    let stageUuid = title.getAttribute("data-uuid");
    //Ambient sound starts playing once the stage is loaded
    var sound = new Howl({
        src: ['/resources/stages/' + stageUuid + '/ambient.mp3'],
        autoplay: true,
        volume: 0.05,
        mute: false,
    });
    sound.play();
    // Dialog starts when we click the relevant character
    $('#characterOne').click(function () {
        var dialog = new Howl ({
            src:['/resources/stages/' + stageUuid + '/dialog.mp3'],
            volume: 0.5,
        });
        dialog.play();
    })

});