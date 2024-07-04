@extends('admin.layouts.master', ['pageSlug' => 'medicine_strength'])

@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Update Medicine Strength') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'product.medicine_strength.medicine_strength_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <form method="POST"
                    action="{{ route('product.medicine_strength.medicine_strength_edit', $medicine_strength->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <div class="inptu-group">
                                <div class="quantity">
                                    <label>{{ __('Quantity') }}</label>
                                    <input type="text" name="quantity" class="form-control" placeholder="Enter quantity"
                                        value="{{ $medicine_strength->quantity }}">
                                    @include('alerts.feedback', ['field' => 'quantity'])
                                </div>
                                <div class="unit">
                                    <label>{{ __('Unit') }}</label>
                                    <select name="unit" class="form-control">
                                        <option selected hidden>{{ __('Select unit') }}</option>
                                        <option value="mg" {{ $medicine_strength->unit == 'mg' ? 'selected' : '' }}>
                                            {{ __('MG') }}</option>
                                        <option value="ml" {{ $medicine_strength->unit == 'ml' ? 'selected' : '' }}>
                                            {{ __('ML') }}</option>
                                        <option value="kg" {{ $medicine_strength->unit == 'kg' ? 'selected' : '' }}>
                                            {{ __('KG') }}</option>
                                        <option value="gm" {{ $medicine_strength->unit == 'gm' ? 'selected' : '' }}>
                                            {{ __('GM') }}</option>
                                        <option value="litter"
                                            {{ $medicine_strength->unit == 'litter' ? 'selected' : '' }}>
                                            {{ __('Litter') }}</option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'unit'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
