function getHtml(products) {
    var result = "";
    products.forEach(function (product) {
        result += `
        <div class="order-row">
            <div class="row align-items-center py-4">
                <div class="col-1">
                    <div class="img w-100 text-center">
                        <div id="lightbox" class="lightbox tips_image">
                            <div class="lightbox-content">
                                <img src="${
                                    product.image
                                }" class="lightbox_image">
                            </div>
                            <div class="close_button fa-beat">X</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="product-info">
                        <h5 class="mb-0" title="${product.attr_title}">
                            ${product.name}</h5>
                        <p class="mb-0">${product.pro_sub_cat.name}</p>
                        <p class="mb-0">${product.pro_cat.name}</p>
                    </div>
                </div>
                <div class="col">
                    <div class="product-info">
                        <p class="mb-0">
                            <strong>Generic Name: </strong>${
                                product.generic.name
                            }
                        </p>
                        <p class="mb-0">
                            <strong>Company: </strong>${product.company.name}
                        </p>
                    </div>
                </div>
                <div class="col">
                    <div class="product-info text-center">
                        <p class="mb-0">
                            <strong>Strength: </strong>${
                                product.strength.quantity +
                                "-" +
                                product.strength.unit.toUpperCase()
                            }
                        </p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="product-info text-center">
                        <p class="mb-0">
                            <strong>Price: </strong>
                            <span>${numberFormat(
                                product.discounted_price,
                                2
                            )}tk</span><sup
                                class="text-danger"><del>${
                                    product.discounted_price != product.price
                                        ? numberFormat(product.price, 2) + "tk"
                                        : ""
                                }</del></sup>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row pb-4">
                <div class="col-12">`;
        if (product.self_review !== null) {
            result += `
                        <div class="review px-3">
                            <p class="mb-0" style="text-align: justify">
                                <strong>Your Review: </strong>${product.self_review.description}
                            </p>
                        </div>`;
        } else {
            result += `
                        <form action="${myDatas["review_update"]}" method="POST" class="px-3">
                        ${myDatas["csrf"]}
                            <input type="hidden" name="product_id" value="${product.id}">
                            <textarea name="description" class="w-100 p-2" placeholder="Tell us about your experience..."></textarea>
                            ${myDatas["validation_error"]}
                            <input type="submit" class="btn review_submit float-end" value="Submit">
                        </form>`;
        }

        result += ` </div>
            </div>
        </div>
        `;
    });
    return result;
}

$(document).ready(function () {
    updateUrlParameter("filter", myDatas["filter"]);

    $(".review_filter").on("change", function () {
        var filter_value = $(this).val();
        let url = myDatas["url"];
        let _url = url.replace("filter_value", filter_value);
        __url = _url.replace(/&amp;/g, "&");
        $.ajax({
            url: __url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                var products = data.products.data;
                if (products.length === 0) {
                    result = `<h3 class="my-5 text-danger text-center wish_empty_alert">Product Not Found</h3>`;
                } else {
                    result = getHtml(products);
                }

                $("#review_wrap").html(result);
                $(".paginate").html(data.pagination);
                if (data.filterValue) {
                    updateUrlParameter("filter", data.filterValue);
                }
                updateUrlParameter("page", 1);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching review data:", error);
            },
        });
    });
});
