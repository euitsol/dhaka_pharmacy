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

// // support JS

// document.addEventListener("DOMContentLoaded", () => {
//     const talkBubble = document.querySelector(".default-talk-bubble");
//     const lastShownTime = localStorage.getItem("talkBubbleLastShown");
//     const currentTime = new Date().getTime();

//     // if (!lastShownTime || currentTime - lastShownTime > 3600000) {
//     setTimeout(() => {
//         talkBubble.classList.add("show");
//         setTimeout(() => {
//             talkBubble.classList.remove("show");
//         }, 10000);
//         localStorage.setItem("talkBubbleLastShown", currentTime);
//     }, 2000);

//     // }
// });

// document.addEventListener("DOMContentLoaded", () => {
//     $("#chat").on("click", function () {
//         const talkBubble = $(".default-talk-bubble");
//         talkBubble.remove();
//         $(this).toggleClass("active");
//         $(".message_box").toggleClass("active");
//     });

//     $(".conversation").scrollTop($(".conversation")[0].scrollHeight);
// });

// // Function to handle chat ticket creation
// function handleChatTicketForm(formId, ticketKey, lastActiveTimeKey) {
//     $(document).ready(function () {
//         $(formId).on("submit", function (event) {
//             event.preventDefault();
//             let $this = $(this);

//             $.ajax({
//                 url: $this.attr("action"),
//                 method: "POST",
//                 data: $this.serialize(),
//                 dataType: "json",
//                 success: function (response) {
//                     if (response.success) {
//                         let conversation = $(".conversation");
//                         conversation
//                             .find(".conversation-list")
//                             .html(
//                                 '<span class="temp_text text-muted text-center d-block">Sent your message here.</span>'
//                             );
//                         $this.parent().remove();
//                         conversation.parent().removeClass("d-none");
//                         toastr.success(response.message);

//                         sessionStorage.setItem(ticketKey, response.ticket_id);
//                         sessionStorage.setItem(
//                             lastActiveTimeKey,
//                             new Date().getTime()
//                         );
//                     } else {
//                         toastr.error(response.message);
//                     }
//                 },
//                 error: function (xhr) {
//                     if (xhr.status === 422) {
//                         handleValidationErrors(xhr.responseJSON.errors);
//                     } else {
//                         toastr.error("An error occurred. Please try again.");
//                     }
//                 },
//             });
//         });
//     });
// }

// // Function to handle validation errors
// function handleValidationErrors(errors) {
//     $(".invalid-feedback").remove();
//     $.each(errors, function (field, messages) {
//         let errorHtml = messages
//             .map(
//                 (message) =>
//                     `<span class="invalid-feedback d-block" role="alert">${message}</span>`
//             )
//             .join("");
//         $(`[name="${field}"]`).after(errorHtml);
//     });
// }

// // Function to render chat messages
// function chatMessages(chatMessages, senderId) {
//     if (!Array.isArray(chatMessages)) {
//         chatMessages = [chatMessages]; // Convert single object to array
//     }
//     let result = "";
//     if (chatMessages.length == 0) {
//         result += `<span class="temp_text text-muted text-center d-block">Sent your message here.</span>`;
//     } else {
//         $(".temp_text").remove();
//         chatMessages.forEach((message) => {
//             result += `
//             <div class="conversation-item d-flex align-items-start ${
//                 message.sender_id != senderId
//                     ? "justify-content-end sent"
//                     : "justify-content-start "
//             }">`;
//             if (message.sender_id != senderId) {
//                 result += `<div class="author_logo">
//                     <img src="${message.author_image}" alt="avatar">
//                 </div>`;
//             }

//             result += `<div class="sms_text w-auto">
//                     <div class="message">${message.message}</div>
//                     <div class="time">${message.send_at}</div>
//                 </div>`;
//             if (message.sender_id === senderId) {
//                 result += `<div class="author_logo">
//                     <img src="${message.author_image}" alt="avatar">
//                 </div>`;
//             }
//             result += `</div>`;
//         });
//     }

//     return result;
// }

// // Initialize forms for both authenticated and guest users
// handleChatTicketForm(
//     "#authChatStartForm",
//     "authChatTicketId",
//     "authLastActiveTime"
// );
// handleChatTicketForm(
//     "#guestChatStartForm",
//     "guestChatTicketId",
//     "guestLastActiveTime"
// );

// // Chat Refresh Function
// function chatDataLoad() {
//     let authChatTicketId = sessionStorage.getItem("authChatTicketId", "null");
//     let guestChatTicketId = sessionStorage.getItem("guestChatTicketId", "null");
//     let route = routes.getMessages.replace("auth_ticket_id", authChatTicketId);
//     route = route.replace("guest_ticket_id", guestChatTicketId);
//     $.ajax({
//         url: route,
//         method: "GET",
//         dataType: "json",
//         success: function (data) {
//             if (data.success) {
//                 let conversation = $(".conversation");
//                 $(".chat_initial_form").remove();
//                 conversation
//                     .find(".conversation-list")
//                     .html(
//                         chatMessages(data.ticket.messages, data.ticketAbleId)
//                     );
//                 conversation.parent().removeClass("d-none");
//                 conversation.scrollTop(
//                     conversation[0].scrollHeight - conversation.height()
//                 );
//             }
//         },
//     });
// }
// $(document).ready(function () {
//     chatDataLoad();
// });

// function messageSend(formId) {
//     $(formId).on("submit", function (event) {
//         event.preventDefault();
//         let $this = $(this);

