@extends('admin.layouts.master', ['pageSlug' => 'medicine'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-12">
                {{-- Medicine Details Card  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Medicine Details') }}</h4>
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
                                    <th>{{ __('Generic Name') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->generic->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Company Name') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{{ __($medicine->company->name) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Medicine Category') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->medicine_cat->name }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Medicine Strength') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->strength->quantity }} <small>{{strtoupper($medicine->strength->unit)}}</small> </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Medicine Units') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ $medicine->units }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('Prescription Required') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> 
                                        <span class="badge {{ ($medicine->prescription_required == 1) ? 'badge-info' : 'badge-warning' }}">{{ ($medicine->prescription_required == 1) ? 'Yes' : 'No' }}</span> 
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
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td>{!! $medicine->description !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Medicine Pricing Card  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Medicine Pricing') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __(':') }}</th>
                                    <td> {{ number_format($medicine->price,2) }}{{__(' Tk')}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Medicine Image  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Medicine Image') }}</h4>
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
