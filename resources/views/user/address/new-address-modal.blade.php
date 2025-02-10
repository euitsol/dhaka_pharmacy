<div class="modal fade addressModal" id="address_add_modal" style="z-index: 999999;" tabindex="-1" aria-labelledby="address_add_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="address_add_modalLabel">Add New Address</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <form action="{{ route('u.as.store') }}" method="POST" id="addressForm">
            @csrf
            <input type="hidden" name="lat">
            <input type="hidden" name="long">

            <!-- Map Container -->
            <div class="position-relative">
              <div class="map-container" id="user_a_map">
                {{-- You can add a search box here if needed --}}
              </div>
            </div>

            <!-- Address Form -->
            <div class="row g-3 mt-3">
              <!-- Full Address -->
              <div class="col-md-12">
                <label for="address" class="form-label">Full Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your full address" required>
              </div>

              <!-- City -->
              <div class="col-md-6">
                <label for="city_select" class="form-label">City</label>
                <select class="form-select select2" id="city_select" name="city" required>
                  <option value="">Select City</option>
                  <option value="1">New York</option>
                  <option value="2">Los Angeles</option>
                  <option value="3">Chicago</option>
                </select>
              </div>

              <!-- Street Name -->
              <div class="col-md-6">
                <label for="street" class="form-label">Street Name</label>
                <input type="text" class="form-control" id="street" name="street" placeholder="Enter your street name" required>
              </div>

              <!-- Apartment Name -->
              <div class="col-md-6">
                <label for="apartment" class="form-label">Apartment Name</label>
                <input type="text" class="form-control" id="apartment" name="apartment" placeholder="Enter your apartment name" required>
              </div>

              <!-- Floor -->
              <div class="col-md-6">
                <label for="floor" class="form-label">Floor</label>
                <input type="text" class="form-control" id="floor" name="floor" placeholder="Enter your apartment floor" required>
              </div>

              <!-- Delivery Details -->
              <div class="col-md-12">
                <label for="instruction" class="form-label">
                  Delivery Details <small>(optional)</small>
                </label>
                <textarea class="form-control" id="instruction" name="instruction" rows="3">Receiver name:
  Receiver phone number:</textarea>
              </div>

              <!-- Save Button -->
              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-success btn-save w-100">Save Address</button>
              </div>
            </div>
          </form>
        </div><!-- End Modal Body -->
      </div>
    </div>
  </div>
