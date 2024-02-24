@extends('admin.layouts.master', ['pageSlug' => 'medicine'])
@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-12">
                {{-- Product Details Card  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Product Details') }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                @include('admin.partials.button', [
                                    'routeName' => 'product.medicine.medicine_list',
                                    'className' => 'btn-primary',
                                    'label' => 'Back',
                                ])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Product Category') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->pro_cat->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Product Sub Category') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->pro_sub_cat->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Generic Name') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->generic->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Company Name') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->company->name) }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>{{ __('Medicine Dosage') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->medicine_cat->name }} </td>
                                </tr> --}}
                                <tr>
                                    <th>{{ __('Medicine Strength') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->strength->quantity }} <small>{{$medicine->strength->unit}}</small> </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Medicine Units') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->units }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Best Selling') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> 
                                        <span class="{{ $medicine->getBestSellingBadgeClass() }}">{{ $medicine->getBestSelling() }}</span> 
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> 
                                        <span class="{{ $medicine->getStatusBadgeClass() }}">{{ $medicine->getStatus() }}</span> 
                                    </td>
                                </tr>
                                <tr>
                                    <th class="main_th1">{{ __('Description') }}</th>
                                    <th class="main_th2">{{ __(':') }}</th>
                                    <td>{!! $medicine->description !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Product Requirements  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Requirements') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('Prescription Required') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> 
                                        <span class="badge {{ ($medicine->prescription_required == 1) ? 'badge-info' : 'badge-warning' }}">{{ ($medicine->prescription_required == 1) ? 'Yes' : 'No' }}</span> 
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Max Quantity') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{$medicine->max_quantity}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('KYC Required') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> 
                                        <span class="badge {{ ($medicine->kyc_required == 1) ? 'badge-info' : 'badge-warning' }}">{{ ($medicine->kyc_required == 1) ? 'Yes' : 'No' }}</span> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                {{-- Product Pricing Card  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Pricing') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('Maximum Retail Price') }} <small>{{__('(MRP)')}}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ number_format($medicine->price) }}{{__(' BDT')}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Product Image  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Image') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <img height="200px" width="200px" src="{{storage_url($medicine->image)}}" alt="{{$medicine->name}}">
                    </div>
                </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        var main_th_width1 = $('.main_th1').width();
        var main_th_width2 = $('.main_th2').width();
        $('.content').find('tr th:first-child').css('width',main_th_width1+'px');
        $('.content').find('tr th:nth-child(2)').css('width',main_th_width2+'px');
    });
</script>
    
@endpush
