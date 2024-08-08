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
        itemsDesktop: [1000, 5],
        itemsDesktopSmall: [980, 4],
        itemsTablet: [768, 3],
        itemsMobile: [650, 2],
        itemsMobile: [480, 1],
        pagination: true,
        navigation: false,
        slideSpeed: 1000,
        autoPlay: 2000,
    });
});

$(document).ready(function () {
    let checkUnit = $(".item_quantity:checked");
    $(".unit_name").html(checkUnit.data("name"));
    $(".total_price").html(
        numberFormat(
            parseFloat(checkUnit.data("total_price")) *
                $(".quantity_input").val(),
            2
        )
    );
    $(".total_regular_price").html(
        numberFormat(
            parseFloat(checkUnit.data("total_regular_price")) *
                $(".quantity_input").val(),
            2
        )
    );
    $(".product_price .item_quantity").on("change", function () {
        var name = $(this).data("name");
        var id = $(this).data("id");
        $(this)
            .closest(".product_content")
            .find(".cart-btn")
            .attr("data-unit_id", id);

        var TotalPrice = numberFormat(
            parseFloat($(this).data("total_price")) *
                $(".quantity_input").val(),
            2
        );
        var TotalRegularPrice = numberFormat(
            parseFloat($(this).data("total_regular_price")) *
                $(".quantity_input").val(),
            2
        );
        $(".total_price").html(TotalPrice);
        $(".total_regular_price").html(TotalRegularPrice);
        $(".unit_name").html(name);
    });

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

// Quantity Increment or Decrement Function
function changeQuantity(element, increment) {
    var quantityInput = element.siblings(".quantity_input");
    var quantity = parseInt(quantityInput.val()) || 1;
    if (quantity == 2 && increment == false) {
        element.addClass("disabled");
    } else {
        element.siblings(".minus_qty").removeClass("disabled");
    }
    quantity = increment ? quantity + 1 : quantity - 1;
    quantityInput.val(quantity);
    $(".product_content").find(".cart-btn").attr("data-quantity", quantity);

    let checkUnit = $(".item_quantity:checked");
    $(".total_price").html(
        numberFormat(checkUnit.data("total_price") * quantity, 2)
    );
    $(".total_regular_price").html(
        numberFormat(checkUnit.data("total_regular_price") * quantity, 2)
    );
}
if ($(".quantity_input").val() == 1) {
    $(".quantity_input").siblings(".minus_qty").addClass("disabled");
}

// Plus Quantity
$(document).on("click", ".plus_qty", function () {
    changeQuantity($(this), true);
});

// Minus Quantity
$(document).on("click", ".minus_qty", function () {
    changeQuantity($(this), false);
});
