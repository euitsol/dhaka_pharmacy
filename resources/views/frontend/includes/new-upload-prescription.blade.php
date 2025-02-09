
<div class="modal fade prescriptionModal" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="prescriptionModalLabel">{{ __('Upload Prescription') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="prescriptionForm" id="prescriptionForm" action="{{ route('u.obp.create') }}" method="POST">
                    @csrf
                    <!-- File Upload Area -->
                    <div class="mb-4">
                        <input type="file" id="prescription" accept="image/*" class="d-none" multiple>
                        <label for="prescription" class="upload-area d-flex flex-column align-items-center justify-content-center">
                            <div class="upload-icon position-relative">
                                <i class="fas fa-camera fa-3x"></i>
                            </div>

                            <p class="mt-3 mb-1">{{ __('Drag & drop your prescription or') }}</p>
                            <p class="small">{{ __('Click to capture or upload') }}</p>
                        </label>
                    </div>

                    <div class="image-preview">

                    </div>

                    <!-- Contact Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Contact Number') }} <span class="text-danger">*</span> <small class="text-muted">{{ __('Required') }}</small></label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" value="{{ user() ? user()->phone : old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label for="information" class="form-label">{{ __('Additional Information') }}</label>
                        <textarea class="form-control" name="information" id="information" rows="3" placeholder="Enter any special instructions"></textarea>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-light p-3 rounded mb-4">
                        <p class="text-muted small mb-0">
                            {{ __('Our pharmacy team will review your prescription and call you shortly to confirm your order.
                            Please ensure your contact number is correct.') }}
                        </p>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">{{ __('Submit Prescription') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <link rel="stylesheet" href="{{ asset('user/asset/css/upload-presription.css') }}"> --}}
