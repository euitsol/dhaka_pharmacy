// // Global AJAX configuration (runs once)
// $.ajaxSetup({
//     headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
// });

// // Create a module for cart operations
// const CartModule = (() => {
//     const addItem = ({ slug, unit = null, quantity = 1 }) => {
//         return $.ajax({
//             url: routes.cart_add,
//             method: "POST",
//             dataType: "json",
//             data: { slug, unit, quantity },
//         });
//     };

//     const refreshItems = () => {
//         return $.ajax({
//             url: routes.cart,
//             method: "GET",
//             dataType: "json",
//         });
//     };

//     const handleAddItemResponse = (response) => {
//         if (response.success) {
//             toastr.success(response.message);
//             refreshCart();
//         } else {
//             handleAddItemError(response);
//         }
//     };

//     const handleAddItemError = (response) => {
//         if (response.errors) {
//             toastr.error(response.errors);
//         } else if (response.message) {
//             toastr.error(response.message);
//         } else {
//             toastr.error("Something went wrong. Please try again.");
//         }
//     };

//     const handleError = (xhr, textStatus, errorThrown) => {
//         console.log("AJAX Error:", xhr);
//         console.error("AJAX Error:", textStatus, errorThrown);
//         if (xhr.status === 401) {
//             handleLoginRequirement();
//         }else if(xhr.status === 422){
//             const response = xhr.responseJSON || JSON.parse(xhr.responseText);
//             if (response.errors) {
//                 let errorMessages = '';
//                 for (let field in response.errors) {
//                     if (response.errors.hasOwnProperty(field)) {
//                         response.errors[field].forEach((message) => {
//                             errorMessages += `${message}<br>`;
//                         });
//                     }
//                 }

//                 toastr.error(errorMessages);
//             } else if (response.message) {
//                 toastr.error(response.message);
//             } else {
//                 toastr.error("An error occurred. Please try again.");
//             }
//         }else {
//             toastr.error(
//                 "An unexpected error occurred. Please try again later."
//             );
//         }
//     };

//     // Return an object exposing the functions you want to be public
//     return {
//         addItem,
//         handleAddItemResponse,
//         handleError,
//     };
// })();

// $(document).ready(() => {
//     refreshCart();

//     $(document).on("click", ".add_to_card .cart-btn", (event) => {
//         event.preventDefault();

//         const $button = $(event.currentTarget);
//         const product_slug = $button.data("product_slug");
//         const unit_id = $button.data("unit_id");
//         const quantity = $button.data("quantity") || 1;

//         console.log("Add-to-cart clicked for:", product_slug);

//         CartModule.addItem({
//             slug: product_slug,
//             unit: unit_id || null,
//             quantity,
//         })
//         .done((response) => CartModule.handleAddItemResponse(response))
//         .fail((xhr, textStatus, errorThrown) =>
//             CartModule.handleError(xhr, textStatus, errorThrown)
//         );
//     });
// });
