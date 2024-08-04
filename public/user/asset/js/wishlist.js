function getHtml(wishes) {
    var result = "";
    wishes.forEach(function (wish) {
        result += `
        <div class="order-row wish_item">
                        <div class="row px-4">
                            <div class="col-8">
                                <div class="row py-3">
                                    <div class="col-2">
                                        <div class="img">
                                            <img class="w-100" src="${ wish.product.image }" alt="">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-info">
                                            <h2 class="name" title="${ wish.product.attr_title }">
                                                ${ wish.product.name }</h2>
                                            <h3 class="cat">${ wish.product.pro_sub_cat.name }</h3>
                                            <h3 class="cat">${ wish.product.generic.name }</h3>
                                            <h3 class="cat">${ wish.product.company.name }</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center py-3 px-4">
                                <div class="order-status p-0">
                                    <div class="total mb-2">
                                        <p class="total text-center ms-3">Total:
                                            <span>${ numberFormat(wish.product.discounted_price, 2) }tk</span>`;

                                            if (wish.product.discounted_price != wish.product.price){
                                                result += `<sup>
                                                            <del
                                                                class="text-danger">${ numberFormat(wish.product.price, 2) }tk</del>
                                                        </sup>`;
                                            }
                                                
                                            result += `
                                        </p>
                                        <div class="favorite wishlist_item me-3 text-danger">
                                            <i class="fa-solid fa-trash-can wish_update wish_remove_btn"
                                                data-pid="${ wish.product.pid }"></i>
                                        </div>
                                    </div>
                                    <div class="btns w-100 mx-auto">
                                        <a class="button"
                                            href="${ myDatas['single_product_route'].replace('param',wish.product.slug) }">Details</a>
                                        <div class="add_to_card">
                                            <a class="cart-btn button" href="javascript:void(0)"
                                                data-product_slug="${ wish.product.slug }"
                                                data-unit_id="${ wish.product.units[0]['id'] }">
                                                Add To Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
        `;
                                
    });
    return result;
}

$(document).ready(function () {
    updateUrlParameter('filter',myDatas["filter"]);

    $(".order_filter").on("change", function () {
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
                var wishes = data.wishes.data;
                if (wishes.length === 0) {
                    result = `<h3 class="my-5 text-danger text-center wish_empty_alert">{{ __('Wished Item Not Found') }}</h3>`;
                } else {
                    result = getHtml(wishes);
                }

                $("#wish_wrap").html(result);
                $(".paginate").html(data.pagination);
                if (data.filterValue) {
                    updateUrlParameter("filter", data.filterValue);
                }
                updateUrlParameter("page", 1);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching admin data:", error);
            },
        });
    });
});