//         let authChatTicketId = sessionStorage.getItem(
//             "authChatTicketId",
//             "null"
//         );
//         let guestChatTicketId = sessionStorage.getItem(
//             "guestChatTicketId",
//             "null"
//         );

//         $.ajaxSetup({
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//             },
//         });
//         $.ajax({
//             url: $this.attr("action"),
//             method: "POST",
//             data: {
//                 message: $this.find('textarea[name="message"]').val(),
//                 auth_ticket_id: authChatTicketId,
//                 guest_ticket_id: guestChatTicketId,
//             },
//             dataType: "json",
//             success: function (response) {
//                 if (response.success) {
//                     console.log(response);

//                     let conversation = $(".conversation");
//                     conversation.find(".conversation-list").append(
//                         `<div class="conversation-item d-flex align-items-start justify-content-end sent">
//                             <div class="sms_text w-auto">
//                                 <div class="message">${response.reply}</div>
//                                 <div class="time">${response.send_at}</div>
//                             </div>
//                             <div class="author_logo">
//                                 <img src="${response.author_image}" alt="avatar">
//                             </div>
//                         </div>`
//                     );
//                     $(".temp_text").remove();
//                     if (response.auth) {
//                         sessionStorage.setItem(
//                             "authLastActiveTime",
//                             new Date().getTime()
//                         );
//                     } else {
//                         sessionStorage.setItem(
//                             "guestLastActiveTime",
//                             new Date().getTime()
//                         );
//                     }
//                 } else {
//                     toastr.error(response.message);
//                 }
//             },
//             error: function (xhr) {
//                 if (xhr.status === 422) {
//                     handleValidationErrors(xhr.responseJSON.errors);
//                 } else {
//                     toastr.error("An error occurred. Please try again.");
//                 }
//             },
//         });
//     });
// }

// messageSend("#guestChatForm");
// messageSend("#authChatForm");

// sub categories animation js code

// document.addEventListener("DOMContentLoaded", () => {
//     const subCategories = document.querySelectorAll(".sub-categories-list li");
//     const animatedContainer = document.querySelector(".animated-subcategories");

//     let currentIndex = 0;

//     // Function to start typing animation
//     const typeSubcategory = (text) => {
//         let i = 0;
//         animatedContainer.textContent = ""; // Reset content
//         animatedContainer.style.animation = 'none'; // Disable animation for reset
//         animatedContainer.style.width = '0'; // Reset width to 0

//         // Re-enable animation for typing effect
//         setTimeout(() => {
//             animatedContainer.style.animation = `typing ${text.length * 0.1}s steps(${text.length}) 1s forwards, blink 0.75s step-end infinite`;

//             const typingInterval = setInterval(() => {
//                 animatedContainer.textContent += text.charAt(i); // Append one character at a time
//                 i++;

//                 if (i === text.length) {
//                     clearInterval(typingInterval); // Stop typing once done
//                     setTimeout(() => {
//                         eraseSubcategory(text); // Start erasing after typing
//                     }, 1000); // Wait before erasing
//                 }
//             }, 100); // Adjust typing speed (lower = faster)
//         }, 10); // Wait briefly before starting the typing animation
//     };

//     // Function to start erasing animation
//     const eraseSubcategory = (text) => {
//         animatedContainer.style.animation = "erase 1s linear forwards";
//         setTimeout(() => {
//             currentIndex = (currentIndex + 1) % subCategories.length; // Move to next subcategory
//             typeSubcategory(subCategories[currentIndex].textContent); // Start typing next subcategory
//         }, 1000); // Wait before starting the next cycle
//     };

//     // Initial type animation
//     typeSubcategory(subCategories[currentIndex].textContent);
// });




document.addEventListener("DOMContentLoaded", function () {
    // Initialize locale from session
    document.documentElement.lang = "{{ app()->getLocale() }}";
    let cartbtnElement = document.getElementById("cartbtn"); 
    let wishlistElement = document.getElementById("wishlist"); 

    document.addEventListener("click", function (event) {
        // Check if the clicked area is outside the cartbtn offcanvas and if it's shown
        if (cartbtnElement && !cartbtnElement.contains(event.target) && cartbtnElement.classList.contains("show")) {
            let cartbtnInstance = bootstrap.Offcanvas.getInstance(cartbtnElement);
            if (cartbtnInstance) {
                cartbtnInstance.hide();
            }
        }
        
        // Check if the clicked area is outside the wishlist offcanvas and if it's shown
        if (wishlistElement && !wishlistElement.contains(event.target) && wishlistElement.classList.contains("show")) {
            let wishlistInstance = bootstrap.Offcanvas.getInstance(wishlistElement);
            if (wishlistInstance) {
                wishlistInstance.hide();
            }
        }
    });
});

  

// Simulating network delay (5 seconds)
setTimeout(function() {
    document.body.classList.add('loaded');
}, 5000); 

window.addEventListener('load', function() {
    // Once the page is fully loaded, hide the loading screen and change background to white
    document.body.classList.add('loaded');
});


// Select the button
const addToCartBtn = document.querySelector('.cart-btn');

// Add an event listener to the button to toggle the active class on click
addToCartBtn.addEventListener('click', function() {
  addToCartBtn.classList.add('active');
  
  // After 2 seconds (2000ms), remove the 'active' class
  setTimeout(function() {
    addToCartBtn.classList.remove('active');
  }, 3000);
});

// place order button active color js code
document.querySelector('.place-order').addEventListener('click', function() {
    this.classList.toggle('active');
});