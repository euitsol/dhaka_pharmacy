<script>
    $(document).ready(function() {
        refreshCart();
        $(document).on('click', '.add_to_card .cart-btn', function() {
            let product_slug = $(this).data('product_slug');
            let unit_id = $(this).data('unit_id');
            let url = routes.cart_add;

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: {
                    'slug': product_slug,
                    'unit': unit_id ? unit_id : null
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCart(); // refresh the cart to show added product
                    } else if (response.requiresLogin) {
                        handleLoginRequirement();
                    } else {
                        handleErrors(response);
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        });

        // Remove From Cart JS
        $(document).on('click', '.cart_remove_btn', function() {
            let atc_id = $(this).data('atc_id');
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url: routes.cart_delete,
                method: 'POST',
                dataType: 'json',
                data: {
                    carts: [atc_id],
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCart();
                    } else if (response.requiresLogin) {
                        handleLoginRequirement();
                    } else {
                        handleErrors(response);
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        });


        // Cart Clear JS

        $(document).on('click', '.cart_clear_btn', function() {
            var atcs = [];

            $('.cart_remove_btn').each(function(e) {
                if ($(this).attr('data-atc_id')) {
                    atcs.push(parseInt($(this).attr('data-atc_id')));
                }
            });

            console.log(atcs);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({
                url: routes.cart_delete,
                method: 'POST',
                dataType: 'json',
                data: {
                    carts: atcs,
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        toastr.success(response.message);
                        refreshCart();
                    } else if (response.requiresLogin) {
                        handleLoginRequirement();
                    } else {
                        handleErrors(response);
                    }
                },
                error: function(XHR, textStatus, errorThrown) {
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        });

        // Plus JS
        $(document).on('click', '.plus_btn', function() {
            changeQuantity($(this), true);
        });

        // Minus JS
        $(document).on('click', '.minus_btn', function() {
            changeQuantity($(this), false);
        });

        // Unit Change JS
        $(document).on('change', '.unit_quantity', function() {
            var unit_id = $(this).data('id');
            var cart_id = $(this).data('cart_id');
            updateCart(cart_id, unit_id);
        });

        $('#checkoutBtn').on('click', function(e) {
            e.preventDefault();
            if (checkoutValidation()) {
                $('#checkoutForm').submit();
            }
        });
    });

    function checkoutValidation() {
        return true;
    }

    function handleLoginRequirement() {
        window.location.href = routes.login;
    }

    function handleErrors(response) {
        var errors = response.errors;
        for (var field in errors) {
            toastr.error(errors[field][0]);
        }
    }

    function refreshCart() {
        $.ajax({
            url: routes.cart_products,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                updateCartDisplay(response.data);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }

    function updateCartDisplay(carts) {
        var cart_div = $('.cart_items');
        cart_div.empty();
        var append = '';
        $.each(carts, function(index, cart) {
            var product = cart.product;
            append = `
            <div class="card add_to_cart_item mb-2">
                <div class="card-body py-2">
                    <div class="row align-items-center product_details mb-2">
                        <div class="ben">
                            <div class="text-end">
                                <a href="javascript:void(0)" data-atc_id="${cart.id}" class="text-danger cart_remove_btn">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </div>
                        </div>
                        <div class="image col-2 item_${cart.id}">
                            <a href="${product.slug}">
                                <img class="border border-1 rounded-1" src="${product.image}" alt="${product.name}">
                            </a>
                        </div>
                        <div class="col-8 info">
                            <h4 class="product_title" title="${product.attr_title}">
                                <a href="${product.slug}">${product.name}</a>
                            </h4>
                            <p><a href="#">${product.pro_cat.name}</a></p>
                            <p><a href="#">${product.generic.name}</a></p>
                            <p><a href="#">${product.company.name}</a></p>
                        </div>
                        <div class="item_price col-2 ps-0">
                            ${product.discounted_price != product.price ?
                                `<h4 class="text-end">
                                    <del class="text-danger">৳ <span class="item_count_regular_price">${Number(product.price).toFixed(2)}</span></del>
                                </h4>`
                                : ''}
                            <h4 class="text-end">
                                <span>৳</span> <span class="item_count_price">${Number(product.discounted_price).toFixed(2)}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="row align-items-center atc_functionality">
                        <div class="item_units col-8">
                            <div class="form-group my-1 boxed">
                                ${product.units.map((unit, u_key) => `
                                    <input type="radio" data-cart_id="${cart.id}" data-id="${unit.id}" data-name="${unit.name}"
                                        ${unit.id == cart.unit_id ? 'checked' : ''} class="unit_quantity"
                                        id="unit_${cart.id +'_'+ unit.id}" name="data-${cart.id}"
                                        data-regular_price="${product.price * unit.quantity * cart.quantity}"
                                        value="${product.discounted_price * unit.quantity * cart.quantity}">
                                    <label for="unit_${cart.id +'_'+ unit.id}">
                                        <img src="${unitImage(unit.image)}" title="${unit.name}">
                                    </label>
                                `).join('')}
                            </div>
                        </div>
                        <div class="plus_minus col-4 ps-md-4 d-flex align-items-center justify-between">
                            <div class="form-group">
                                <div class="input-group" role="group">
                                    <a href="javascript:void(0)" data-id="${cart.id}" class="btn btn-sm minus_btn ${cart.quantity <= 1 ? 'disabled':''}">
                                        <i class="fa-solid fa-minus"></i>
                                    </a>
                                    <input type="number" min="1"  disabled class="form-control text-center plus_minus_quantity"
                                        data-item_price="${product.discounted_price}"
                                        data-item_regular_price="${product.price}"
                                        data-unit_quantity="${cart.unit ? cart.unit.quantity:1 }"
                                        value="${cart.quantity}">
                                    <a href="javascript:void(0)" data-id="${cart.id}" class="btn btn-sm plus_btn">
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
            updateItemPrice($('.item_' + cart.id));
        });

        refreshSubtotal();
    }


    function unitImage(url) {
        return url ? `${window.location.origin}/storage/${url}` :
            `${window.location.origin}/frontend/default/default.png`;
    }

    // Price Refresh Function
    function updateItemPrice(element) {
        cardBody = element.closest('.card-body');
        var quantityInput = cardBody.find(".plus_minus_quantity");

        var itemContainer = element.closest('.add_to_cart_item');
        var quantity = parseInt(quantityInput.val()) || 1;
        var unit_quantity = parseInt(quantityInput.attr('data-unit_quantity')) || 1;


        var itemPrice = parseFloat(quantityInput.data('item_price')) || 1;
        itemContainer.find('.item_count_price').html(numberFormat(itemPrice * quantity * unit_quantity, 2));
        itemContainer.find('.item_count_price').attr('data-total', itemPrice * quantity * unit_quantity);

        var itemRegularPrice = parseFloat(quantityInput.data('item_regular_price'));
        if (itemRegularPrice) {
            itemContainer.find('.item_count_regular_price').html(numberFormat(itemRegularPrice * quantity *
                unit_quantity, 2));
        }

        refreshSubtotal();
    }

    // Subtotal Refresh Function
    function refreshSubtotal() {
        $('.total_check_item').html($('.item_count_price').length);
        if ($('#cart_btn_quantity').html($('.item_count_price').length));
        var total_price = 0;
        $('.item_count_price').each(function(e) {
            item_price = parseFloat($(this).attr('data-total'));
            total_price += item_price;
        });
        console.log(total_price);
        $('.subtotal_price').html(numberFormat(total_price, 2));
    }
    refreshSubtotal();

    // Increment or Decrement Quantity Function
    function changeQuantity(element, increment) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var quantity = parseInt(quantityInput.val()) || 1;

        //if decreasing disable at 1
        if (quantity == 2 && increment == false) {
            element.addClass('disabled');
        } else {
            element.parent('.input-group').find('.minus_btn').removeClass('disabled');
        }
        quantity = increment ? quantity + 1 : quantity - 1;
        quantityInput.val(quantity);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: routes.cart_update,
            method: 'POST',
            dataType: 'json',
            data: {
                'cart': element.attr('data-id'),
                'quantity': quantity,
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    var item = $('.item_' + response.data.id);
                    updateItemPrice(item);
                } else if (response.requiresLogin) {
                    handleLoginRequirement();
                } else {
                    handleErrors(response);
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }

    function updateCart(cart_id, unit_id = null, quantity = null) {
        var reg_price = 0;
        var discounted_price = 0;
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: routes.cart_update,
            method: 'POST',
            dataType: 'json',
            data: {
                'cart': cart_id,
                'unit': unit_id,
                'quantity': quantity,
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.data.unit.quantity);
                    toastr.success(response.message);
                    var item = $('.item_' + response.data.id);
                    cardBody = item.closest('.card-body');
                    cardBody.find(".plus_minus_quantity").attr('data-unit_quantity', parseInt(response.data
                        .unit.quantity));
                    updateItemPrice(item);
                } else if (response.requiresLogin) {
                    handleLoginRequirement();
                } else {
                    handleErrors(response);
                }

            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
        });
    }
</script>
