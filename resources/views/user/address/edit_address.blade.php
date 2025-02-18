<div class="modal fade address-modal address-edit-modal" id="address_edit_modal" tabindex="-1" role="dialog"
    aria-labelledby="address_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="address_modalLabel">Update Address</h5>
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-md-12">
                        <div class="map" id="user_e_map"></div>
                    </div> --}}
                    <div class="col-md-12 m-2">
                        <form action="{{ route('u.as.update') }}" method="POST">
                            @method('put')
                            @csrf
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="lat" value="">
                            <input type="hidden" name="long" value="">
                            <div class="row">
                                <div class="form-group col-md-12 p-2">
                                    <label for="address">Full Address <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="address" name="address"
                                        placeholder="Enter your full address">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="city" class="mb-1">{{ __('City') }} <small
                                            class="text-danger">*</small></label>
                                    <select name="city" id="city_select_edit" class="form-control city_select">

                                    </select>
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="street">Street Name <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="street" name="street"
                                        placeholder="Enter your street name" value="">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="apartment">Apartment Name <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="apartment" name="apartment"
                                        placeholder="Enter your apartment name" value="">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="floor">Floor <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="floor" name="floor"
                                        placeholder="Enter your apartment floor" value="">
                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <label for="instruction">Delivery Details <small>(optional)</small></label>
                                    <textarea type="text" class="form-control mt-1" id="instruction" name="instruction">Receiver name: &#10;Receiver phone number:</textarea>
                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_default" value="1"
                                            id="is_default">
                                        <label class="form-check-label" for="is_default">
                                            Set as default
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <button type="submit" class="btn btn-sm btn-success w-100">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
