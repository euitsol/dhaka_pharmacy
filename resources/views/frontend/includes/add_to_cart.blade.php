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
                    if(data.atcs) {
                        $('#cart_btn_quantity').html(data.total_cart_item);
                        toastr.success(data.alert);
                    }else{
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
    function refreshSubtotal(){
        $('.total_check_item').html($('.add_to_carts').find('.check_atc_item:checked').length)
        var total_price = 0;
        $('.add_to_carts').find('.check_atc_item:checked').each(function() {
            var check_item_price = parseFloat($(this).closest('.add_to_cart_item').find('.item_count_price').html());
            total_price+=check_item_price;   
        });
        $('.subtotal_price').html(numberFormat(total_price,2));
    }

    // Increment or Decrement Quantity Function
    function changeQuantity(element, increment) {
        var quantityInput = element.siblings('.plus_minus_quantity');
        var currentVal = parseInt(quantityInput.val()) || 0;
        if (!isNaN(currentVal) && (increment || currentVal > 1)) {
            quantityInput.val(increment ? currentVal + 1 : currentVal - 1);
            updateItemPrice(element);
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

    $(document).on('change','.check_atc_item',function(){
        var check = $(this).prop('checked');
        var subtotal_price = $('.subtotal_price');
        var formatted_subtotal_price = parseFloat(subtotal_price.html());
        var check_item_price = parseFloat($(this).closest('.add_to_cart_item').find('.item_count_price').html());
        var total_check_item = $('.total_check_item');
        var summation = 0;
        if (check == true) {
            summation = (formatted_subtotal_price+check_item_price);
            total_check_item.html(parseInt(total_check_item.html())+1);
        }else{
            summation = (formatted_subtotal_price-check_item_price);
            total_check_item.html(parseInt(total_check_item.html())-1);
        }
        subtotal_price.html(numberFormat(summation,2));
    });

</script>
