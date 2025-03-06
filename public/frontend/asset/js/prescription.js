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

    // Request OTP
    $requestOtpBtn.on('click', function() {
        const phone = $phoneInput.val().trim();

        if (!phone) {
            toastr.error('Please enter a valid phone number');
            return;
        }

        if (phone.length != 10 || phone[0] == '0') {
            toastr.error('Phone number should be 10 digit');
            return;
        }

        // Display the phone number in the OTP step
        $phoneDisplay.text('+880' + phone);

        // In a real implementation, you would send an API request here
        // For now, we'll just simulate it
        toastr.success('OTP sent to your phone number');
        goToStep(3);
        startCountdown();
    });

    // OTP input handling
    $otpInputs.on('input', function(e) {
        const index = parseInt($(this).data('index'));
        const value = $(this).val();

        if (value.length === 1 && index < 4) {
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

    // Resend OTP
    $resendOtpBtn.on('click', function() {
        // In a real implementation, you would send an API request here
        toastr.success('OTP resent to your phone number');
        startCountdown();
        $resendOtpBtn.addClass('d-none');
    });

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
