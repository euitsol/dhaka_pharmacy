function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}