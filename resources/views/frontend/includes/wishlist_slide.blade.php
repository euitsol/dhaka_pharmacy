<div class="offcanvas offcanvas-end" tabindex="-1" id="wishlist" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('Wish List') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body wishes slide_wishes" id='wish_wrap'>
        @forelse ($wishes as $wish)
        <div class="card wish_item mb-2">
            <div class="card-body py-3">
                {{-- Product Details --}}
                <div class="row align-items-md-center align-items-start product_details mb-0 mb-md-2">
                    <div class="image col-4 col-md-2">
                        <a href="{{ route('product.single_product', $wish->product->slug) }}">
                            <img class="border border-1 rounded-1" src="{{ $wish->product->image }}"
                                alt="{{ $wish->product->name }}">
                        </a>
                    </div>


                    <div class="col-8 col-md-10 info">
                        <div class="row justify-content-between">
                            <div class="col-12 col-md-6 info px-0 px-md-3">
                                <h4 class="product_title" title="{{ $wish->product->attr_title }}"> <a
                                        href="{{ route('product.single_product', $wish->product->slug) }}">{{
                                        $wish->product->name }}</a>
                                </h4>
                                <p class="m-0"><a href="" title="{{ optional($wish->product->pro_sub_cat)->name }}">{{
                                        optional($wish->product->pro_sub_cat)->name }}</a></p>
                                <p class="m-0"><a href="" title="{{ optional($wish->product->generic)->name }}">{{
                                        optional($wish->product->generic)->name }}</a></p>
                                <p class="m-0"><a href="" title="{{ optional($wish->product->company)->name }}">{{
                                        optional($wish->product->company)->name }}</a></p>
                            </div>
                            <div class="col-12 col-md-6 ps-0 ps-md-0">
                                <div class="details">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <div class="item_price_wrap">
                                                @if ($wish->product->discounted_price != $wish->product->price)
                                                <h4 class="text-start item_regular_price price"> <del
                                                        class="text-danger">{!! get_taka_icon() !!}{{
                                                        number_format($wish->product->price, 2) }}</del>
                                                </h4>
                                                @endif
                                                <h4 class="text-start item_price price"> <span>
                                                        {!! get_taka_icon() !!}{{
                                                        number_format($wish->product->discounted_price, 2) }}</span>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col-4 text-right ps-0 wishlist_item">
                                            <i class="fa-solid fa-trash-can text-danger wish_remove_btn wish_update"
                                                data-pid="{{ encrypt($wish->product->id) }}"></i>
                                        </div>
                                        <div class="col-6 pe-1 mt-2">
                                            <a href="{{ route('product.single_product', $wish->product->slug) }}"
                                                class="details_btn">{{ __('Details') }}</a>
                                        </div>
                                        <div class="col-6 ps-1 mt-2">
                                            <div class="add_to_card">
                                                <a class="cart-btn order_btn" href="javascript:void(0)"
                                                    data-product_slug="{{ $wish->product->slug }}" data-unit_id="">
                                                    {{ __('Add To Cart') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        @empty
        <h5 class="text-center wish_empty_alert">{{ __('Wished Item Not Found') }}</h5>
        @endforelse
    </div>

</div>
