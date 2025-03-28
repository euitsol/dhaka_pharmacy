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
    removeButton.addEventListener("click", function () {
        const imageContainer = this.parentNode;
        const imagePreview = imageContainer.querySelector(".imagePreview");

        imageContainer.remove();
    });

    imagePreviewDiv.appendChild(previewImage);
    if (deleteUrl) {
        anchorLink.appendChild(removeButton);
        imagePreviewDiv.appendChild(anchorLink);
    } else {
        imagePreviewDiv.appendChild(removeButton);
    }
    container.appendChild(imagePreviewDiv);
    // });
}

function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }
    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function updateUrlParameter(param, value) {
    var url = new URL(window.location.href);
    url.searchParams.set(param, value);
    window.history.pushState({}, "", url);
}


// Header Toggle JS 

// $(document).ready(function () {
//     $(".toggle_bar .toggle_icon").on("click", function () {
//         if($(this).hasClass("fa-bars")){
//             $(this).removeClass("fa-bars").addClass("fa-bars-staggered");
//         }else{
//             $(this).removeClass("fa-bars-staggered").addClass("fa-bars");
//         }
//         $(".header-section .nav-menu").toggleClass("active");
//     });

// });


$(document).ready(function () {
    $(".toggle_bar .toggle_icon").on("click", function (event) {
        event.stopPropagation(); // Prevent event bubbling
        if ($(this).hasClass("fa-bars")) {
            $(this).removeClass("fa-bars").addClass("fa-bars-staggered");
        } else {
            $(this).removeClass("fa-bars-staggered").addClass("fa-bars");
        }
        $(".header-section .nav-menu").toggleClass("active");
    });

    // Close nav-menu only when clicking outside, but not on buttons inside .nav-menu
    $(document).on("click", function (event) {
        if (!$(event.target).closest(".nav-menu, .toggle_bar .toggle_icon").length) {
            $(".header-section .nav-menu").removeClass("active");
            $(".toggle_bar .toggle_icon").removeClass("fa-bars-staggered").addClass("fa-bars"); // Reset icon
        }
    });

    // Prevent clicks inside the nav-menu from closing it
    $(".header-section .nav-menu").on("click", function (event) {
        event.stopPropagation();
    });
});










// languate js code here
function toggleLanguage() {
    const localeInput = document.getElementById("localeInput");
    const switchBtn = document.getElementById("switch-btn");
    const englishText = document.getElementById("english-text");
    const banglaText = document.getElementById("bangla-text");

    if (localeInput.value === "en") {
        localeInput.value = "bn";
        switchBtn.classList.remove("active-left");
        switchBtn.classList.add("active-right");
        englishText.classList.remove("active-text");
        banglaText.classList.add("active-text");
    } else {
        localeInput.value = "en";
        switchBtn.classList.remove("active-right");
        switchBtn.classList.add("active-left");
        banglaText.classList.remove("active-text");
        englishText.classList.add("active-text");
    }

    document.getElementById("languageForm").submit();
}


// cart slider js code here
document.addEventListener("DOMContentLoaded", function () {
    // Initialize locale from session
    document.documentElement.lang = "{{ app()->getLocale() }}";
    let cartbtnElement = document.getElementById("cartbtn"); 
    document.addEventListener("click", function (event) {
        if (cartbtnElement && !cartbtnElement.contains(event.target) && cartbtnElement.classList.contains("show")) {
            let cartbtnInstance = bootstrap.Offcanvas.getInstance(cartbtnElement);
            if (cartbtnInstance) {
                cartbtnInstance.hide();
            }
        }
    });
});



// document.addEventListener("DOMContentLoaded", function () {
//     var dropdownElementList = document.querySelectorAll('.dropdown-toggle');
//     dropdownElementList.forEach(function (dropdown) {
//         new bootstrap.Dropdown(dropdown);
//     });
// });
