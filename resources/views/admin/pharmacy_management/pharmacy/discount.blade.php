@extends('admin.layouts.master', ['pageSlug' => 'pharmacy'])
@push('css')
    <style>
        .input-group .percentage{
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 30px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Update Pharmacy Discount')}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{route('pm.pharmacy.update.pharmacy_discount',encrypt($pharmacy->id))}}" method="POST">
                        @csrf
                        <div class="form-group">.
                            <label>{{__('Discount Percentage')}}</label>
                            <div class="input-group" role="group">
                                <input type="text" name="discount_percent" placeholder="Enter discount percentage" class="form-control" value="{{$pharmacy_discount ? $pharmacy_discount->discount_percent : old('discount_percent')}}">
                                <span class="input-group-btn bg-secondary percentage">&#37;</span>
                            </div>
                            @include('alerts.feedback', ['field' => 'discount_percent'])
                        </div>
                        @if($pharmacy_discount)
                            <span><strong class="text-danger">{{__('Note: ')}}</strong>{{__("If you wish to eliminate the percentage, please type '0' and submit.")}}</span>
                        @endif
                        
                        <div class="form-group text-end">.
                            <input type="submit" value="{{__('Update')}}" class="btn btn-success">
                        </div>
                    </form>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                    </nav>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__($pharmacy->name.' Discount History')}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Discount Percent') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Creation date') }}</th>
                                <th>{{ __('Created by') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pharmacy->pharmacyDiscounts as $discount)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> <span class="badge badge-info">{{__(number_format($discount->discount_percent).'%')}}</span> </td>
                                    <td>
                                        <span
                                            class="{{ $discount->getStatusBadgeClass() }}">{{ $discount->getStatus() }}</span>
                                    </td>
                                    <td>{{ $discount->created_date() }}</td>

                                    <td> {{ $discount->creater_name() }} </td>
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
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])
