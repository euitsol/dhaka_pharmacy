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
                <form class="prescriptionForm" id="prescriptionForm" action="{{ route('u.obp.create') }}" method="POST">
                    @csrf
                    <!-- Multi-step form container -->
                    <div class="prescription-steps">
                        <!-- Step 1: Upload Prescription -->
                        <div class="step step-1 active">
                            <div class="step-header mb-3">
                                <div class="step-indicator">
                                    <span class="step-number">1</span>
                                    <span class="step-title">{{ __('Upload Images') }}</span>
                                </div>
                            </div>

                            <!-- File Upload Area -->
                            <div class="mb-4">
                                <input type="file" id="fileInput" accept="image/*" class="d-none" multiple>
                                <input type="file" id="cameraInput" accept="image/*" capture="environment" class="d-none">

                                <div class="upload-area d-flex flex-column align-items-center justify-content-center">
                                    <div class="upload-icon mb-3">
                                        <i class="fas fa-file-medical fa-3x"></i>
                                        {{-- <img src="{{ asset('frontend/asset/icons/nav/upload-prescription.svg') }}" alt=""> --}}
                                    </div>
                                    <p class="upload-text mb-3">{{ __('Upload your prescription') }}</p>
                                    <div class="d-flex gap-2">
                                        <button type="button" id="openCamera" class="btn btn-outline-primary">
                                            <i class="fas fa-camera"></i> {{ __('Camera') }}
                                        </button>
                                        <button type="button" id="uploadFile" class="btn btn-outline-secondary">
                                            <i class="fas fa-upload"></i> {{ __('Device') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="image-preview" style="display: none"></div>

                            <button type="button" class="btn btn-primary w-100 next-step" data-step="1" disabled>
                                {{ __('Continue') }} <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>

                        <!-- Step 2: Contact Information -->
                        <div class="step step-2">
                            <div class="step-header mb-3">
                                <div class="step-indicator">
                                    <span class="step-number">2</span>
                                    <span class="step-title">{{ __('Contact Details') }}</span>
                                </div>
                            </div>

                            <!-- Contact Number -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Contact Number') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+880</span>
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                        placeholder="1XXXXXXXXX" value="{{ user() ? ltrim(user()->phone, '0') : old('phone') }}">
                                </div>
                                <div class="form-text">{{ __('We\'ll send an OTP to this number') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="information" class="form-label">{{ __('Additional Information') }}</label>
                                <textarea class="form-control" name="information" id="information" rows="2"
                                    placeholder="Enter any special instructions"></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary prev-step flex-grow-1" data-step="2">
                                    <i class="fas fa-arrow-left me-1"></i> {{ __('Back') }}
                                </button>
                                <button type="button" class="btn btn-primary request-otp flex-grow-1" data-step="2">
                                    {{ __('Request OTP') }} <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: OTP Verification -->
                        <div class="step step-3">
                            <div class="step-header mb-3">
                                <div class="step-indicator">
                                    <span class="step-number">3</span>
                                    <span class="step-title">{{ __('Verify OTP') }}</span>
                                </div>
                            </div>

                            <div class="mb-4 text-center">
                                <p>{{ __('Enter the verification code sent to') }} <strong class="phone-display"></strong></p>

                                <div class="otp-input-container d-flex justify-content-center gap-2 my-4">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="1">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="2">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="3">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="4">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="5">
                                    <input type="text" class="form-control otp-input" maxlength="1" data-index="6">
                                </div>

                                <div class="resend-container">
                                    <span class="timer-text">{{ __('Resend code in') }} <span class="countdown">60</span>s</span>
                                    <button type="button" class="btn btn-link resend-otp p-0 d-none">
                                        {{ __('Resend OTP') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="bg-light p-3 rounded mb-4">
                                <p class="text-muted small mb-0">
                                    {{ __('Our pharmacy team will review your prescription and call you shortly to confirm your order.') }}
                                </p>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-secondary prev-step flex-grow-1" data-step="3">
                                    <i class="fas fa-arrow-left me-1"></i> {{ __('Back') }}
                                </button>
                                <button type="submit" class="btn btn-primary w-100 flex-grow-1" id="submitPrescription">
                                    {{ __('Submit Prescription') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <link rel="stylesheet" href="{{ asset('user/asset/css/upload-presription.css') }}"> --}}
