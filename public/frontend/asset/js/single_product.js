// XZoom
$(document).ready(function () {
    $(".xzoom, .xzoom-gallery").xzoom({
        zoomWidth: 400,
        title: true,
        tint: "#333",
        Xoffset: 15,
    });
});
// Xzoom

//testimonial-slider
$(document).ready(function () {
    $("#testimonial-slider").owlCarousel({
        items: 3,
        itemsDesktop: [1000, 3],
        itemsDesktopSmall: [980, 2],
        itemsTablet: [768, 2],
        itemsMobile: [650, 1],
        pagination: true,
        navigation: false,
        slideSpeed: 1000,
        autoPlay: 2000,
    });
});
//related product
$(document).ready(function () {
    $("#related-product-slider").owlCarousel({
        items: 5,
        itemsDesktop: [1399, 3],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [767, 3],
        itemsMobile: [575, 2],
        pagination: true,
        navigation: false,
        slideSpeed: 1000,
        autoPlay: 2000,
    });
});
$(document).ready(function () {
    $("#bs-product-slider").owlCarousel({
        items: 5,
        rtl: true,
        itemsDesktop: [1399, 3],
        itemsDesktopSmall: [991, 3],
        itemsTablet: [767, 3],
        itemsMobile: [575, 2],
        pagination: true,
        navigation: false,
        slideSpeed: 1000,
        autoPlay: 2000,
    });
});

$(document).ready(function () {
    $(document).on("click", ".review_read", function () {
        let review = $(this).data("content");
        let author = $(this).data("author");
        let modal_content = `
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Author</th>
                        <th>:</th>
                        <td>${author}</td>
                    </tr>
                    <tr>
                        <th>Review</th>
                        <th>:</th>
                        <td style="text-align: justify;">${review}</td>
                    </tr>
                </tbody>
            </table>
        `;
        $(".review_details").html(modal_content);
        $("#review_modal").modal("show");
    });
});
$(document).ready(function () {
    //Height Control Jquery
    var single_product_height = $(".single_product_card").height();
    $(".similar_products_card").css("max-height", single_product_height + "px");

    //Product Description Jquery
    $(".single_product_section .product_details .nav-tabs a").on(
        "click",
        function () {
            var single_product_height = $(".single_product_card").height();
            $(".similar_products_card").css(
                "max-height",
                single_product_height + "px"
            );

            var position = $(this).parent().position();
            var width = $(this).parent().width();
            $(".single_product_section .product_details .slider").css({
                left: +position.left,
                width: width,
            });
            $(".product_details .nav-tabs li a").removeClass("active");
            $(this).addClass("active");
        }
    );
    var actWidth = $(".single_product_section .product_details .nav-tabs")
        .find(".active")
        .parent("li")
        .width();
    var actPosition = $(
        ".single_product_section .product_details .nav-tabs .active"
    ).position();
    $(".single_product_section .product_details .slider").css({
        left: +actPosition.left,
        width: actWidth,
    });
});
