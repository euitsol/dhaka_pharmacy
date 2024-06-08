$(document).ready(function () {
    $(".up_button").on("click", function () {
        if (auth) {
            $(".up_modal").modal("show");
        } else {
            window.location.href = login_route;
        }
    });
});
