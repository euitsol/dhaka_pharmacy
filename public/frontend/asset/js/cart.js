// Global AJAX configuration
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    beforeSend: function () {
        $("#loading-animation").fadeIn();
    },
    complete: function () {
        $("#loading-animation").fadeOut();
    },
});

// Cart Module
const CartModule = (() => {
    // Core operations
    const operations = {
        addItem: (data) =>
            $.ajax({
                url: window.AppConfig.urls.cart.add,
                method: "POST",
                dataType: "json",
                data,
            }),

        removeItem: (cartIds) =>
            $.ajax({
                url: window.AppConfig.urls.cart.delete,
                method: "POST",
                dataType: "json",
                data: { carts: cartIds },
            }),

        updateItem: (data) =>
            $.ajax({
                url: window.AppConfig.urls.cart.update,
                method: "POST",
                dataType: "json",
                data: {
                    cart_id: data.cart_id,
                    unit_id: data.unit_id || null,
                    quantity: data.quantity || null,
                },
            }),

        getCart: () =>
            $.ajax({
                url: window.AppConfig.urls.cart.products,
                method: "GET",
                dataType: "json",
            }),
    };

    // Response handlers
    const handleResponse = (response) => {
        refreshCart();
        if (response.success) {
            toastr.success(response.message);
        } else if (response.requiresLogin) {
            handleLoginRequirement();
        } else {
            handleErrors(response);
        }
    };

    const handleError = (xhr) => {
        console.error("Error:", xhr.statusText);
        if (xhr.status === 401) handleLoginRequirement();
        else if (xhr.status === 422) handleErrors(xhr.responseJSON);
        else toastr.error("An unexpected error occurred. Please try again.");
    };

    return {
        operations,
        handleResponse,
        handleError,
    };
})();

