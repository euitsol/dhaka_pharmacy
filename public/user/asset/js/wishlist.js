$(document).ready(function () {
    $(document).on("click", ".wish_update", function () {
        let pid = $(this).data("pid");
        let url = data.wishlist_url;
        let _url = url.replace("param", pid);
        let element = $(this);
        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    element.removeClass("fa-regular").addClass("fa-solid");
                } else {
                    toastr.warning(response.message);
                    element.removeClass("fa-solid").addClass("fa-regular");
                }
                setTimeout(function () {
                    if (element.parent().hasClass("wishlist_item")) {
                        element.closest(".wish_item").remove(); // More efficient parent traversal
                    }
                }, 500);
                if ($(".wish_item").length < 2) {
                    $("#wish_wrap").html(
                        `<h3 class="my-5 text-danger text-center">Wish Item Not Found</h3>`
                    );
                }
            },
            error: function (xhr, status, error) {
                window.location.href = data.login_url;
                console.error("Error fetching search data:", error);
            },
        });
    });
});
