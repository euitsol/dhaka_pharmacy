<script>
    // Cart JS 
    $(document).ready(function() {

        // Add To Card JS 
        $(document).on('click', '.add_to_card .cart-btn', function() {
            let product_slug = $(this).data('product_slug');
            let unit_id = $(this).data('unit_id');
            let url = ("{{ route('product.add_to_cart', ['product' => 'product_slug']) }}");
            if (unit_id) {
                url = ("{{ route('product.add_to_cart', ['product' => 'product_slug', 'unit' => 'unit_id']) }}");
                url = url.replace('unit_id', unit_id);
            }
            let _url = url.replace('product_slug', product_slug);
            let __url = _url.replace(/&amp;/g, '&');

            $.ajax({
                url: __url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.alert !== null) {
                        toastr.error(data.alert);
                    } else {
                        $('#cart_btn_quantity').html(data.total_cart_item);
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
            $.ajax({
                url: _url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    toastr.success(data.sucses_alert);
                    $('#cart_btn_quantity').html(data.total_cart_item);
                },
                error: function(xhr, status, error) {
                    console.error('Error add to cart data:', error);
                }
            });
        });
    });

    /////////////////////////////////////////
    // Won Codes 
    ///////////////////////////////////////////

    // Item Plus Minus Calculation JS 

    // function numberFormat(value, decimals) {
    //     return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    // }
    // var container = $('.add_to_carts');
    // var plus_btn = '.plus_btn';
    // var minus_btn = '.minus_btn';
    // var unit = '.unit_quantity';

    // $(document).on('click', plus_btn, function() {
    //     var quantity = $(this).siblings('.plus_minus_quantity');
    //     if (isNaN(quantity.val())) {
    //         quantity.val(1);
    //     } else {
    //         var currentVal = parseInt(quantity.val());
    //         quantity.val(currentVal + 1);
    //     }
    //     var item_price = quantity.data('item_price');
    //     var quantity_val = quantity.val();
    //     var total_price = item_price * quantity_val;
    //     $(this).closest('.add_to_cart_item').find('.item_count_price').html(numberFormat(total_price, 2));




    // });

    // $(document).on('click', minus_btn, function() {
    //     var quantity = $(this).siblings('.plus_minus_quantity');
    //     var currentVal = parseInt(quantity.val());
    //     if (currentVal > 1) {
    //         quantity.val(currentVal - 1);
    //     }
    //     var item_price = quantity.data('item_price');
    //     var quantity_val = quantity.val();
    //     var total_price = item_price * quantity_val;
    //     $(this).closest('.add_to_cart_item').find('.item_count_price').html(numberFormat(total_price, 2));
    // });



    // $(document).on('change', unit, function() {
    //     var formattedNumber = numberFormat($(this).val(), 2);
    //     var item_quantity = $(this).closest('.add_to_cart_item').find('.plus_minus_quantity').val();
    //     var total_item_price = formattedNumber*item_quantity;
    //     $(this).closest('.add_to_cart_item').find('.plus_minus_quantity').data('item_price', formattedNumber);
    //     $(this).closest('.add_to_cart_item').find('.item_count_price').html(numberFormat(total_item_price,2));
    // });




    ////////////////////////////////////////////////////
    //1st Optimize 
    ////////////////////////////////////////////////////

    // // Number Format Function 
    // function numberFormat(value, decimals) {
    //     return parseFloat(value).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    // }
    // // Price Refresh Function 
    // function updateItemPrice(element) {
    //     var quantityInput = element.siblings('.plus_minus_quantity');
    //     var currentVal = parseInt(quantityInput.val());
    //     var itemPrice = parseFloat(quantityInput.data('item_price')) || 0; // Ensure a valid number
    //     var total_price = itemPrice * currentVal;

    //     var itemContainer = element.closest('.add_to_cart_item');
    //     itemContainer.find('.item_count_price').html(numberFormat(total_price, 2));
    // }

    // var container = $('.add_to_carts');
    // var plus_btn = '.plus_btn';
    // var minus_btn = '.minus_btn';
    // var unit = '.unit_quantity';

    // // Plus JS 
    // $(document).on('click', plus_btn, function() {
    //     var quantityInput = $(this).siblings('.plus_minus_quantity');
    //     if (isNaN(quantityInput.val())) {
    //         quantityInput.val(1);
    //     } else {
    //         quantityInput.val(parseInt(quantityInput.val()) + 1);
    //     }
    //     updateItemPrice($(this));
    // });

    // // Minus JS 
    // $(document).on('click', minus_btn, function() {
    //     var quantityInput = $(this).siblings('.plus_minus_quantity');
    //     var currentVal = parseInt(quantityInput.val());
    //     if (currentVal > 1) {
    //         quantityInput.val(currentVal - 1);
    //         updateItemPrice($(this));
    //     }
    // });

    // // Unit Change JS 
    // $(document).on('change', unit, function() {
    //     var formattedNumber = numberFormat($(this).val(), 2);
    //     var itemContainer = $(this).closest('.add_to_cart_item');
    //     var itemQuantityInput = itemContainer.find('.plus_minus_quantity');
    //     var itemQuantity = parseInt(itemQuantityInput.val()) || 0;
    //     itemQuantityInput.data('item_price', formattedNumber);
    //     if (!isNaN(itemQuantity)) {
    //         var totalItemPrice = formattedNumber * itemQuantity;
    //         itemContainer.find('.item_count_price').html(numberFormat(totalItemPrice, 2));
    //     }
    // });


    ////////////////////////////////////////////////////
    //2nd Optimize 
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
    }

    // Increment or Decrement Quantity Function
    function changeQuantity(element, increment) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var currentVal = parseInt(quantityInput.val()) || 0;
        if (!isNaN(currentVal) && (increment || currentVal > 1)) {
            quantityInput.val(increment ? currentVal + 1 : currentVal - 1);
            updateItemPrice(element);
        }
    }

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
        var formattedNumber = numberFormat($(this).val(), 2);
        var itemContainer = $(this).closest('.add_to_cart_item');
        var itemQuantityInput = itemContainer.find('.plus_minus_quantity');
        var itemQuantity = parseInt(itemQuantityInput.val()) || 0;
        itemQuantityInput.data('item_price', formattedNumber);
        if (!isNaN(itemQuantity)) {
            var totalItemPrice = formattedNumber * itemQuantity;
            itemContainer.find('.item_count_price').html(numberFormat(totalItemPrice, 2));
        }
    });

</script>
