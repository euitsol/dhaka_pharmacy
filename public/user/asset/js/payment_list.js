function getHtml(payments) {
    var result = "";
    payments.forEach(function (payment) {
        result += `<div class="order-row">
                <div class="order-id-row border-0 p-4">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h3 class="order-num">
                                Transaction ID: '<span>${
                                    payment.transaction_id
                                }</span>
                            </h3>
                            <p class="date-time my-1">
                                Order ID: <span>${payment.order.order_id}</span>
                            </p>
                            <p class="date-time">Payment Date: <span>${
                                payment.date
                            }</span></p>
                        </div>
                        <div class="col-8">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                    <div class="order-status pe-0">
                                        <div class="total">
                                            <p class="total text-start">
                                                Payment Type: <span>Bkash</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="order-status pe-0">
                                        <div class="total">
                                            <p class="total text-start">
                                                Total: <span>${numberFormat(
                                                    Math.ceil(
                                                        parseInt(payment.amount)
                                                    )
                                                )}</span>tk
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <span
                                        class="${payment.statusBg}">${
            payment.statusTitle
        }</span>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="order-status">
                                        <div class="btn p-0">
                                            <a href="${myDatas[
                                                "details_url"
                                            ].replace(
                                                "param",
                                                payment.encrypted_id
                                            )}">Details</a>
                                        </div>
                                    </div>
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
    updateUrlParameter("filter", myDatas["filter"]);
    $(".order_filter").on("change", function () {
        var filter_value = $(this).val();
        let url = myDatas["url"];
        let _url = url.replace("filter_value", filter_value);
        _url = _url.replace(/&amp;/g, "&");
        $.ajax({
            url: _url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var result = "";
                var payments = data.payments.data;
                if (payments.length === 0) {
                    result = `<h3 class="my-5 text-danger text-center">Payment Not Found</h3>`;
                } else {
                    result = getHtml(payments);
                }

                $(".payment_wrap").html(result);
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