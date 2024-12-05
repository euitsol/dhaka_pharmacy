$(document).ready(function () {
    $("#read_all").on("click", function (event) {
        event.stopPropagation();
        $.ajax({
            url: mark_as_read,
            type: "GET",
            success: function (response) {
                if (response.success) {
                    $(".notification_quantity", ".notification_count").text(
                        "0"
                    );
                    $(".notification", ".notification-item").removeClass(
                        "active"
                    );
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
                        if (url == null) {
                            if ($this.hasClass("active")) {
                                $this.removeClass("active");
                                $(
                                    ".notification_quantity",
                                    ".notification_count"
                                ).text(
                                    parseInt($(".notification_count").text()) -
                                        1
                                );
                            }
                        } else {
                            window.location.href = url;
                        }
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

function playSound() {
    var audio = new Audio(audio_url);
    audio.play();
}

$(document).ready(function () {
    if (user_id) {
        window.Echo.private("user-notification." + user_id).listen(
            ".user-notification",
            (e) => {
                if (e) {
                    let result = `<li>
                                        <a class="dropdown-item d-flex align-items-center notification-item active"
                                            href='javascript:void(0)' data-id="${
                                                e.notification_id
                                            }"
                                            data-url="${e.url ?? null}">
                                            <div class="notification-icon">
                                                <i class="fa-regular fa-bell fs-3 me-3 "
                                                    style="width: 50px; text-align: center"></i>
                                            </div>
                                            <div class="details px-2">
                                                <p class="fw-semibold">${
                                                    e.title
                                                }</p>
                                                <span
                                                    class="notification-title d-block">${
                                                        e.message
                                                    }</span>
                                                <span
                                                    class="notify-time d-block mt-1 text-muted">${
                                                        e.created_at
                                                    }</span>
                                            </div>

                                        </a>
                                    </li>`;
                    $(".notification-list").prepend(result);
                    $(".notification_count").text(
                        parseInt($(".notification_count").text()) + 1
                    );
                    $(".notification_quantity").text(
                        parseInt($(".notification_quantity").text()) + 1
                    );
                    if (!$(".notification").hasClass("active")) {
                        $(".notification").addClass("active");
                    }
                    playSound();
                }
            }
        );
    }
});
