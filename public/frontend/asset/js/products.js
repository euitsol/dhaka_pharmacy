$(document).ready(function () {
    function renderProducts(products) {
        return products
            .map(function (product) {
                let route = datas.single_product;
                let _route = route.replace("slug", product.slug);

                let discount_percentage = "";
                let discount_amount = "";
                if (product.discount_percentage) {
                    discount_percentage = `<span class="discount_tag">${formatPercentageNumber(
                        product.discount_percentage
                    )}% 0ff</span>`;
                }

                if (product.discount_percentage) {
                    discount_amount = `<span class="regular_price"> <del>${taka_icon} ${numberFormat(
                        product.price,
                        2
                    )}</del></span>`;
                }

                return `
                <div class="px-2 single-pdct-wrapper col-3 col-xl-2 col-6 col-md-3">
                    <div class="single-pdct">
                        <a href="${_route}">
                            <div class="pdct-img">
                                ${discount_percentage}
                                <img class="w-100" src="${
                                    product.image
                                }" alt="Product Image">
                            </div>
                        </a>
                        <div class="pdct-info">
                            <a href="#" class="generic-name">${
                                product.generic.name
                            }</a>
                            <a href="#" class="company-name">${
                                product.company.name
                            }</a>
                            <div class="product_title">
                                <a href="${_route}">
                                    <h3 class="fw-bold">
                                        ${product.name}
                                    </h3>
                                </a>
                            </div>
                            <h4><span>${taka_icon} ${numberFormat(product.discountPrice, 2)}</span>  ${discount_amount}</h4>
                            <div class="add_to_card">
                                <a class="cart-btn" data-unit_id="${
                                    product.units[0]["id"]
                                }" href="javascript:void(0)" data-product_slug="${product.slug}">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            })
            .join("");
    }

    function fetchData(url, successCallback, errorCallback) {
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: successCallback,
            error: errorCallback,
        });
    }

    $(".sub_cat_link").on("click", function () {
        $(".sub_cat_link .card").removeClass("active");
        $(this).find(".card").addClass("active");

        let cat_slug = $(this).data("cat_slug");
        let sub_cat_slug = $(this).data("sub_cat_slug");
        $(".more").attr("data-offset", 6);
        $(".more").attr("data-sub_cat_slug", sub_cat_slug);

        let url = datas.cat_products;
        let dynamicUrl = url
            .replace("cat_slug", cat_slug)
            .replace("sub_cat_slug", sub_cat_slug);
        dynamicUrl = dynamicUrl;
        dynamicUrl = dynamicUrl.replace(/&amp;/g, "&");

        fetchData(
            dynamicUrl,
            function (data) {
                window.history.pushState(
                    {
                        path: data.url,
                    },
                    "",
                    data.url
                );

                let result = renderProducts(data.products);
                $(".all-products").html(result);
                $(".show-more").toggle(data.products.length >= 1);
            },
            function (xhr, status, error) {
                console.error("Error fetching products:", error);
            }
        );
    });

    $(".more").on("click", function () {
        let limit = 6;
        let offset = parseInt($(this).attr("data-offset"));
        let cat_slug = $(this).attr("data-cat_slug");
        let sub_cat_slug = $(this).attr("data-sub_cat_slug");
        let url = datas.more_products;
        let dynamicUrl = url
            .replace("cat_slug", cat_slug)
            .replace("_offset", offset)
            .replace("sub_cat_slug", sub_cat_slug);
        dynamicUrl = dynamicUrl.replace(/&amp;/g, "&");

        fetchData(
            dynamicUrl,
            function (data) {
                $(".more").attr("data-offset", offset + limit);
                let result = renderProducts(data.products);
                $(".all-products").append(result);
                $(".more")
                    .parent()
                    .toggle(data.products.length >= limit);
            },
            function (xhr, status, error) {
                console.error("Error fetching products:", error);
            }
        );
    });
});
