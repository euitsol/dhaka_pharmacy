function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }

    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function getHtml(orders) {
    var result = "";
    orders.forEach(function (order) {
        result += `
                                <div class="order-row">
                                    <div class="order-id-row">
                                        <div class="row">
                                            <div class="col-10">
                                                 <div class="d-flex">
                                                    <div class="text">
                                                        <h3 class="order-num">Order: <span>${
                                                            order.order_id
                                                        }</span>
                                                        </h3>
                                                        <p class="date-time">
                                                            Placed on <span>${
                                                                order.place_date
                                                            }</span>
                                                        </p>
                                                    </div>
                                                    <div class="status ms-3">
                                                        <span
                                                            class="${
                                                                order.statusBg
                                                            }">${
            order.statusTitle
        }</span>

                                                        <p class="total text-center p-0">
                                                            Total Amount: <span class='fw-bold'>${numberFormat(
                                                                order.totalPrice,
                                                                2
                                                            )}tk</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-2 text-end"> 

                                            <div class="order-status">
                                                <div class="btn p-0">
                                                    <a
                                                        href="${
                                                            myDatas[
                                                                "details_route"
                                                            ].replace('order_id',order.encrypt_oid)
                                                        }">Details</a>
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12 px-4">
                                `;

        order.products.forEach(function (product) {
            result += `

                                                            <div class="row py-3 px-4 align-items-center">
                                                                <div class="col-2">
                                                                    <div class="img">
                                                                        <img class="w-100" src="${
                                                                            product.image
                                                                        }" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-7">
                                                                    <div class="product-info">
                                                                        <h2 class="name" title="${
                                                                            product.attr_title
                                                                        }">${
                product.name
            }</h2>
                                                                        <p class="cat">${
                                                                            product
                                                                                .pro_sub_cat
                                                                                .name
                                                                        }</p>
                                                                        <p class="cat">${
                                                                            product
                                                                                .generic
                                                                                .name
                                                                        }</p>
                                                                        <p class="cat">${
                                                                            product
                                                                                .company
                                                                                .name
                                                                        }</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <p class="qty">Qty: <span>${
                                                                        product
                                                                            .pivot
                                                                            .quantity <
                                                                        10
                                                                            ? "0" +
                                                                              product
                                                                                  .pivot
                                                                                  .quantity
                                                                            : product
                                                                                  .pivot
                                                                                  .quantity
                                                                    }</span></p>
                                                                    <p class="qty">Unit: <span>${
                                                                        product
                                                                            .pivot
                                                                            .unit
                                                                            .name
                                                                    }</span></p>
                                                                </div> 
                                                            </div>

                                                `;
        });

        result += `
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
        var status = myDatas["status"];
        let url = myDatas["url"];
        let _url = url.replace("_status", status);
        let __url = _url.replace("filter_value", filter_value);
        __url = __url.replace(/&amp;/g, "&");
        $.ajax({
            url: __url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                var orders = data.orders.data;
                if (orders.length === 0) {
                    result = `<h3 class="my-5 text-danger text-center">Order Not Found</h3>`;
                } else {
                    result = getHtml(orders);
                }

                $(".order_wrap").html(result);
                $(".paginate").html(data.pagination);
                if (data.filterValue) {
                    updateUrlParameter("filter", data.filterValue);
                }
                if (data.status) {
                    updateUrlParameter("status", data.status);
                }
                updateUrlParameter("page", 1);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching admin data:", error);
            },
        });
    });
});
