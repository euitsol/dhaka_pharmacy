function playSound() {
    var audio = new Audio(audio_url);
    audio.play();
}

$(document).ready(function () {
    if (admin_id) {
        try {
            window.Echo.private("order-status-changed." + admin_id).listen(
                ".order-status-changed",
                (e) => {
                    console.log(e);

                    if (e) {
                        playSound();

                        Swal.fire({
                            title: e.title,
                            text: e.text,
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonText: "View",
                            cancelButtonText: "Cancel",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = e.url;
                            }
                        });
                    }
                }
            );
        } catch (e) {
            console.log(e);
        }
    }
});
