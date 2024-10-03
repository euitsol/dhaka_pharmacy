$(document).ready(function () {
    $(".do_status").on("change", function () {
        if ($(this).val() == 3) {
            $(this).closest(".status_wrap").find(".status_note").show();
            $(this)
                .closest(".media")
                .find(".open_amount")
                .prop("disabled", true);
            $(this).closest(".media").find(".open_amount").parent().hide();
        } else {
            $(this).closest(".status_wrap").find(".status_note").hide();
            $(this)
                .closest(".status_wrap")
                .find(".status_note .form-control")
                .val("");
            $(this)
                .closest(".media")
                .find(".open_amount")
                .prop("disabled", false);
            $(this).closest(".media").find(".open_amount").parent().show();
        }
    });

    $(document).ready(function () {
        const inputs = $(".otp-field > input");
        const button = $(".verify-btn");

        inputs.eq(0).focus();
        button.prop("disabled", true);

        inputs.eq(0).on("paste", function (event) {
            event.preventDefault();

            const pastedValue = (
                event.originalEvent.clipboardData || window.clipboardData
            ).getData("text");
            const otpLength = inputs.length;

            for (let i = 0; i < otpLength; i++) {
                if (i < pastedValue.length) {
                    inputs.eq(i).val(pastedValue[i]);
                    inputs.eq(i).removeAttr("disabled");
                    inputs.eq(i).focus();
                } else {
                    inputs.eq(i).val(""); // Clear any remaining inputs
                    inputs.eq(i).focus();
                }
            }
        });

        inputs.each(function (index1) {
            $(this).on("keyup", function (e) {
                const currentInput = $(this);
                const nextInput = currentInput.next();
                const prevInput = currentInput.prev();

                if (currentInput.val().length > 1) {
                    currentInput.val("");
                    return;
                }

                if (
                    nextInput &&
                    nextInput.attr("disabled") &&
                    currentInput.val() !== ""
                ) {
                    nextInput.removeAttr("disabled");
                    nextInput.focus();
                }

                if (e.key === "Backspace") {
                    inputs.each(function (index2) {
                        if (index1 <= index2 && prevInput) {
                            $(this).attr("disabled", true);
                            $(this).val("");
                            prevInput.focus();
                        }
                    });
                }

                button.prop("disabled", true);

                const inputsNo = inputs.length;
                if (
                    !inputs.eq(inputsNo - 1).prop("disabled") &&
                    inputs.eq(inputsNo - 1).val() !== ""
                ) {
                    button.prop("disabled", false);
                    return;
                }
            });
        });
    });
});

// function initializeFlipDown(prepTime) {
//     var toDayFromNow =
//         new Date(prepTime).getTime() / 1000 + 3600 / 60 / 60 / 24 - 1;
//     var flipdown = new FlipDown(toDayFromNow, {
//         theme: "dark",
//         headings: ["Hours", "Minutes", "Seconds"],
//     })
//         .start()
//         .ifEnded(function () {
//             $(".flipdown").html(
//                 `<span class="text-danger text-center d-block">DELAYED</span>`
//             );
//         });
// }

function initializeFlipDown(prepTime) {
    var currentTime = new Date().getTime() / 1000; // Get current time in seconds
    var targetTime = new Date(prepTime).getTime() / 1000; // Get target time in seconds
    var timeDifference = targetTime - currentTime; // Calculate the difference in seconds

    var flipdown = new FlipDown(currentTime + timeDifference, {
        theme: "dark",
        headings: ["Hours", "Minutes", "Seconds"], // Custom headings for hours, minutes, and seconds
    })
        .start()
        .ifEnded(function () {
            $(".flipdown").html(
                `<span class="text-danger text-center d-block">DELAYED</span>`
            );
        });

    // Hide the days column
    document
        .querySelectorAll(".flipdown__box.flipdown__box--day")
        .forEach((box) => (box.style.display = "none"));
}
$(document).ready(function () {
    initializeFlipDown(data["prepTime"]);
    $(".flipdown").show();
});

// Order Tracking
$(document).ready(function () {
    $(".tracking_card").height($(".order_details_card").height() + "px");
});
