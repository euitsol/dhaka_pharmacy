@extends('admin.layouts.master', ['pageSlug' => 'medicine'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Product List') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine.medicine_create',
                                'className' => 'btn-primary',
                                'label' => 'Add new medicine',
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
                                <th>{{ __('Product Category') }}</th>
                                <th title="{{__('Maximum Retail Price')}}">{{__('MRP')}}</th>
                                <th>{{ __('Discount') }} </th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Best Selling') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $medicine->name }} </td>
                                    <td> {{ $medicine->pro_cat->name }} </td>
                                    <td> {{ number_format($medicine->regular_price,2) }} {{__('BDT')}} </td>
                                    <td> {{ number_format(productDiscountAmount($medicine->id),2) }}{{__(' BDT')}} </td>
                                    <td> {{ number_format($medicine->price,2) }} {{__('BDT')}} </td>
                                    <td>
                                        <span
                                            class="{{ $medicine->getBestSellingBadgeClass() }}">{{ $medicine->getBestSelling() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $medicine->getStatusBadgeClass() }}">{{ $medicine->getStatus() }}</span>
                                    </td>
                                    <td>{{ $medicine->created_date() }}</td>

                                    <td> {{ $medicine->created_user_name() }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'product.medicine.details.medicine_list',
                                                    'params' => [$medicine->slug],
                                                    'label' => 'View Details',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine.medicine_edit',
                                                    'params' => [$medicine->slug],
                                                    'label' => 'Update',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine.best_selling.medicine_edit',
                                                    'params' => [$medicine->id],
                                                    'label' => $medicine->getBtnBestSelling(),
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine.status.medicine_edit',
                                                    'params' => [$medicine->id],
                                                    'label' => $medicine->getBtnStatus(),
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine.medicine_delete',
                                                    'params' => [$medicine->id],
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
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5]])
