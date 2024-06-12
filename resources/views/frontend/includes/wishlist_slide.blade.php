<div class="offcanvas offcanvas-end" tabindex="-1" id="wishlist" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ __('Wish List') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body wishes slide_wishes" id='wish_wrap'>
        @forelse ($wishes as $wish)
            <div class="card wish_item mb-2">
                <div class="card-body py-2">
                    {{-- Product Details  --}}
                    <div class="row align-items-center product_details mb-2">
                        <div class="image col-2">
                            <a href="{{ route('product.single_product', $wish->product->slug) }}">
                                <img class="border border-1 rounded-1" src="{{ $wish->product->image }}"
                                    alt="{{ $wish->product->name }}">
                            </a>
                        </div>
                        <div class="col-6 info">
                            <h4 class="product_title" title="{{ $wish->product->attr_title }}"> <a
                                    href="{{ route('product.single_product', $wish->product->slug) }}">{{ $wish->product->name }}</a>
                            </h4>
                            <p><a href="">{{ $wish->product->pro_sub_cat->name }}</a></p>
                            <p><a href="">{{ $wish->product->generic->name }}</a></p>
                            <p><a href="">{{ $wish->product->company->name }}</a></p>
                        </div>
                        <div class="col-4 ps-0">
                            <div class="details">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <div class="item_price_wrap">
                                            @if ($wish->product->discountPrice != $wish->product->price)
                                                <h4 class="text-start item_regular_price price"> <del
                                                        class="text-danger">{!! get_taka_icon() !!}{{ number_format($wish->product->price, 2) }}</del>
                                                </h4>
                                            @endif
                                            <h4 class="text-start item_price price"> <span>
                                                    {!! get_taka_icon() !!}{{ number_format($wish->product->discountPrice, 2) }}</span>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-4 text-center ps-0 wishlist_item">
                                        <i class="fa-solid fa-trash-can text-danger wish_remove_btn wish_update"
                                            data-pid="{{ encrypt($wish->product->id) }}"></i>
                                    </div>
                                    <div class="col-6 pe-1 mt-2">
                                        <a href="{{ route('product.single_product', $wish->product->slug) }}"
                                            class="details_btn">{{ __('Details') }}</a>
                                    </div>
                                    <div class="col-6 ps-1 mt-2">
                                        <form action="{{ route('u.ck.product.single_order') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="slug" value="{{ $wish->product->slug }}">
                                            <input type="hidden" name="unit_id"
                                                value="{{ $wish->product->units[0]->id }}">
                                            <input type="submit" class="order_btn" value="Order Now">
                                        </form>
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
