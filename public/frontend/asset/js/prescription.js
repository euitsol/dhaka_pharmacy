$(document).ready(function() {
    const $previewContainer = $('.image-preview');
    const $uploadArea = $('.upload-area');
    const maxLimit = 10;
    const $cameraInput = $('#cameraInput');
    const $openCamera = $('#openCamera');
    const $uploadFile = $('#uploadFile');
    const $fileInput = $('#fileInput');
    const $nextStepBtn = $('.next-step');
    const $prevStepBtn = $('.prev-step');
    const $requestOtpBtn = $('.request-otp');
    const $resendOtpBtn = $('.resend-otp');
    const $otpInputs = $('.otp-input');
    const $submitBtn = $('#submitPrescription');
    const $phoneInput = $('#phone');
    const $phoneDisplay = $('.phone-display');
    let countdownInterval;

    // File input change event
    $fileInput.on('change', handleFiles);
    $cameraInput.on('change', handleFiles);

    // Drag and drop events
    $uploadArea.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('drag-over');
    });

    $uploadArea.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('drag-over');
    });

    $uploadArea.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('drag-over');
        handleFiles(e.originalEvent);
    });

    $openCamera.on('click', function() {
        $cameraInput.trigger('click');
    });

    // When the user clicks the upload button, open the file upload input
    $uploadFile.on('click', function() {
        $fileInput.trigger('click');
    });

    // Step navigation
    $nextStepBtn.on('click', function() {
        const currentStep = parseInt($(this).data('step'));
        goToStep(currentStep + 1);
    });

    $prevStepBtn.on('click', function() {
        const currentStep = parseInt($(this).data('step'));
        goToStep(currentStep - 1);
    });

    // $phoneInput.on('input', function() {
    //     let phone = $(this).val().trim();

    //     if(phone[0] == '0'){
    //         phone = phone.slice(1);
    //     }

    //     $phoneInput.val(phone);
    // });
    // Request OTP
    $requestOtpBtn.on('click', function() {
        var phone = $phoneInput.val().trim();

        if (!phone) {
            toastr.error('Please enter a valid phone number');
            return;
        }

        if (phone.length != 11) {
            toastr.error('Phone number should be 11 digit');
            return;
        }

        // Display the phone number in the OTP step
        $phoneDisplay.text(phone);

        console.log(phone);

        // Send OTP API request
        $.ajax({
            url: window.AppConfig.urls.prescription.send_otp || '/order-by-prescrition/prescription/send-otp',
            type: 'POST',
            data: {
                phone: phone,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $requestOtpBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('OTP sent to your phone number');
                    goToStep(3);
                    startCountdown();
                } else {
                    toastr.error(response.message || 'Failed to send OTP');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                toastr.error(response?.message || 'Failed to send OTP. Please try again.');
            },
            complete: function() {
                $requestOtpBtn.prop('disabled', false).html('Request OTP <i class="fas fa-arrow-right ms-1"></i>');
            }
        });
    });

    // OTP input handling
    $otpInputs.on('input', function(e) {
        const index = parseInt($(this).data('index'));
        const value = $(this).val();

        if (value.length === 1 && index < 6) {
            $otpInputs.eq(index).focus();
        }

        validateOtp();
    });

    $otpInputs.on('keydown', function(e) {
        const index = parseInt($(this).data('index'));

        if (e.key === 'Backspace' && !$(this).val() && index > 1) {
            e.preventDefault();
            $otpInputs.eq(index - 2).focus().val('');
        }
    });

    $otpInputs.eq(0).on("paste", function (event) {
        event.preventDefault();

        const pastedValue = (
            event.originalEvent.clipboardData || window.clipboardData
        ).getData("text");
        const otpLength = inputs.length;

        for (let i = 0; i < otpLength; i++) {
            if (i < pastedValue.length) {
                inputs.eq(i).val(pastedValue[i]);
                inputs.eq(i).removeAttr("disabled");
                inputs.eq(i).focus();
            } else {
                inputs.eq(i).val(""); // Clear any remaining inputs
                inputs.eq(i).focus();
            }
        }
    })

    // Resend OTP
    $resendOtpBtn.on('click', function() {
        const phone = $phoneInput.val().trim();

        if (!phone) {
            toastr.error('Please enter a valid phone number');
            return;
        }

        $.ajax({
            url: window.AppConfig.urls.prescription.resend_otp || '/order-by-prescrition/prescription/resend-otp',
            type: 'POST',
            data: {
                phone: phone,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $resendOtpBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Resending...');
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('OTP resent to your phone number');
                    startCountdown();
                    $resendOtpBtn.addClass('d-none');
                } else {
                    toastr.error(response.message || 'Failed to resend OTP');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                toastr.error(response?.message || 'Failed to resend OTP. Please try again.');
            },
            complete: function() {
                $resendOtpBtn.prop('disabled', false).html('Resend OTP');
            }
        });
    });

    // Form submission
    $('#prescriptionForm').on('submit', function(e) {
        e.preventDefault();

        const phone = $phoneInput.val().trim();
        let otp = '';

        // Collect OTP from inputs
        $otpInputs.each(function() {
            otp += $(this).val();
        });

        if (otp.length !== 6) {
            toastr.error('Please enter the complete 6-digit OTP');
            return;
        }

        // First verify OTP
        $.ajax({
            url: window.AppConfig.urls.prescription.verify_otp || '/order-by-prescrition/prescription/verify-otp',
            type: 'POST',
            data: {
                phone: phone,
                otp: otp,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Verifying...');
            },
            success: function(response) {
                if (response.success) {
                    // OTP verified, now submit the form
                    submitPrescriptionForm();
                } else {
                    toastr.error(response.message || 'Invalid OTP');
                    $submitBtn.prop('disabled', false).html('Submit Prescription');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                toastr.error(response?.message || 'OTP verification failed. Please try again.');
                $submitBtn.prop('disabled', false).html('Submit Prescription');
            }
        });
    });

    function submitPrescriptionForm() {
        const formData = new FormData($('#prescriptionForm')[0]);

        $.ajax({
            url: $('#prescriptionForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
            },
            success: function(response) {
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Prescription submitted successfully',
                }).then(() => location.reload());
            },

            error: function(xhr) {
                const response = xhr.responseJSON;
                $submitBtn.prop('disabled', false).html('Submit Prescription');
                $('#prescriptionModal').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: response?.error || 'Failed to submit prescription. Please try again.',
                }).then(() => location.reload());
            }
        });
    }

    function resetForm() {
        $('#prescriptionForm')[0].reset();
        $previewContainer.empty().hide();
        $uploadArea.show();
        $nextStepBtn.prop('disabled', true);
        goToStep(1);

        // Clear OTP inputs
        $otpInputs.val('');
    }

    function checkLimit(count=0) {
        if(parseInt($('.img-id').length) + parseInt(count) > maxLimit) {
            toastr.error(`Only ${maxLimit} images are allowed.`);
            return false;
        }

        return true;
    }

    function handleFiles(e) {
        let files = e.target.files || e.dataTransfer.files;
        if(checkLimit(files.length)){
            Array.from(files).forEach(uploadFile);
        }
    }

    function uploadFile(file) {
        if (!file.type.startsWith('image/')) {
            toastr.error('Please upload only image files.');
            return;
        }

        let formData = new FormData();
        formData.append('file', file);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        // Create preview element
        let $preview = $('<div>').addClass('preview');
        let $previewWrapper = $('<div>').addClass('preview-wrapper').appendTo($preview);
        let $progressRing = createProgressRing().appendTo($previewWrapper);
        $previewContainer.append($preview);
        $previewContainer.show();

        $.ajax({
            url: window.AppConfig.urls.prescription.upload,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        let percentComplete = evt.loaded / evt.total;
                        updateProgress($progressRing, percentComplete);
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if(response.data && response.data.path) {
                    $progressRing.remove();
                    $('<img>').attr({
                        'src': response.data.path,
                        'class': 'uploded-image'
                    }).appendTo($previewWrapper);

                    $('<input>').attr({
                        'type': 'hidden',
                        'class': 'img-id d-none',
                        'name': 'uploaded_image['+response.data.id+']',
                        'value': response.data.id
                    }).appendTo($preview);

                    addRemoveButton($preview);
                    $preview.addClass('loaded');

                    toastr.success('File uploaded successfully.');
                    checkUploadedImages();
                } else {
                    $preview.remove();
                    toastr.error('There was a problem with the file upload.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Upload error:', error);
                $preview.remove();
                toastr.error('File upload failed. Please try again.');
            }
        });
    }

    function createProgressRing() {
        return $(`
            <div class="upload-progress">
                <div class="progress-ring">
                    <svg class="progress-ring__circle" width="40" height="40">
                        <circle class="progress-ring__circle-bg" cx="20" cy="20" r="16"></circle>
                        <circle class="progress-ring__circle-progress" cx="20" cy="20" r="16"></circle>
                    </svg>
                    <span class="progress-text">0%</span>
                </div>
            </div>
        `);
    }

    function updateProgress($progressRing, progress) {
        let $circle = $progressRing.find('.progress-ring__circle-progress');
        let $text = $progressRing.find('.progress-text');
        let radius = $circle.attr('r');
        let circumference = 2 * Math.PI * radius;
        let offset = circumference - progress * circumference;
        $circle.css('stroke-dashoffset', offset);
        $text.text(Math.round(progress * 100) + '%');
    }

    function addRemoveButton($preview) {
        let $removeBtn = $('<button>')
            .addClass('remove-btn')
            .html('<i class="fas fa-times"></i>')
            .appendTo($preview);

        $removeBtn.on('click', function() {
            $preview.remove();
            checkUploadedImages();
        });
    }

    // Check if any images have been uploaded
    function checkUploadedImages() {
        const hasImages = $('.img-id').length > 0;
        $nextStepBtn.prop('disabled', !hasImages);
    }

    // Go to a specific step
    function goToStep(step) {
        $('.step').removeClass('active');
        $(`.step-${step}`).addClass('active');
    }

    // Start the OTP countdown
    function startCountdown() {
        let seconds = 60;
        $('.countdown').text(seconds);
        $resendOtpBtn.addClass('d-none');
        $('.timer-text').removeClass('d-none');

        clearInterval(countdownInterval);
        countdownInterval = setInterval(function() {
            seconds--;
            $('.countdown').text(seconds);

            if (seconds <= 0) {
                clearInterval(countdownInterval);
                $resendOtpBtn.removeClass('d-none');
                $('.timer-text').addClass('d-none');
            }
        }, 1000);
    }

    // Validate OTP
    function validateOtp() {
        let isComplete = true;
        $otpInputs.each(function() {
            if (!$(this).val()) {
                isComplete = false;
                return false;
            }
        });

        $submitBtn.prop('disabled', !isComplete);
    }
});
