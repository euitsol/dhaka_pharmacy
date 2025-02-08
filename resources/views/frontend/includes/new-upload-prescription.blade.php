
<div class="modal fade prescriptionModal" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="prescriptionModalLabel">Upload Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- File Upload Area -->
                    <div class="mb-4">
                        <input type="file" id="prescription" accept="image/*" capture="environment" class="d-none">
                        <label for="prescription" class="upload-area d-flex flex-column align-items-center justify-content-center">
                            <div class="upload-icon position-relative">
                                <i class="fas fa-camera fa-3x"></i>
                            </div>
                            <p class="mt-3 mb-1">Drag & drop your prescription or</p>
                            <p class="text-muted small">Click to capture or upload</p>
                        </label>
                    </div>

                    <!-- Contact Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                    </div>

                    <!-- Delivery Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Delivery Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter your delivery address">
                    </div>

                    <!-- Shipping Method -->
                    <div class="mb-3">
                        <label for="shipping" class="form-label">Shipping Method</label>
                        <select class="form-select" id="shipping">
                            <option selected disabled>Select delivery type</option>
                            <option value="standard">Standard Delivery</option>
                            <option value="express">Express Delivery</option>
                        </select>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-light p-3 rounded mb-4">
                        <p class="text-muted small mb-0">
                            Our pharmacy team will review your prescription and call you shortly to confirm your order.
                            Please ensure your contact number is correct.
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit Prescription</button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('user/asset/css/upload-presription.css') }}">
