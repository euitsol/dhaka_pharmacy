$(document).ready(function() {
    const $fileInput = $('#prescription');
    const $previewContainer = $('.image-preview');
    const $uploadArea = $('.upload-area');
    const maxLimit = 2;

    // File input change event
    $fileInput.on('change', handleFiles);

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

                    // var idArray = $('input[name="uploaded_image[]"]').map(function() {
                    //     return $(this).val();
                    // }).get();
                    // console.log(idArray);

                    addRemoveButton($preview);
                    $preview.addClass('loaded');

                    toastr.success('File uploaded successfully.');
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
        });
    }
});
