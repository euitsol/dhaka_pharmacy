$(document).ready(function () {
    $("#read_all").on("click", function (event) {
        event.stopPropagation();
        let $this = $(this);
        $.ajax({
            url: mark_as_read,
            type: "GET",

            success: function (response) {
                if (response.success) {
                    $(".notification-item").removeClass("active");
                    $(".notification-count").removeClass("active");
                    $(".notification-count").find(".count").text("(0)");
                    $this.remove();
                } else {
                    toastr("error", "Something went wrong! Please try again.");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            },
        });
    });
    $(".notification-item").on("click", function (event) {
        event.stopPropagation();
        let $this = $(this);
        let url = $this.data("url");
        if ($this.hasClass("active")) {
            $.ajax({
                url: mark_as_read,
                type: "GET",
                data: {
                    id: $this.data("id"),
                },
                success: function (response) {
                    if (response.success) {
                        window.location.href = url;
                    } else {
                        toastr(
                            "error",
                            "Something went wrong! Please try again."
                        );
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                },
            });
        }
    });
});
