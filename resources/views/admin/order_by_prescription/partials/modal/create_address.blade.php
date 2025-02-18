<div class="modal fade address-modal" id="address_add_modal" style="z-index: 999999;" tabindex="-1" role="dialog"
    aria-labelledby="address_add_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="address_add_modalLabel">{{ __('Add New Address') }}</h5>

                <button type="button" class="close btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" id="delivery-form" action="{{ route('obp.delivery.create.obp_details') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ encrypt($user->id) }}" class="d-none">
                            <div class="row">
                                <div class="form-group col-md-6 p-2 error-div btn-danger w-100 border-rounded" style="display: none;">

                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <label for="address">{{ __('Full Address') }} <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="address" name="address"
                                        placeholder="Enter your full address" required>
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="city">{{ __('City') }} <small
                                            class="text-danger">*</small></label>
                                    <select name="city" id="city_select" class="form-control no-select" required>
                                        <option value="">{{ __('Select City') }}</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->city_name }}">{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="street">{{ __('Street Name') }} <small
                                            class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="street" name="street"
                                        placeholder="Enter your street name" required>
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="apartment">{{ __('Apartment Name') }}</label>
                                    <input type="text" class="form-control mt-1" id="apartment" name="apartment"
                                        placeholder="Enter your apartment name">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="floor">{{ __('Floor') }}</label>
                                    <input type="text" class="form-control mt-1" id="floor" name="floor"
                                        placeholder="Enter your apartment floor">
                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <label for="instruction">{{ __('Delivery Details') }}
                                        <small>{{ __('(optional)') }}</small></label>
                                    <textarea type="text" class="form-control mt-1" id="instruction" name="instruction"></textarea>
                                </div>


                                <div class="form-group col-md-12 p-2">
                                    <button type="submit"
                                        class="btn btn-sm btn-success w-100 p-2">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
