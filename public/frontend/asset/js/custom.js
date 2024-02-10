// header-searchbar autocomplite
$(document).ready(function() {
    const $searchInput = $('#searchInput');
    const $suggestionBox = $('#suggestionBox');
    const suggestions = ['apple', 'all', 'ali', 'banana', 'orange', 'pineapple', 'grape', 'strawberry'];

    $searchInput.on('input', function() {
        const inputText = $(this).val().toLowerCase();
        let suggestionsToShow = [];

        if (inputText) {
            suggestionsToShow = suggestions.filter(function(suggestion) {
                return suggestion.toLowerCase().startsWith(inputText);
            });
        }

        renderSuggestions(suggestionsToShow);
    });

    function renderSuggestions(suggestionsToShow) {
        if (suggestionsToShow.length > 0) {
            const suggestionList = suggestionsToShow.map(function(suggestion) {
                return `<div class="suggestion">${suggestion}</div>`;
            }).join('');

            $suggestionBox.html(suggestionList).css('display', 'block');
        } else {
            $suggestionBox.html('').css('display', 'none');
        }
    }

    // Hide suggestion box when clicking outside
    $(document).on('click', function(e) {
        if (!($suggestionBox.is(e.target) || $suggestionBox.has(e.target).length || $searchInput.is(e.target))) {
            $suggestionBox.css('display', 'none');
        }
    });

    // Fill input field with selected suggestion
    $suggestionBox.on('click', '.suggestion', function(e) {
        $searchInput.val($(this).text());
        $suggestionBox.css('display', 'none');
    });
});

// Homepage top slider
const myCarouselElement = document.querySelector('#carouselExampleCaptions')

const carousel = new bootstrap.Carousel(myCarouselElement, {
  interval: 4000,
  ride : true
})

