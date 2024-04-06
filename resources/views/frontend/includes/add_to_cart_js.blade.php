<script>
    // Cart JS 
    $(document).ready(function() {

        // Add To Card JS 
        $(document).on('click', '.add_to_card .cart-btn', function() {
            let product_slug = $(this).data('product_slug');
            let unit_id = $(this).data('unit_id');
            let url = ("{{ route('product.add_to_cart', ['product' => 'product_slug']) }}");
            if (unit_id) {
                url = (
                    "{{ route('product.add_to_cart', ['product' => 'product_slug', 'unit' => 'unit_id']) }}");
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
                                                        <h4 class="text-end"> <span> &#2547; </span> <span class="item_count_price">${data.atc.product.item_count_price}</span></h4>
                                                    </div>
                                                </div>


                                                <div class="row align-items-center atc_functionality">
                                                    <div class="item_units col-7">
                                                        <div class="form-group my-1 boxed">
                        `;
                        data.atc.product.units.forEach(function(unit, index) {
                            var checked = '';
                            if ((data.atc.unit_id != null && unit.id == data.atc
                                    .unit_id) || index === 0) {
                                checked = 'checked';
                            }

                            result += `
                                        <input type="radio" data-name="${unit.name}" ${checked}
                                        class="unit_quantity" id="android-${index+20}"
                                        name="data-${count}"
                                        value="${ data.atc.product.price * unit.quantity }">
                                        <label for="android-${index+20}">
                                            <img src="${unit.image}">
                                        </label>
                                    `;
                            index++;
                        });
                        result += `
                                            </div>
                                        </div>


                                        {{-- Plus Minus  --}}
                                        <div class="plus_minus col-5 ps-md-4 d-flex align-items-center justify-between">
                                            <div class="form-group">
                                                <div class="input-group" role="group">
                                                    <a href="javascript:void(0)" class="btn btn-sm minus_btn "><i class="fa-solid fa-minus"></i></a>
                                                    <input type="text" disabled class="form-control text-center plus_minus_quantity" data-item_price="${data.atc.product.data_item_price}" value="1" >
                                                    <a href="javascript:void(0)" class="btn btn-sm plus_btn"><i class="fa-solid fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        `;
                        item_append.prepend(result);
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
            var text = "<h5 class='text-center cart_empty_alert'>{{ __('Added Some Products') }}</h5>";

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
            let url = "{{ route('product.clear_cart') }}";
            let cartItemContainer = $(this).parent('.offcanvas-header').next('.add_to_carts');
            let atc_total = $('#cart_btn_quantity strong');
            var text = "<h5 class='text-center cart_empty_alert'>{{ __('Added Some Products') }}</h5>";

            $.ajax({
                url: url,
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

    // Number Format Function 
    function numberFormat(value, decimals) {
        return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Price Refresh Function 
    function updateItemPrice(element) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var currentVal = parseInt(quantityInput.val()) || 0;
        var itemPrice = parseFloat(quantityInput.data('item_price')) || 0; // Ensure a valid number
        var total_price = itemPrice * currentVal;

        var itemContainer = element.closest('.add_to_cart_item');
        itemContainer.find('.item_count_price').html(numberFormat(total_price, 2));
        refreshSubtotal();
    }

    // Subtotal Refresh Function 
    function refreshSubtotal() {
        $('.total_check_item').html($('.add_to_carts').find('.add_to_cart_item').length)
        var total_price = 0;
        $('.add_to_carts').find('.add_to_cart_item').each(function() {
            var check_item_price = parseFloat($(this).closest('.add_to_cart_item').find('.item_count_price')
                .html());
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
        
        if(currentVal < 3 && increment == false){
            element.addClass('disabled')
        }
        if (!isNaN(currentVal) && (increment || currentVal > 1)) {
            
            
            quantityInput.val(increment ? currentVal + 1 : currentVal - 1);
            updateItemPrice(element);

            let type = (increment ? 'plus' : 'minus');
            let id = element.data('id');
            let url = "{{ route('cart.item.quantity',['id'=>'itemId', 'type'=>'quantityType']) }}";
            let _url = url.replace('itemId',id);
            let __url = _url.replace('quantityType',type);

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
    console.log($('.plus_minus_quantity').length);
    $('.plus_minus_quantity').each(function(){
        if($(this).val() == 1){
            $(this).prev('.minus_btn').addClass('disabled');
        }
    });
    

    // Unit Change JS 
    $(document).on('change', '.unit_quantity', function() {
        var formattedNumber = numberFormat($(this).val(), 2);
        var itemContainer = $(this).closest('.add_to_cart_item');
        var itemQuantityInput = itemContainer.find('.plus_minus_quantity');
        var itemQuantity = parseInt(itemQuantityInput.val()) || 0;
        itemQuantityInput.data('item_price', formattedNumber);
        if (!isNaN(itemQuantity)) {
            var totalItemPrice = formattedNumber * itemQuantity;
            itemContainer.find('.item_count_price').html(numberFormat(totalItemPrice, 2));
        }
        refreshSubtotal();
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
        let url = "{{ route('cart.item.check',['id'=>'itemId']) }}";
        let _url = url.replace('itemId',id);

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
