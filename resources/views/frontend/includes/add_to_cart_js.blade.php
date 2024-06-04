<script>
    $(document).ready(function() {

        // Add To Card JS 
        $(document).on('click', '.add_to_card .cart-btn', function() {
            let product_slug = $(this).data('product_slug');
            let unit_id = $(this).data('unit_id');
            let url = ("{{ route('product.add_to_cart', ['product' => 'product_slug']) }}");
            if (unit_id) {
                url = (
                    "{{ route('product.add_to_cart', ['product' => 'product_slug', 'unit' => 'unit_id']) }}"
                );
                url = url.replace('unit_id', unit_id);
            }
            let _url = url.replace('product_slug', product_slug);
            let __url = _url.replace(/&amp;/g, '&');

            let atc_total = $('#cart_btn_quantity strong');
            let plus_atc_total = parseInt(atc_total.html()) + 1;

            var item_append = $('.add_to_carts');
            var cart_empty_alert = $('.cart_empty_alert');

            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {




                    if (data.atc) {
                        let regular_price = '';
                        if (data.atc.product.discount) {
                            regular_price =
                                `<h4 class="text-end"> <del class="text-danger"> {!! get_taka_icon() !!}  <span class="item_count_regular_price">${numberFormat(data.atc.product.data_item_price,2)}</span></del></h4>`;
                        }
                        var count = data.count;
                        var result = `
                                    <div class="card add_to_cart_item mb-2">
                                            <div class="card-body py-2">
                                                {{-- Product Details  --}}
                                                <div class="row align-items-center product_details mb-2">
                                                    <div class="ben">
                                                    <div class="text-end">
                                                        <a href="javascript:void(0)" data-atc_id ="${data.atc.id}" class="text-danger cart_remove_btn"><i class="fa-solid fa-trash-can"></i></a>
                                                    </div>
                                                </div>
                                                    <div class="image col-2">
                                                        <a href="">
                                                            <img class="border border-1 rounded-1"
                                                            src="${data.atc.product.image}"
                                                            alt="${data.atc.product.name}">
                                                        </a>
                                                    </div>
                                                    <div class="col-8 info">
                                                        <h4 class="product_title" title="${data.atc.product.attr_title}"> <a href="">${data.atc.product.name}</a></h4>
                                                        <p><a href="">${data.atc.product.pro_sub_cat.name}</a></p>
                                                        <p><a href="">${data.atc.product.generic.name}</a></p>
                                                        <p><a href="">${data.atc.product.company.name}</a></p>
                                                    </div>
                                                    <div class="item_price col-2 ps-0">
                                                        ${regular_price}
                                                        <h4 class="text-end"> <span> {!! get_taka_icon() !!} </span> <span class="item_count_price">${numberFormat(data.atc.product.data_item_discount_price,2)}</span></h4>
                                                    </div>
                                                </div>


                                                <div class="row align-items-center atc_functionality">
                                                    <div class="item_units col-7">
                                                        <div class="form-group my-1 boxed">
                        `;
                        var random_num1 = Math.floor(100000 + Math.random() * 900000);
                        var random_num2 = Math.floor(100000 + Math.random() * 900000);
                        data.atc.product.units.forEach(function(unit, index) {
                            var checked = '';
                            if ((data.atc.unit_id != null && unit.id == data.atc
                                    .unit_id) || index === 0) {
                                checked = 'checked';
                            }

                            result += `
                                        <input type="radio" data-name="${unit.name}" ${checked}
                                        class="unit_quantity" data-cart_id="${data.atc.id}" data-id="${unit.id}" id="android-${random_num1}"
                                        name="data-${random_num2}"
                                        value="${ (data.atc.product.discountPrice * unit.quantity)*data.atc.quantity }" data-regular_price="${ (data.atc.product.price * unit.quantity)*data.atc.quantity }">
                                        <label for="android-${random_num1}}">
                                            <img src="${unit.image}">
                                        </label>
                                    `;
                            random_num1++;
                        });
                        result += `
                                            </div>
                                        </div>


                                        {{-- Plus Minus  --}}
                                        <div class="plus_minus col-5 ps-md-4 d-flex align-items-center justify-between">
                                            <div class="form-group">
                                                <div class="input-group" role="group">
                                                    <a href="javascript:void(0)" data-id="${data.atc.id}" class="btn btn-sm minus_btn "><i class="fa-solid fa-minus"></i></a>
                                                    <input type="text" disabled class="form-control text-center plus_minus_quantity" data-item_price="${parseFloat(data.atc.product.data_item_discount_price)}"  data-item_regular_price="${parseFloat(data.atc.product.data_item_price)}" value="1" >
                                                    <a href="javascript:void(0)" data-id="${data.atc.id}" class="btn btn-sm plus_btn"><i class="fa-solid fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        `;
                        item_append.append(result);
                        cart_empty_alert.remove();
                        atc_total.html(plus_atc_total);
                        toastr.success(data.alert);
                        $('.order_button').removeClass('disabled');

                        refreshSubtotal();
                    } else {
                        toastr.error(data.alert);
                    }
                },
                error: function(xhr, status, error) {
                    var loginUrl = '{{ route('login') }}';
                    window.location.href = loginUrl;
                    console.error('Error add to cart data:', error);
                }
            });
        });

        // Remove From Cart JS 
        $(document).on('click', '.cart_remove_btn', function() {
            let atc_id = $(this).data('atc_id');
            let url = ("{{ route('product.remove_to_cart', ['atc' => 'atc_id']) }}");
            let _url = url.replace('atc_id', atc_id);
            let cartItem = $(this).closest('.add_to_cart_item');
            let atc_total = $('#cart_btn_quantity strong');
            let minus_atc_total = parseInt(atc_total.html()) - 1;
            var text = "<h5 class='text-center cart_empty_alert'>{{ __('Add some product') }}</h5>";

            var item_append = $('.add_to_carts');
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    toastr.success(data.sucses_alert);

                    atc_total.html(minus_atc_total);
                    cartItem.remove();
                    if (minus_atc_total === 0) {
                        item_append.html(text);
                        $('.order_button').addClass('disabled');
                    }
                    refreshSubtotal();
                },
                error: function(xhr, status, error) {
                    console.error('Error add to cart data:', error);
                }
            });
        });


        // Cart Clear JS 

        $(document).on('click', '.cart_clear_btn', function() {
            let uid = $(this).data('uid');
            let url = "{{ route('product.clear_cart', ['uid' => 'id']) }}";
            let _url = url.replace('id', uid);
            let cartItemContainer = $(this).parent('.offcanvas-header').next('.add_to_carts');
            let atc_total = $('#cart_btn_quantity strong');
            var text = "<h5 class='text-center cart_empty_alert'>{{ __('Add some product') }}</h5>";

            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.count != 0) {
                        toastr.success(data.alert);
                        atc_total.html(0);
                        cartItemContainer.find('.add_to_cart_item').remove();
                        cartItemContainer.html(text);
                        refreshSubtotal();
                    } else {
                        toastr.error(data.alert);
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error clearing cart data:', error);
                }
            });
        });
    });

    ////////////////////////////////////////////////////
    //Price Calculation 
    ////////////////////////////////////////////////////



    // Price Refresh Function 
    function updateItemPrice(element) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var currentVal = parseInt(quantityInput.val()) || 0;
        var itemPrice = parseFloat(quantityInput.data('item_price')) || 0; // Ensure a valid number
        var total_price = itemPrice * currentVal;
        var itemRegularPrice = parseFloat(quantityInput.data('item_regular_price')) || 0; // Ensure a valid number
        var total_regular_price = itemRegularPrice * currentVal;

        var itemContainer = element.closest('.add_to_cart_item');
        itemContainer.find('.item_count_price').html(numberFormat(total_price, 2));
        itemContainer.find('.item_count_regular_price').html(numberFormat(total_regular_price, 2));
        refreshSubtotal();
    }

    // Subtotal Refresh Function 
    function refreshSubtotal() {
        $('.total_check_item').html($('.add_to_carts').find('.add_to_cart_item').length)
        var total_price = 0;
        $('.add_to_carts').find('.add_to_cart_item').each(function() {
            var check_item_price = $(this).closest('.add_to_cart_item').find('.item_count_price')
                .html();
            check_item_price = check_item_price.replace(',', '');
            check_item_price = parseFloat(check_item_price);
            total_price += check_item_price;
        });
        $('.subtotal_price').html(numberFormat(total_price, 2));
    }
    refreshSubtotal();

    // Increment or Decrement Quantity Function
    function changeQuantity(element, increment) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var currentVal = parseInt(quantityInput.val()) || 0;
        element.parent('.input-group').find('.minus_btn').removeClass('disabled');

        if (currentVal < 3 && increment == false) {
            element.addClass('disabled')
        }
        if (!isNaN(currentVal) && (increment || currentVal > 1)) {


            quantityInput.val(increment ? currentVal + 1 : currentVal - 1);
            updateItemPrice(element);

            let type = (increment ? 'plus' : 'minus');
            let id = element.data('id');
            let url = "{{ route('cart.item.quantity', ['id' => 'itemId', 'type' => 'quantityType']) }}";
            let _url = url.replace('itemId', id);
            let __url = _url.replace('quantityType', type);

            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data.alert);
                },
                error: function(xhr, status, error) {
                    console.error('Error clearing cart data:', error);
                }
            });
        }
        refreshSubtotal();
    }

    // Plus JS 
    $(document).on('click', '.plus_btn', function() {
        changeQuantity($(this), true);
    });

    // Minus JS 
    $(document).on('click', '.minus_btn', function() {
        changeQuantity($(this), false);
    });

    $('.plus_minus_quantity').each(function() {
        if ($(this).val() == 1) {
            $(this).prev('.minus_btn').addClass('disabled');
        }
    });


    // Unit Change JS 
    $(document).on('change', '.unit_quantity', function() {
        var unit_id = $(this).data('id');
        var cart_id = $(this).data('cart_id');
        var formattedPrice = parseFloat($(this).val());
        var formattedRegularPrice = parseFloat($(this).data('regular_price'));
        var itemContainer = $(this).closest('.add_to_cart_item');
        var itemQuantityInput = itemContainer.find('.plus_minus_quantity');
        var itemQuantity = parseInt(itemQuantityInput.val()) || 0;
        itemQuantityInput.data('item_price', formattedPrice);
        itemQuantityInput.data('item_regular_price', formattedRegularPrice);
        if (!isNaN(itemQuantity)) {

            var totalItemPrice = formattedPrice * itemQuantity;
            var totalItemRegularPrice = formattedRegularPrice * itemQuantity;

            console.log(totalItemPrice);
            console.log(totalItemRegularPrice);

            let url = "{{ route('cart.item.unit', ['unit_id' => 'unitId', 'cart_id' => 'cartId']) }}";
            let _url = url.replace('unitId', unit_id);
            let __url = _url.replace('cartId', cart_id);
            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log(data.alert);
                    itemContainer.find('.item_count_price').html(numberFormat(totalItemPrice, 2));
                    itemContainer.find('.item_count_regular_price').html(numberFormat(
                        totalItemRegularPrice, 2));
                    refreshSubtotal();
                },
                error: function(xhr, status, error) {
                    console.error('Error clearing cart data:', error);
                }
            });

        }
    });



    // Subtotal JS 
    $(document).on('change', '.check_atc_item', function() {
        var check = $(this).prop('checked');
        var subtotal_price = $('.subtotal_price');
        var formatted_subtotal_price = parseFloat(subtotal_price.html());
        var check_item_price = parseFloat($(this).closest('.add_to_cart_item').find('.item_count_price')
            .html());
        var total_check_item = $('.total_check_item');
        var summation = 0;
        if (check == true) {
            summation = (formatted_subtotal_price + check_item_price);
            total_check_item.html(parseInt(total_check_item.html()) + 1);
        } else {
            summation = (formatted_subtotal_price - check_item_price);
            total_check_item.html(parseInt(total_check_item.html()) - 1);
        }
        subtotal_price.html(numberFormat(summation, 2));


        let id = $(this).data('id');
        let url = "{{ route('cart.item.check', ['id' => 'itemId']) }}";
        let _url = url.replace('itemId', id);

        $.ajax({
            url: _url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log(data.alert);
            },
            error: function(xhr, status, error) {
                console.error('Error clearing cart data:', error);
            }
        });



    });
</script>
