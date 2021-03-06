
$(document).ready(function() {
    let title = document.getElementById("stage-view");
    let stageUuid = title.getAttribute("data-uuid");

    //Ambient sound starts playing once the stage is loaded
    var sound = new Howl({
        src: ['/resources/stages/' + stageUuid + '/ambient.mp3'],
        autoplay: true,
        volume: 0.05,
        mute: false,
    });
    sound.play();

    // Dialog starts playing once the stage is loaded

        var dialog = new Howl ({
            src:['/resources/stages/' + stageUuid + '/dialog.mp3'],
            volume: 0.5,
            onend: function () {
                let nextPageRoute = '/next/page'
                let nextButton = `<a class="waves-effect waves-light btn-large float-right" href=${nextPageRoute}>Siguiente</a>`
                $( ".next_button_section" ).append(nextButton);
            }
        });
        dialog.play();


});