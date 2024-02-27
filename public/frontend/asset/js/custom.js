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
var searchInput = $('#searchInput');
var categorySelect = $('#categorySelect');
var suggestionBox = $('#suggestionBox');
$(document).ready(function() {
    searchInput.on('input', function() {
      
      searchFunction()
      
    });
    categorySelect.on('change', function(){
      searchFunction()
    });
    function searchFunction(){
      var search_value = searchInput.val();
      var category = categorySelect.val();
      if (search_value === 'all') {
        suggestionBox.hide();
      }else{
        suggestionBox.show();
      
        let url = ("{{ route('home.product.search',['search_value','category']) }}");
        let _url = url.replace('search_value', search_value);
        let __url = _url.replace('category', category);

        $.ajax({
          url:__url,
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            console.log(data.products);
          },
          error: function(xhr, status, error) {
              console.error('Error fetching search data:', error);
          }
        });


      }
}
});



// Homepage top slider
const myCarouselElement = document.querySelector('#carouselExampleCaptions')

const carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 4000,
  ride : true
})

