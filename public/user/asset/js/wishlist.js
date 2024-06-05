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
                if (element.parent(".favorite").hasClass("wishlist_item")) {
                    element
                        .parent(".wishlist_item")
                        .closest(".order-row")
                        .remove();
                }
            },
            error: function (xhr, status, error) {
                toastr.error("Something is wrong!");
                console.error("Error fetching search data:", error);
            },
        });
    });
});
