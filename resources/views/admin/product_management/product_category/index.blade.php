@extends('admin.layouts.master', ['pageSlug' => 'product_category'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger {{($menuItemsCount%2 == 0) ? 'd-none' : ''}}">
                <span>{{__("Please add an even number of categories to the menu for design purposes. Now you have a total of $menuItemsCount categories in your menu.")}}</span>
            </div>
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Product Category List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.product_category.product_category_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new product category',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Menu') }}</th>
                                <th>{{ __('Featured') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_categories as $product_category)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $product_category->name }} </td>
                                    <td>
                                        <span
                                            class="{{ $product_category->getMenuBadgeClass() }}">{{ $product_category->getMenu() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $product_category->getFeaturedBadgeClass() }}">{{ $product_category->getFeatured() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $product_category->getStatusBadgeClass() }}">{{ $product_category->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($product_category->created_at) }}</td>

                                    <td> {{ $product_category->created_user->name ?? 'system' }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'javascript:void(0)',
                                                    'params' => [$product_category->id],
                                                    'label' => 'View Details',
                                                    'className' => 'view',
                                                    'data-id' => $product_category->id,
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.product_category.product_category_edit',
                                                    'params' => [$product_category->id],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.product_category.menu.product_category_edit',
                                                    'params' => [$product_category->id],
                                                    'label' => $product_category->getBtnMenu(),
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.product_category.featured.product_category_edit',
                                                    'params' => [$product_category->id],
                                                    'label' => $product_category->getBtnFeatured(),
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.product_category.status.product_category_edit',
                                                    'params' => [$product_category->id],
                                                    'label' => $product_category->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.product_category.product_category_delete',
                                                    'params' => [$product_category->id],
                                                    'label' => 'Delete',
                                                    'delete' => true,
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- District Manager Details Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Medicine Dosage Details') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
@push('js')
    <script>
        $(document).ready(function() {
            $('.view').on('click', function() {
                let id = $(this).data('id');
                let url = (
                    "{{ route('product.product_category.details.product_category_list', ['id']) }}");
                let _url = url.replace('id', id);
                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let status = data.status === 1 ? 'Active' : 'Deactive';
                        let statusClass = data.status === 1 ? 'badge-success' :
                            'badge-warning';
                        let menu = data.is_menu === 1 ? 'Yes' : 'No';
                        let menuClass = data.is_menu === 1 ? 'badge-primary' :
                            'badge-info';
                        let featured = data.is_featured === 1 ? 'Yes' : 'No';
                        let featuredClass = data.is_featured === 1 ? 'badge-primary' :
                            'badge-info';
                        var result = `
                                <table class="table table-striped">
                                    <tr>
                                        <th class="text-nowrap">Name</th>
                                        <th>:</th>
                                        <td>${data.name}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Image</th>
                                        <th>:</th>
                                        <td><img height='100px' width='100px' class='border-1 p-2' src="${data.image}"></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Menu</th>
                                        <th>:</th>
                                        <td><span class="badge ${menuClass}">${menu}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Featured</th>
                                        <th>:</th>
                                        <td><span class="badge ${featuredClass}">${featured}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Status</th>
                                        <th>:</th>
                                        <td><span class="badge ${statusClass}">${status}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created At</th>
                                        <th>:</th>
                                        <td>${data.creating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Created By</th>
                                        <th>:</th>
                                        <td>${data.created_by}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated At</th>
                                        <th>:</th>
                                        <td>${data.updating_time}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-nowrap">Updated By</th>
                                        <th>:</th>
                                        <td>${data.updated_by}</td>
                                    </tr>
                                </table>
                                `;
                        $('.modal_data').html(result);
                        $('.view_modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching district manager data:', error);
                    }
                });
            });
        });
    </script>
@endpush
