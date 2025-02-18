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
                                        <div class="row align-content-center">
                                            <div class="col-xl-10 col-md-8">
                                                 <div class="d-flex flex-sm-row flex-column">
                                                    <div class="text">
                                                        <h3 class="order-num">Order: <span>${order.order_id}</span>
                                                        </h3>
                                                        <p class="date-time">
                                                            Placed on <span>${order.place_date}</span>
                                                        </p>
                                                    </div>
                                                    <div class="status ms-0 ms-sm-4 mt-3 mt-sm-0 ms-md-2 ms-lg-3 order-info-section">
                                                    <div class="order-status-row d-flex gap-3 align-items-center">
                                                        <span
                                                            class="${order.statusBg}">${order.statusTitle}</span>`;
        if (order.otp) {
            result += `<p class="fw-bold">OTP: ${order.otp}</p>`;
        }

        result += `</div>

                                                        <p class="total p-0">
                                                            Total Amount: <span class='fw-bold'>${numberFormat(
                                                                order.totalPrice,
                                                                2
                                                            )}tk</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 text-md-end text-start pb-3">

                                            <div class="order-status">
                                                <div class="btn p-0 d-flex gap-1">
                                                    <a
                                                        href="${myDatas[
                                                            "details_route"
                                                        ].replace(
                                                            "order_id",
                                                            order.encrypt_oid
                                                        )}">Details</a>`;
        if (order.status < 2 && order.status != -1) {
            result += `<a class="cancle text-danger"
                                            href="${myDatas[
                                                "cancel_route"
                                            ].replace(
                                                "order_id",
                                                order.encrypt_oid
                                            )}">Cancel</a>`;
        }

        result += `</div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12 px-4">
                                `;

        order.products.forEach(function (product) {
            result += `

                                                            <div class="row py-3 px-0 px-sm-4 align-items-center list-item">
                                                                <div class="col-md-2 col-sm-3 col-5">
                                                                    <div class="img">
                                                                        <img class="w-100" src="${
                                                                            product.image
                                                                        }" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7 col-sm-5 col-7">
                                                                    <div class="product-info">
                                                                        <h2 class="name" title="${
                                                                            product.attr_title
                                                                        }">${
                product.name
            }</h2>
                                                                        <p class="cat" title="${
                                                                            product
                                                                                .pro_sub_cat
                                                                                .name
                                                                        }" >${
                product.pro_sub_cat.name
            }</p>
                                                                        <p class="cat" title="${
                                                                            product
                                                                                .generic
                                                                                .name
                                                                        }" >${
                product.generic.name
            }</p>
                                                                        <p class="cat" title="${
                                                                            product
                                                                                .company
                                                                                .name
                                                                        }" >${
                product.company.name
            }</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 mt-3 mt-sm-0 col-sm-4 col-12 d-flex d-sm-block gap-4 gap-sm-0">
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
    updateUrlParameter("filter", myDatas["filter"]);

    $(".order_filter").on("change", function () {
        var filter_value = $(this).val();
        var status = myDatas["status"];
        let url = myDatas["url"];
        let _url = url.replace("_status", status);
        let __url = _url.replace("filter_value", filter_value);
        __url = __url.replace(/&amp;/g, "&");
        let order_wrap = $(".order_wrap");
        let paginate = $(".paginate");
        paginate.hide();
        order_wrap.html(
            `
            <div class="d-flex align-items-center justify-content-between my-4">
                <strong class="text-info">Loading...</strong>
                <div class="spinner-border text-info" role="status" aria-hidden="true"></div>
            </div>
            `
        );
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

                order_wrap.html(result);
                paginate.show();
                paginate.html(data.pagination);
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
