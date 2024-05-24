<div class="modal fade address-modal" id="address_modal" tabindex="-1" role="dialog" aria-labelledby="address_modal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="address_modalLabel">Add New Address</h5>
                <button type="button" class="close btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="map" id="user_a_map"></div>
                    </div>
                    <div class="col-md-12 m-2">
                        <form action="{{ route('u.as.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lat">
                            <input type="hidden" name="long">
                            <div class="row">
                                <div class="form-group col-md-12 p-2">
                                    <label for="address">Full Address <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="address" name="address"
                                        placeholder="Enter your full address">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="city">City <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="city" name="city"
                                        placeholder="Enter your city name">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="street">Street Name <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="street" name="street"
                                        placeholder="Enter your street name">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="apartment">Apartment Name <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="apartment" name="apartment"
                                        placeholder="Enter your apartment name">
                                </div>
                                <div class="form-group col-md-6 p-2">
                                    <label for="floor">Floor <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control mt-1" id="floor" name="floor"
                                        placeholder="Enter your apartment floor">
                                </div>
                                <div class="form-group col-md-12 p-2">
                                    <label for="instruction">Delivery Details <small>(optional)</small></label>
                                    <textarea type="text" class="form-control mt-1" id="instruction" name="instruction">Receiver name: &#10;Receiver phone number:</textarea>
                                </div>


                                <div class="form-group col-md-12 p-2">
                                    <button type="submit" class="btn btn-sm btn-success w-100">Save</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
