<div class="product_price mt-3">
    @php
        $showUpload = $single_product->precaution
            || ($single_product->price <= 0)
            || ($single_product->price > 0 && empty($single_product->units));

        $formattedPrice = $single_product->price > 0 ? number_format($single_product->price, 2) : 'TBA';
        $hasDiscount = $single_product->discount_amount > 0;
    @endphp
    @if ($formattedPrice)
        {{-- Price Display --}}
        <p aria-live="polite">
            @if($hasDiscount)
                <del class="text-danger">
                    {{ __('MRP Tk') }}
                    <span class="total_regular_price" data-price-container>
                        {{ __($formattedPrice) }}
                    </span>
                </del>
                <span class="badge bg-danger">
                    {{ $single_product->discount_percentage }}% {{ __('off') }}
                </span>
            @else
                <strong>
                    {{ __('Price: Tk') }}
                    <span class="total_price" data-price-container>
                        {{ __($formattedPrice) }}
                    </span>
                </strong>
                /
                <span class="unit_name" data-unit-container>
                    {{ __('piece') }}
                </span>
            @endif
        </p>
    @endif

    @if($single_product->unitS)
        {{-- Unit Selection --}}
        <div class="d-block d-md-flex align-items-center justify-content-between">
            <div class="form-group my-4 boxed">
                @foreach ($single_product->units as $unit)
                    <input type="radio"
                           value="{{ $unit->id }}"
                           name="unit_id"
                           data-id="{{ $unit->id }}"
                           data-name="{{ $unit->name }}"
                           data-total_price="{{ $unit->pivot->price }}"
                           data-total_regular_price="{{ $unit->pivot->price }}"
                           class="item_quantity"
                           id="unit-{{ $loop->index }}"
                           @checked($loop->first)>
                    <label for="unit-{{ $loop->index }}">
                        <img src="{{ $unit->image }}"
                             title="{{ $unit->name }}"
                             alt="{{ $unit->name }}">
                    </label>
                @endforeach
            </div>

            {{-- Quantity Selector --}}
            <div class="sp_quantity w-25 mb-4 mb-md-0">
                <div class="form-group">
                    <div class="input-group align-items-center" role="group">
                        <a type="button"
                                class="btn btn-sm minus_qty disabled d-flex align-items-center justify-content-center"
                                aria-label="{{ __('Decrease quantity') }}">
                            <i class="fa-solid fa-minus"></i>
                        </a>
                        <input type="text" style="line-height: 1.5"
                               class="form-control text-center quantity_input "
                               name="quantity"
                               value="1"
                               aria-label="{{ __('Quantity') }}">
                        <a type="button"
                                class="btn btn-sm plus_qty d-flex align-items-center justify-content-center"
                                aria-label="{{ __('Increase quantity') }}">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}

    @endif


    @if($showUpload)
        @include('frontend.product.includes.upload_prescription')
    @else
    <div class="add_to_card">
        <button class="cart-btn d-flex align-items-center justify-content-center"
                type="button"
                data-product_slug="{{ $single_product->slug }}"
                data-quantity="1"
                data-unit_id="{{ $single_product->units->first()->id }}">
            <i class="fa-solid fa-cart-plus me-2"></i>
            {{ __('Add to Cart') }}
        </button>
    </div>

    <div class="order_button mt-4">
        <button class="order-btn" type="submit">{{ __('Order Now') }}</button>
    </div>
    @endif

</div>
