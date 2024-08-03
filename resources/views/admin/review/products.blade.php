@extends('admin.layouts.master', ['pageSlug' => 'review'])
@section('title', 'Review Product List')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Review Product List') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Total Active Review') }}</th>
                                <th>{{ __('Total Deactive Review') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $product->name }} </td>
                                    <td> <span
                                            class="badge bg-success">{{ $product->reviews->where('status', 1)->count() }}</span>
                                    </td>
                                    <td> <span
                                            class="badge bg-danger">{{ $product->reviews->where('status', 0)->count() }}</span>
                                    </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'review.review_list',
                                                    'params' => [$product->slug],
                                                    'label' => 'Reviews',
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3]])
