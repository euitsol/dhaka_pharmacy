// header-searchbar autocomplite
// $(document).ready(function() {
//     const $searchInput = $('#searchInput');
//     const $suggestionBox = $('#suggestionBox');
//     const suggestions = ['apple', 'all', 'ali', 'banana', 'orange', 'pineapple', 'grape', 'strawberry'];

//     $searchInput.on('input', function() {
//         const inputText = $(this).val().toLowerCase();
//         let suggestionsToShow = [];

//         if (inputText) {
//             suggestionsToShow = suggestions.filter(function(suggestion) {
//                 return suggestion.toLowerCase().startsWith(inputText);
//             });
//         }

//         renderSuggestions(suggestionsToShow);
//     });

//     function renderSuggestions(suggestionsToShow) {
//         if (suggestionsToShow.length > 0) {
//             const suggestionList = suggestionsToShow.map(function(suggestion) {
//                 return `<div class="suggestion">${suggestion}</div>`;
//             }).join('');

//             $suggestionBox.html(suggestionList).css('display', 'block');
//         } else {
//             $suggestionBox.html('').css('display', 'none');
//         }
//     }

//     // Hide suggestion box when clicking outside
//     $(document).on('click', function(e) {
//         if (!($suggestionBox.is(e.target) || $suggestionBox.has(e.target).length || $searchInput.is(e.target))) {
//             $suggestionBox.css('display', 'none');
//         }
//     });

//     // Fill input field with selected suggestion
//     $suggestionBox.on('click', '.suggestion', function(e) {
//         $searchInput.val($(this).text());
//         $suggestionBox.css('display', 'none');
//     });
// });

// New JS Code

// $(document).ready(function() {
//     var searchInput = $('#searchInput');
//     var categorySelect = $('#categorySelect');
//     var suggestionBox = $('#suggestionBox');

//     $(document).on('input',searchInput, function() {
//       searchFunction()

//     });
//     $(document).on('change',categorySelect, function(){
//       searchFunction()
//     });
//     function searchFunction(){
//       var search_value = searchInput.val();
//       var category = categorySelect.val();
//       if (search_value === 'all') {
//         suggestionBox.hide();
//       }else{
//         suggestionBox.show();

//         var url = "{{ route('home.product.search', ['search_value' => ':search', 'category' => ':category']) }}";
//         var _url = url.replace(':search', search_value).replace(':category', category);

//         $.ajax({
//           url:_url,
//           method: 'GET',
//           dataType: 'json',
//           success: function(data) {
//             console.log(data.products);
//           },
//           error: function(xhr, status, error) {
//               console.error('Error fetching search data:', error);
//           }
//         });

//       }
// }
// });

function numberFormat(value, decimals) {
    if (decimals != null && decimals >= 0) {
        value = parseFloat(value).toFixed(decimals);
    } else {
        value = Math.round(parseFloat(value)).toString();
    }

    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getCsrfToken() {
    return $("#csrf-token").val();
}

function formatPercentageNumber(number) {
    var formattedNumber = number.toString();
    formattedNumber = formattedNumber.includes(".")
        ? parseFloat(formattedNumber)
              .toFixed(2)
              .replace(/\.?0+$/, "")
        : formattedNumber;
    return formattedNumber;
}

// support JS

document.addEventListener("DOMContentLoaded", () => {
    const talkBubble = document.querySelector(".default-talk-bubble");
    const lastShownTime = localStorage.getItem("talkBubbleLastShown");
    const currentTime = new Date().getTime();

    // if (!lastShownTime || currentTime - lastShownTime > 3600000) {
    setTimeout(() => {
        talkBubble.classList.add("show");
        setTimeout(() => {
            talkBubble.classList.remove("show");
        }, 10000);
        localStorage.setItem("talkBubbleLastShown", currentTime);
    }, 2000);

    // }
});

document.addEventListener("DOMContentLoaded", () => {
    $("#chat").on("click", function () {
        const talkBubble = $(".default-talk-bubble");
        talkBubble.remove();
        $(this).toggleClass("active");
        $(".message_box").toggleClass("active");
    });

    $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
});

// Auth Chat Ticket Create
$(document).ready(function () {
    $("#authChatStartForm").on("submit", function (event) {
        event.preventDefault();
        let $this = $(this);
        $.ajax({
            url: $this.attr("action"),
            method: "POST",
            data: $this.serialize(),
            dataType: "json",
            success: function (response) {
                $this.parent().remove();
                $(".conversation").removeClass("d-none");
            },
            error: function (xhr) {
                // if (xhr.status === 422) {
                //     // Handle validation errors
                //     var errors = xhr.responseJSON.errors;
                //     $(".invalid-feedback").remove();
                //     $.each(errors, function (field, messages) {
                //         // Display validation errors
                //         var errorHtml = "";
                //         $.each(messages, function (index, message) {
                //             errorHtml +=
                //                 '<span class="invalid-feedback d-block" role="alert">' +
                //                 message +
                //                 "</span>";
                //         });
                //         $('[name="' + field + '"]').after(errorHtml);
                //         // Handle other errors.
                //         let imageError =
                //             '<span class="invalid-feedback d-block" role="alert">Image field is required</span>';
                //         $('[name="uploadfile"]').parent().after(imageError);
                //     });
                // } else {
                //     $(".invalid-feedback").remove();
                //     // Handle other errors.
                //     let imageError =
                //         '<span class="invalid-feedback d-block" role="alert">Image field is required</span>';
                //     $('[name="uploadfile"]').parent().after(imageError);
                // }
            },
        });
    });
});
