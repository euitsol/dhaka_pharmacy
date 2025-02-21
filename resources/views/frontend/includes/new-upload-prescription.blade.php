<div class="modal fade prescriptionModal" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title w-100 text-center" id="prescriptionModalLabel">{{ __('Upload Prescription') }}</h5>
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="prescriptionForm" id="prescriptionForm" action="{{ route('u.obp.create') }}"
                    method="POST">
                    @csrf
                    <!-- File Upload Area -->
                    <div class="mb-4">
                        <input type="file" id="fileInput" accept="image/*" class="d-none" multiple>
                        <input type="file" id="cameraInput" accept="image/*" capture="environment" class="d-none">

                        <div class="upload-area d-flex flex-column align-items-center justify-content-center">
                            <button type="button" id="openCamera" class="btn btn-outline-primary mb-2">
                                <i class="fas fa-camera"></i> {{ __('Capture from Camera') }}
                            </button>
                            <button type="button" id="uploadFile" class="btn btn-outline-secondary">
                                <i class="fas fa-upload"></i> {{ __('Upload from Device') }}
                            </button>
                        </div>
                    </div>

                    <div class="image-preview" style="display: none">

                    </div>

                    <!-- Contact Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('Contact Number') }} <span
                                class="text-danger">*</span> <small
                                class="text-muted">{{ __('Required') }}</small></label>
                        <input type="tel" class="form-control" name="phone" id="phone"
                            placeholder="Enter your phone number" value="{{ user() ? user()->phone : old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label for="information" class="form-label">{{ __('Additional Information') }}</label>
                        <textarea class="form-control" name="information" id="information" rows="3"
                            placeholder="Enter any special instructions"></textarea>
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
