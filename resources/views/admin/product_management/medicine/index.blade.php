@extends('admin.layouts.master', ['pageSlug' => 'medicine'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Medicine List') }}</h4>
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
                                <th>{{ __('Medicine Category') }}</th>
                                <th>{{ __('Strength') }}</th>
                                <th>{{ __('Price') }}</th>
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
                                    <td> {{ $medicine->medicine_cat->name }} </td>
                                    <td> {{ $medicine->strength->quantity }} <small>{{$medicine->strength->unit}}</small> </td>
                                    <td> {{ $medicine->price }} {{__('Tk')}} </td>
                                    <td>
                                        <span
                                            class="{{ $medicine->getStatusBadgeClass() }}">{{ $medicine->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($medicine->created_at) }}</td>

                                    <td> {{ $medicine->created_user->name ?? 'system' }} </td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'product.medicine.details.medicine_list',
                                                    'params' => [$medicine->id],
                                                    'label' => 'View Details',
                                                ],
                                                [
                                                    'routeName' =>
                                                        'product.medicine.medicine_edit',
                                                    'params' => [$medicine->id],
                                                    'label' => 'Update',
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