// DOM Update Functions (keep existing implementation)
function updateCartDisplay(data) {
    var regularPrice,
        discountedPrice,
        isChecked,
        append,
        selectedUnitTotalDiscountedPrice,
        selectedUnitId,
        product;
    setCartCount(data.data.carts.length);
    var cart_div = $(".cart_items");
    cart_div.empty();

    data.data.carts.forEach((cart) => {
        product = cart.product;

        selectedUnitId = cart.selected_unit
            ? cart.selected_unit.id
            : cart.unit_id;
        selectedUnitTotalDiscountedPrice = cart.selected_unit
            ? cart.selected_unit.discounted_price * cart.quantity
            : 0;
        console.log(product);
        append = `
        <div class="card add_to_cart_item mb-2">
            <div class="card-body py-2">
                <div class="row product_details mb-2">
                    <div class="ben">
                        <div class="text-end">
                            <a href="javascript:void(0)" data-atc_id="${
                                cart.id
                            }" class="text-danger cart_remove_btn">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    </div>
                    <div class="image col-4 col-sm-2 item_${cart.id}">
                        <a href="/product-details/${product.slug}">
                            <img class="border border-1 rounded-1" src="${
                                product.image
                            }" alt="${product.name}">
                        </a>
                    </div>
                    <div class="col-8 col-sm-10">
                        <div class="row">
                            <div class="col-sm-8 col-12 info px-0 px-sm-3">
                                <h4 class="product_title" title="${
                                    product.attr_title
                                }">
                                    <a href="${product.slug}">${
            product.name
        }</a>
                                </h4>
                                <p class="m-0" title="${
                                    product.pro_cat.name
                                }" ><a href="#">${product.pro_cat.name}</a></p>
                                <p class="m-0" title="${
                                    product.generic.name
                                }" ><a href="#">${product.generic.name}</a></p>
                                <p class="m-0" title="${
                                    product.company.name
                                }" ><a href="#">${product.company.name}</a></p>
                            </div>
                            <div class="item_price col-sm-4 mt-2 mt-sm-5 col-12 ps-0">
                                ${
                                    product.discounted_price != product.price
                                        ? `<h4 class="text-start text-sm-end">
                                        <del class="text-danger">৳ <span class="item_count_regular_price">${Number(
                                            cart.selected_unit.price *
                                                cart.quantity
                                        ).toFixed(2)}</span></del>
                                    </h4>`
                                        : ""
                                }
                                <h4 class="text-start text-sm-end">
                                    <span>৳</span> <span class="item_count_price" data-total="${selectedUnitTotalDiscountedPrice}">${Number(
            selectedUnitTotalDiscountedPrice
        ).toFixed(2)}</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="unit-badge mb-2">
                    <span class="fw-medium">${cart.selected_unit.name}</span>
                </div>
                <div class="row align-items-center atc_functionality row-gap-2">
                    <div class="item_units col-sm-8 col-12">
                        <div class="form-group my-1 boxed">
                            ${product.units
                                .map((unit, u_key) => {
                                    isChecked = unit.id == selectedUnitId;
                                    if (isChecked) {
                                        regularPrice = cart.selected_unit.price;
                                        discountedPrice =
                                            cart.selected_unit.discounted_price;
                                    } else {
                                        regularPrice =
                                            product.price *
                                            unit.quantity *
                                            cart.quantity;
                                        discountedPrice =
                                            product.discounted_price *
                                            unit.quantity *
                                            cart.quantity;
                                    }

                                    return `
                                <input type="radio"
                                    data-cart_id="${cart.id}"
                                    data-id="${unit.id}"
                                    class="unit_quantity"
                                    id="unit_${cart.id + "_" + unit.id}"
                                    name="data-${cart.id}"
                                    data-regular_price="${regularPrice}"
                                    value="${discountedPrice}"
                                    ${isChecked ? "checked" : ""}
                                    >
                                <label for="unit_${cart.id + "_" + unit.id}">
                                    <img src="${unit.image}" title="${
                                        unit.name
                                    }">
                                </label>
                                `;
                                })
                                .join("")}
                        </div>
                    </div>
                    <div class="plus_minus col-sm-4 col-6 ps-md-4 d-flex align-items-center justify-between">
                        <div class="form-group">
                            <div class="input-group" role="group">
                                <a href="javascript:void(0)" data-id="${
                                    cart.id
                                }" class="btn btn-sm minus_btn ${
            cart.quantity <= 1 ? "disabled" : ""
        }">
                                    <i class="fa-solid fa-minus"></i>
                                </a>
                                <input type="number" min="1" disabled
                                    class="form-control text-center plus_minus_quantity"
                                    data-item_discounted_price="${discountedPrice}"
                                    data-item_regular_price="${regularPrice}"
                                    value="${cart.quantity}">
                                <a href="javascript:void(0)" data-id="${
                                    cart.id
                                }" class="btn btn-sm plus_btn">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        cart_div.append(append);
    });
    $(".subtotal_price").html(
        numberFormat(data.data.total_discounted_price, 2)
    );
}

function setCartCount(count) {
    sessionStorage.setItem("cart_product_count", count);
    displayCartCount();
}

function getCartCount() {
    return sessionStorage.getItem("cart_product_count")
        ? parseInt(sessionStorage.getItem("cart_product_count"))
        : 0;
}

function displayCartCount() {
    if (getCartCount() > 0) {
        $("#cart_btn_quantity").show();
        $("#cart_btn_quantity").html(getCartCount());
    } else {
        $("#cart_btn_quantity").hide();
        $("#cart_btn_quantity").html();
    }

    $(".total_check_item").text(getCartCount());
}

function unitImage(url) {
    return url
        ? `${window.location.origin}/storage/${url}`
        : `${window.location.origin}/frontend/default/default.png`;
}

// Cart Actions
function refreshCart() {
    CartModule.operations
        .getCart()
        .done((response) => updateCartDisplay(response))
        .fail((xhr) => CartModule.handleError(xhr));
}

function changeQuantity(element, increment) {
    const input = element.siblings(".plus_minus_quantity");
    const quantity = parseInt(input.val()) + (increment ? 1 : -1);

    CartModule.operations
        .updateItem({
            cart_id: element.data("id"),
            quantity: quantity,
        })
        .done(CartModule.handleResponse)
        .fail(CartModule.handleError);
}

// Event Handlers
$(document).ready(() => {
    displayCartCount();

    //Cart button on header
    $("#cart_icon_btn").on("click", () => {
        refreshCart();
    });
    // Add to Cart
    $(document).on(
        "click",
        ".add_to_card .cart-btn:not(.no-cart)",
        function () {
            CartModule.operations
                .addItem({
                    slug: $(this).data("product_slug"),
                    unit: $(this).data("unit_id") || null,
                    quantity: $(this).data("quantity") || 1,
                })
                .done(CartModule.handleResponse)
                .fail(CartModule.handleError);
        }
    );

    // Remove Item
    $(document).on("click", ".cart_remove_btn", function () {
        CartModule.operations
            .removeItem([$(this).data("atc_id")])
            .done(CartModule.handleResponse)
            .fail(CartModule.handleError);
    });

    // Clear Cart
    $(document).on("click", ".cart_clear_btn", function () {
        const cartIds = $(".cart_remove_btn")
            .map((i, el) => $(el).data("atc_id"))
            .get();
        CartModule.operations
            .removeItem(cartIds)
            .done(CartModule.handleResponse)
            .fail(CartModule.handleError);
    });

    // Quantity Controls
    $(document).on("click", ".plus_btn, .minus_btn", function () {
        changeQuantity($(this), $(this).hasClass("plus_btn"));
    });

    // Unit Change
    $(document).on("change", ".unit_quantity", function () {
        CartModule.operations
            .updateItem({
                cart_id: $(this).data("cart_id"),
                unit_id: $(this).data("id"),
            })
            .done(CartModule.handleResponse)
            .fail(CartModule.handleError);
    });

    // Checkout Validation
    $("#checkoutBtn").on("click", function (e) {
        e.preventDefault();
        if (checkoutValidation()) $("#checkoutForm").submit();
        setCartCount(0);
    });
});

// Utility Functions
function handleLoginRequirement() {
    window.location.href = routes.login;
}

function handleErrors(response) {
    var errors = response.errors;
    for (var field in errors) {
        toastr.error(errors[field][0]);
    }
}

function checkoutValidation() {
    let isValid = true;
    $(".add_to_cart_item").each(function () {
        if (!$(this).find(".item_units .unit_quantity:checked").length) {
            toastr.error("Plese select item unit");
            isValid = false;
            return false;
        }
    });
    return isValid;
}
