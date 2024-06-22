$(document).ready(function () {
    $(document).on("click", ".lightbox img", function () {
        $(this).parent().addClass("new-lightbox-content");
        $(this).parent().parent().addClass("new-lightbox");
        $(this).parent().parent().find(".close_button").show();
        $(this).css("border-color", "#fff");
    });

    $(document).on("click", ".lightbox", function (event) {
        if ($(event.target).hasClass("lightbox")) {
            $(this)
                .find(".new-lightbox-content")
                .removeClass("new-lightbox-content");
            $(this).removeClass("new-lightbox");
            $(this).find(".close_button").hide();
            $(this).find("img").css("border-color", "#000");
        }
    });
    $(document).on("click", ".close_button", function (event) {
        if ($(this).parent().hasClass("lightbox")) {
            $(this)
                .parent()
                .find(".new-lightbox-content")
                .removeClass("new-lightbox-content");
            $(this).parent().removeClass("new-lightbox");
            $(this).hide();
            $(this).parent().find("img").css("border-color", "#000");
        }
    });
});
