<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">{{ __('Complete Your Payment') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="{{ route('u.order.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id" value="">

                    <div class="section-container">
                        <h6 class="section-title">{{ __('Delivery Address') }}</h6>
                        <div class="address-box">
                            <select class="form-control" id="address" name="address" required>
                                <option value="">{{ __('Select a delivery address') }}</option>
                                @forelse (auth()->user()->address as $address)
                                    <option value="{{ $address->id }}" @if ($address->is_default == true) selected @endif>
                                        {{ str_limit($address->address, 45) }}
                                    </option>
                                @empty
                                    <option value="">{{ __('No address found. Please add a new address.') }}</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="section-container">
                        <h6 class="section-title">{{  __('Delivery Type') }}</h6>
                        <select class="form-select disabled" id="delivery_type" name="delivery_type" required>
                            <option selected>{{ __('Please select an address first') }}</option>
                        </select>
                    </div>

                    <div class="section-container">
                        <h6 class="section-title">{{ __('Payment Method') }}</h6>
                        <select class="form-select" name="payment_method" id="payment_method">
                            <option value="ssl" selected>{{ __('SSL Commerz') }}</option>
                            <option value="cod">{{ __('Cash on Delivery') }}</option>
                        </select>
                    </div>

                    <div class="section-container mb-0">
                        <h4 class="section-title">{{ __('Order Summary') }}</h4>
                        <div id="order-summary-content summary-list">
                            <div class="summary-item">
                                <span class="summary-label">{{ __('Sub Total') }}</span>
                                <span class="summary-value">{!! get_taka_icon() !!} <span class="sub-total"></span> <span class="operator">(+)</span></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">{{ __('Product Discount') }}</span>
                                <span class="summary-value">{!! get_taka_icon() !!} <span class="product-discount"></span> <span class="operator">(-)</span></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">{{ __('Voucher Discount') }}</span>
                                <span class="summary-value">{!! get_taka_icon() !!} <span class="voucher-discount"></span> <span class="operator">(-)</span></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">{{ __('Delivery Charge') }}</span>
                                <span class="summary-value">{!! get_taka_icon() !!} <span class="delivery-charge"></span> <span class="operator">(+)</span></span>
                            </div>

                            <div class="summary-item">
                                <span class="summary-label">{{ __('Total Payable') }}</span>
                                <span class="summary-value">{!! get_taka_icon() !!} <span class="total-payable"></span> <span class="operator">(+)</span></span>
                            </div>

                        </div>
                    </div>

                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Proceed to Payment') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
