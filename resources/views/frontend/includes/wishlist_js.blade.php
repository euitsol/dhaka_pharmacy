<script>
    $(document).ready(function() {
        $(document).on("click", ".wish_update", function() {
            let login_url = `{{ route('login') }}`;
            let _url = `{{ route('u.wishlist.update', 'param') }}`;
            let pid = $(this).data("pid");
            _url = _url.replace("param", pid);
            let element = $(this);
            $.ajax({
                url: _url,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        element.removeClass("fa-regular").addClass("fa-solid");
                    } else {
                        toastr.warning(response.message);
                        element.removeClass("fa-solid").addClass("fa-regular");
                    }
                    setTimeout(function() {
                        if (element.parent().hasClass("wishlist_item")) {
                            element.closest(".wish_item")
                                .remove(); // More efficient parent traversal
                        }
                    }, 500);
                    refreshWishlist();
                    if ($(".wish_item").length < 2) {
                        $("#wish_wrap").html(
                            `<h5 class="text-center wish_empty_alert">{{ __('Wish Item Not Found') }}</h5>`
                        );
                    }
                },
                error: function(xhr, status, error) {
                    window.location.href = login_url;
                    console.error("Error fetching search data:", error);
                },
            });
        });
    });


    function refreshWishlist() {
        let refresh = `{{ route('u.wishlist.refresh') }}`;
        $.ajax({
            url: refresh,
            method: "GET",
            dataType: "json",
            success: function(data) {
                let result = '';
                if (data.wishes.length > 0) {
                    data.wishes.forEach(function(wish) {
                        let product = wish.product;
                        let product_details = `{{ route('product.single_product', 'param') }}`;
                        product_details = product_details.replace('param', product.slug);
                        result += `<div class="card wish_item mb-2">
                                            <div class="card-body py-2">
                                                <div class="row align-items-center product_details mb-2">
                                                    <div class="image col-2">
                                                        <a href="${product_details}">
                                                            <img class="border border-1 rounded-1" src="${product.image}"
                                                                alt="${product.name}">
                                                        </a>
                                                    </div>
                                                    <div class="col-6 info">
                                                        <h4 class="product_title" title="${product.attr_title}"> <a
                                                                href="${product_details}">${product.name}</a>
                                                        </h4>
                                                        <p><a href="">${product.pro_sub_cat.name}</a></p>
                                                        <p><a href="">${product.generic.name}</a></p>
                                                        <p><a href="">${product.company.name}</a></p>
                                                    </div>
                                                    <div class="col-4 ps-0">
                                                        <div class="details">
                                                            <div class="row align-items-center">
                                                                <div class="col-8">
                                                                    <div class="item_price_wrap">`;
                        if (product.discountPrice != product.price) {
                            result += `
                                                        <h4 class="text-start item_regular_price price"> <del
                                                                class="text-danger">{!! get_taka_icon() !!}${ numberFormat(product.price, 2)}</del>
                                                        </h4>
                                                        `;
                        };
                        result += `
                                                        <h4 class="text-start item_price price"> <span>
                                                                {!! get_taka_icon() !!}${numberFormat(product.discountPrice, 2)}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-center ps-0 wishlist_item">
                                                    <i class="fa-solid fa-trash-can text-danger wish_remove_btn wish_update"
                                                        data-pid="${product.pid}"></i>
                                                </div>
                                                <div class="col-6 pe-1 mt-2">
                                                    <a href="${product_details}"
                                                        class="details_btn">Details</a>
                                                </div>
                                                <div class="col-6 ps-1 mt-2">
                                                    <form action="{{ route('u.ck.product.single_order') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="slug" value="${product.slug}">
                                                        <input type="hidden" name="unit_id"
                                                            value="${product.units[0].id}">
                                                        <input type="submit" class="order_btn" value="Order Now">
                                                    </form>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>`;

                    });
                } else {
                    result =
                        `<h5 class="text-center wish_empty_alert">{{ __('Wish Item Not Found') }}</h5>`;
                }

                $('.slide_wishes').html(result);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching search data:", error);
            },
        });
    }
</script>
