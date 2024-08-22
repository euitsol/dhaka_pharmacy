function refreshDeliveryFee(e = false) {
    var delivery_fee;
    if (e == false) {
        setTimeout(function () {
            delivery_fee = $(".address option").length
                ? $(".address option:selected")
                      .data("charge")
                      .toString()
                      .replace(",", "")
                : 0;

            console.log(delivery_fee);
            $(".delivery_fee").text(
                numberFormat(Math.ceil(parseInt(delivery_fee)))
            );
            var total_price =
                parseInt($(".total_price").data("total_price")) +
                parseInt(delivery_fee);
            total_price = numberFormat(Math.ceil(total_price));
            $(".total_price").text(total_price);

            $(".confirm_button").prop("disabled", false);
        }, 1500);
    } else {
        delivery_fee = e.data("charge").toString().replace(",", "");
        $(".delivery_fee").text(
            numberFormat(Math.ceil(parseInt(delivery_fee)))
        );
        var total_price =
            parseInt($(".total_price").data("total_price")) +
            parseInt(delivery_fee);
        total_price = numberFormat(Math.ceil(total_price));
        $(".total_price").text(total_price);
    }
}
$(document).ready(function () {
    refreshDeliveryFee();
});

$(document).ready(function () {
    $(".address").on("change", function () {
        refreshDeliveryFee($(this).find(":selected"));
    });
});
