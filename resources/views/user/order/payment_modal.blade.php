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

                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3 title">{{ __('Delivery Address') }}</h4>
                            <div class="form-group">
                                <label for="address">{{ __('Select a delivery address') }}</label>
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
                    </div>

                    <div class="delivery-section mb-3">
                        <h5 class="mb-2">{{ __('Delivery Type') }}</h5>
                        <div id="delivery_type_container">
                            <div class="form-group">
                                <label for="delivery_type">{{ __('Delivery Type') }}</label>
                                <select class="form-control" id="delivery_type" name="delivery_type" required>
                                    <option value="">{{ __('Please select an address first') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5 class="mb-2">{{ __('Payment Method') }}</h5>
                        <div class="form-group">
                            <label for="payment_method">{{ __('Select payment method') }}</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="">{{ __('Select payment method') }}</option>
                                <option value="ssl" selected>{{ __('SSL Commerz') }}</option>
                                <option value="cod">{{ __('Cash on Delivery') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="order-summary mb-3">
                        <h4 class="mb-3 title">{{ __('Order Summary') }}</h4>
                        <div id="order-summary-content">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Proceed to Payment') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
