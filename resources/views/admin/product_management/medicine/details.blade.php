@extends('admin.layouts.master', ['pageSlug' => 'medicine'])
@section('title', 'Product Details')
@section('content')
    <div class="row px-3">
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

                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine.medicine_edit',
                                'params' => $medicine->slug,
                                'className' => 'btn-info text-white',
                                'label' => 'Edit',
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
                                <td>{{ __(optional($medicine->pro_cat)->name) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Product Sub Category') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>{{ __(optional($medicine->pro_sub_cat)->name) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Generic Name') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>{{ __(optional($medicine->generic)->name) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Company Name') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>{{ __(optional($medicine->company)->name) }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('Medicine Dosage') }}</th>
                                <th>{{ __(':') }}</th>
                                <td> {{ optional($medicine->dose)->name }} </td>
                            </tr>
                            @if ($medicine->strength_id)
                                <tr>
                                    <th>{{ __('Medicine Strength') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ optional($medicine->strength)->name }} </td>
                                </tr>
                            @endif
                            <tr>
                                <th>{{ __('Medicine Units') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>
                                    @foreach ($medicine->units as $unit)
                                        {{ $unit->name }} <small>({{ $unit->pivot->price }})</small>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Medical Device') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>
                                    <span
                                        class="{{ $medicine->getBestSellingBadgeClass() }}">{{ $medicine->getBestSelling() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>
                                    <span
                                        class="{{ $medicine->getStatusBadgeClass() }}">{{ $medicine->getStatus() }}</span>
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
                                    <span
                                        class="badge {{ $medicine->prescription_required == 1 ? 'badge-info' : 'badge-warning' }}">{{ $medicine->prescription_required == 1 ? 'Yes' : 'No' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Max Quantity') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>{{ $medicine->max_quantity }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('KYC Required') }}</th>
                                <th>{{ __(':') }}</th>
                                <td>
                                    <span
                                        class="badge {{ $medicine->kyc_required == 1 ? 'badge-info' : 'badge-warning' }}">{{ $medicine->kyc_required == 1 ? 'Yes' : 'No' }}</span>
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
                                <th>{{ __('Maximum Retail Price') }} <small>{{ __('(MRP)') }}</small></th>
                                <th>{{ __(':') }}</th>
                                <td> {{ number_format($medicine->price, 2) }}{{ __(' BDT') }} </td>
                            </tr>

                            <tr>
                                <th>{{ __('Discount Amount') }} </th>
                                <th>{{ __(':') }}</th>
                                <td> {{ number_format(calculateProductDiscount($medicine, false), 2) }}{{ __(' BDT') }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Discount Percentage') }} </th>
                                <th>{{ __(':') }}</th>
                                <td> {{ formatPercentageNumber(calculateProductDiscount($medicine, true)) }}{{ __(' %') }}
                                </td>
                            </tr>
                            <tr>
                                <th>{{ __('Price') }} </th>
                                <th>{{ __(':') }}</th>
                                <td> {{ number_format(proDisPrice($medicine->price, $medicine->discounts), 2) }}{{ __(' BDT') }}
                                </td>
                            </tr>
                            @foreach ($medicine->units as $unit)
                                <tr>
                                    <th>{{ __('Unit Price') }} <small>({{ $unit->name }})</small></th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ number_format($unit->pivot->price, 2) }}{{ __(' BDT') }} </td>
                                </tr>
                            @endforeach
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
                    <img height="200px" width="200px" src="{{ storage_url($medicine->image) }}"
                        alt="{{ $medicine->name }}">
                </div>
            </div>

            {{-- Product Precaution Card  --}}
            @if ($precaution)
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Precaution') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('Precaution') }}</small></th>
                                    <th>{{ __(':') }}</th>
                                    <td> {!! $precaution->description !!} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Status') }} </th>
                                    <th>{{ __(':') }}</th>
                                    <td><span
                                            class="{{ $precaution->getStatusBadgeClass() }}">{{ $precaution->getStatus() }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif


        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var main_th_width1 = $('.main_th1').width();
            var main_th_width2 = $('.main_th2').width();
            $('.content').find('tr th:first-child').css('width', main_th_width1 + 'px');
            $('.content').find('tr th:nth-child(2)').css('width', main_th_width2 + 'px');
        });
    </script>
@endpush
