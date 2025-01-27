<script>
    $(document).ready(function() {
        var searchInput = $('#searchInput');
        var categorySelect = $('#categorySelect');
        var suggestionBox = $('#suggestionBox');

        searchInput.on('input', function() {

            searchFunction()

        });
        categorySelect.on('change', function() {
            searchFunction()
        });

        function searchFunction() {
            var search_value = searchInput.val();
            var category = categorySelect.val();
            if (search_value === '') {
                suggestionBox.hide();
                $('.header-section .search-filter input').css('border-radius', '10px 0 0 10px');
                $('.header-section .search-filter .sub-btn').css('border-radius', '0px 10px 11px 0');
            } else {
                suggestionBox.show();
                $('.header-section .search-filter input').css('border-radius', '10px 0 0 0');
                $('.header-section .search-filter .sub-btn').css('border-radius', '0px 10px 0 0');
                var url =
                    "{{ route('home.product.search', ['search_value' => ':search', 'category' => ':category']) }}";
                var _url = url.replace(':search', search_value).replace(':category', category);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = ''
                        if (!data.products || data.products.length === 0) {
                            result = `
                                    <span class="text-danger text-center d-block my-5">Medicine Not Found</span>
                                `;
                        }
                        data.products.forEach(function(product) {
                            let route = (
                            "{{ route('product.single_product', ['slug']) }}");
                            let _route = route.replace('slug', product.slug);
                            result += `
                                <a href="${_route}">
                                    <div class="card search_item mb-2">
                                        <div class="card-body py-2">
                                            <div class="row align-items-center">
                                                <div class="image col-4 col-sm-3">
                                                    <img class="w-100 border border-1 rounded-1"
                                                        src="${product.image}"
                                                        alt="${product.name}">
                                                </div>
                                                <div class="col-8 col-sm-9 details">
                                                    <h4 class="product_title">${product.name}</h4>
                                                    <p class="product_sub_cat">${product.pro_cat.name}</p>
                                                    <p>${product.generic ? product.generic.name : ''}</p>
                                                    <p>${product.company ? product.company.name : ''}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            `;
                        });
                        suggestionBox.html(result);



                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching search data:', error);
                    }
                });


            }
        }
    });
</script>
