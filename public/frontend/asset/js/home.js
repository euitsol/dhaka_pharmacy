$(document).ready(function () {
    $(".featured_category").on("click", function () {
        $(".cat-list li").removeClass("active");
        $(".cat-list li").removeClass("uk-slide-active");
        $(this).parent("li").addClass("active");

        let slug = $(this).data("slug");
        let url = datas.featured_products;
        let _url = url.replace("slug", slug);
        let all_product_route = datas.all_products;
        let _all_product_route = all_product_route.replace("slug", slug);
        $(".all-pdct-btn").attr("href", _all_product_route);

        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                data.products.forEach(function (product) {
                    let discount_percentage = "";
                    let discount_amount = "";

                    if (product.discount_percentage) {
                        discount_percentage = `<span class="discount_tag">${formatPercentageNumber(
                            product.discount_percentage
                        )}% 0ff</span>`;
                    }

                    if (product.discount_amount) {
                        discount_amount = `<span class="regular_price"> <del>${taka_icon} ${numberFormat(
                            product.price,
                            2
                        )}</del></span>`;
                    }
                    let route = datas.single_product;
                    let _route = route.replace("slug", product.slug);
                    result += `
                        <div class="col-3 px-2">
                            <div class="single-pdct">
                                    <a href="${_route}">
                                        <div class="pdct-img">
                                            ${discount_percentage}
                                            <img class="w-100"
                                                src="${product.image}"
                                                alt="Product Image">
                                        </div>
                                    </a>
                                    <div class="pdct-info">
                                        <a href="#" class="generic-name">
                                            ${product.generic.name}
                                        </a>
                                        <a href="#" class="company-name">
                                            ${product.company.name}
                                        </a>

                                        <div class="product_title">
                                            <a href="${_route}">
                                            <h3 class="fw-bold">
                                                ${product.name}
                                            </h3>
                                        </a>
                                        </div>
                                        <h4> <span> ${taka_icon} ${numberFormat(
                        product.discounted_price,
                        2
                    )}</span>  ${discount_amount}</h4>
                                        <div class="add_to_card">
                                            <a class="cart-btn" data-product_slug="${
                                                product.slug
                                            }" data-unit_id="" href="javascript:void(0)">
                                                <i class="fa-solid fa-cart-plus"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                        </div>
                    `;
                });
                $(".all-products").html(result);
                if (data.products.length >= 8) {
                    $(".show-more").show();
                } else {
                    $(".show-more").hide();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching products data:", error);
            },
        });
    });

    var featured_pro_height = $(".all-products").height();
    $(".best-selling-products").height(featured_pro_height + "px");
});
