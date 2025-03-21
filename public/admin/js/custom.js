const imageUploadInputs = document.querySelectorAll(".image-upload");
const existingFilesArray = [];
const deleteUrlArray = [];

// Add event listener for each file input change
imageUploadInputs.forEach(function (imageUploadInput, index) {
    // Check if data-existing-files attribute is present
    if (imageUploadInput.hasAttribute("data-existing-files")) {
        const mainDiv = document.createElement("div");
        mainDiv.classList.add("imagePreviewMainDiv");
        imageUploadInput.parentNode.append(mainDiv);

        const existingFilesValue = imageUploadInput.getAttribute(
            "data-existing-files"
        );
        const deleteUrlValue = imageUploadInput.getAttribute("data-delete-url");
        if (existingFilesValue) {
            let existingFiles;
            let deleteUrl;
            try {
                existingFiles = existingFilesValue;
                deleteUrl = deleteUrlValue;
            } catch (error) {
                existingFiles = [existingFilesValue];
                deleteUrl = [deleteUrlValue];
            }

            var dataArray = existingFiles.split(",");
            var dltArray = deleteUrl.split(",");
            if (Array.isArray(dataArray)) {
                dataArray.forEach(function (item, index) {
                    populateImagePreview(item, dltArray[index], mainDiv);
                });
            } else {
                console.log(dataArray);
                populateImagePreview(dataArray, dltArray[index], mainDiv);
            }
        }
    }
});

$(document).on("change", ".image-upload", function () {
    const imageUploadContainer = this.parentNode;
    let mainDiv = imageUploadContainer.querySelector(".imagePreviewMainDiv");
    if (!mainDiv) {
        mainDiv = document.createElement("div");
        mainDiv.classList.add("imagePreviewMainDiv");
        imageUploadContainer.appendChild(mainDiv);
    }

    const files = Array.from(this.files);

    // Remove previous images if not multiple
    if (!this.hasAttribute("multiple")) {
        const previousImages = mainDiv.querySelectorAll(".imagePreview");
        previousImages.forEach(function (image) {
            image.parentNode.remove();
        });
    }

    files.forEach(function (file) {
        const imagePreviewDiv = document.createElement("div");
        imagePreviewDiv.classList.add("imagePreviewDiv");

        // Create the image element
        const previewImage = document.createElement("img");
        previewImage.classList.add(
            "imagePreview",
            "rounded",
            "me-50",
            "border"
        );
        previewImage.setAttribute("src", "#");
        previewImage.setAttribute("alt", "Uploaded Image");

        // Create the remove button
        const removeButton = document.createElement("i");
        removeButton.classList.add(
            "fa",
            "fa-trash",
            "removeImage",
            "text-danger"
        );
        removeButton.addEventListener("click", function () {
            const imageContainer = this.parentNode;
            const imagePreview = imageContainer.querySelector(".imagePreview");

            imageContainer.remove();
        });

        imagePreviewDiv.appendChild(previewImage);
        imagePreviewDiv.appendChild(removeButton);

        // Append the preview div to the container
        mainDiv.appendChild(imagePreviewDiv);

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImage.setAttribute("src", e.target.result);
        };
        reader.readAsDataURL(file);
    });
});

function populateImagePreview(file, deleteUrl, container) {
    // files.forEach(function (file) {
    const imagePreviewDiv = document.createElement("div");
    imagePreviewDiv.classList.add("imagePreviewDiv");

    // Create the image element
    const previewImage = document.createElement("img");
    previewImage.classList.add("imagePreview", "rounded", "me-50", "border");
    previewImage.setAttribute("src", file);
    previewImage.setAttribute("alt", "Uploaded Image");

    //Create a Tag
    if (deleteUrl) {
        var anchorLink = document.createElement("a");
        anchorLink.setAttribute("href", deleteUrl);
    }

    // Create the remove button
    const removeButton = document.createElement("i");
    removeButton.classList.add(
        "fa-solid",
        "fa-trash",
        "removeImage",
        "text-danger"
    );

    // Add event listener for remove button click
    removeButton.addEventListener("click", function (e) {
        const imageContainer = this.parentNode;
        const imagePreview = imageContainer.querySelector(".imagePreview");

        imageContainer.remove();
    });
    imagePreviewDiv.appendChild(previewImage);
    if (!deleteUrl) {
        imagePreviewDiv.appendChild(removeButton);
    } else {
        anchorLink.appendChild(removeButton);
        imagePreviewDiv.appendChild(anchorLink);
    }

    container.appendChild(imagePreviewDiv);
    // });
}

//Select 2
$(document).ready(function () {
    $("select:not(.no-select)").select2({
        cache: false
    });
});

// Slug Generator
function generateSlug(str) {
    return str
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\u0980-\u09FF-]+/g, "") // Allow Bangla characters (\u0980-\u09FF)
        .replace(/--+/g, "-")
        .replace(/^-+|-+$/g, "");
}

$(document).ready(function () {
    $("#title").on("keyup", function () {
        const titleValue = $(this).val().trim();
        const slugValue = generateSlug(titleValue);
        $("#slug").val(slugValue);
    });
});
function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }

    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).ready(function () {
    $(".navbar-toggler").on("click", function () {
        $(".sidebar").toggleClass("sidebar_show");
    });
});
