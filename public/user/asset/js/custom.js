function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function updateUrlParameter(param, value) {
    var url = new URL(window.location.href);
    url.searchParams.set(param, value);
    window.history.pushState({}, "", url);
};