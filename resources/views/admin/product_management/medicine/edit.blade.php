@extends('admin.layouts.master', ['pageSlug' => 'medicine'])

@section('content')
    <div class="row px-3 pt-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <form method="POST" action="{{ route('product.medicine.medicine_edit',$medicine->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                        <div class="row">
                            <div class="form-group col-md-6">

                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="Enter name" value="{{ $medicine->name }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Generic Name') }}</label>
                                <select name="generic_id"
                                    class="form-control {{ $errors->has('generic_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden>{{ __('Select generic name') }}</option>
                                    @foreach ($generics as $generic)
                                        <option value="{{ $generic->id }}"
                                            {{ ($generic->id == $medicine->generic_id) ? 'selected' : '' }}>
                                            {{ $generic->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'generic_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Product Category') }}</label>
                                <select name="pro_cat_id"
                                    class="form-control {{ $errors->has('pro_cat_id') ? ' is-invalid' : '' }} pro_cat">
                                    <option selected hidden>{{ __('Select product category') }}</option>
                                    @foreach ($pro_cats as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ ($cat->id == $medicine->pro_cat_id) ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'pro_cat_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Product Sub Category') }}</label>
                                <select name="pro_sub_cat_id"
                                    class="form-control {{ $errors->has('pro_sub_cat_id') ? ' is-invalid' : '' }} pro_sub_cat" >
                                    @foreach ($pro_sub_cats as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ ($cat->id == $medicine->pro_sub_cat_id) ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'pro_sub_cat_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Company Name') }}</label>
                                <select name="company_id"
                                    class="form-control {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden>{{ __('Select company name') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ ($company->id == $medicine->company_id) ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'company_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Medicine Category') }}</label>
                                <select name="medicine_cat_id"
                                    class="form-control {{ $errors->has('medicine_cat_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden>{{ __('Select medicine category') }}</option>
                                    @foreach ($medicine_cats as $medicine_cat)
                                        <option value="{{ $medicine_cat->id }}"
                                            {{ ($medicine_cat->id == $medicine->medicine_cat_id) ? 'selected' : '' }}>
                                            {{ $medicine_cat->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'medicine_cat_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Medicine Strength') }}</label>
                                <select name="strength_id"
                                    class="form-control {{ $errors->has('strength_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden>{{ __('Select medicine strength') }}</option>
                                    @foreach ($strengths as $strength)
                                        <option value="{{ $strength->id }}"
                                            {{ ($strength->id == $medicine->strength_id) ? 'selected' : '' }}>
                                            <small>{{ $strength->quantity }} </small> {{ $strength->unit }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'strength_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Medicine Unit') }}</label>
                                <select name="unit[]" class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }}"
                                    multiple="multiple">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{  (in_array($unit->id, (array)json_decode($medicine->unit, true)))  ? 'selected' : '' }}>{{ $unit->name }}
                                            <small>({{ $unit->quantity }})</small></option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'unit'])
                            </div>
                            <div class="form-group col-md-12">

                                <label>{{ __('Description') }}</label>
                                <textarea name="description" placeholder="Enter description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $medicine->description }}</textarea>
                                @include('alerts.feedback', ['field' => 'description'])
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Product Requirements  --}}
                <div class="card">
                    <div class="card-header">pan
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Medicine Requirements') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label mr-2">
                                      <input class="form-check-input prescription_required" type="checkbox" name="prescription_required" value="1" {{ ($medicine->prescription_required == 1) ? 'checked' : '' }}>
                                      <span class="form-check-sign"><strong>{{__('Prescription Required')}}</strong></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">

                                <label>{{ __('Max Quantity') }}</label>
                                <input type="text" name="max_quantity"
                                    class="form-control max_quantity {{ $errors->has('max_quantity') ? ' is-invalid' : '' }}"
                                    placeholder="Enter max-quantity" value="{{ old('max_quantity') }}" disabled>
                                @include('alerts.feedback', ['field' => 'max_quantity'])
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label mr-2">
                                      <input class="form-check-input" type="checkbox" name="kyc_required" value="1" {{ ($medicine->kyc_required == 1) ? 'checked' : '' }}>
                                      <span class="form-check-sign"><strong>{{__('KYC Required')}}</strong></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Pricing Card  --}}
                <div class="card medicine_price_card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Pricing') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">

                                <label>{{ __('Maximum Retail Price') }} <small>{{__('(MRP)')}}</small></label>
                                <div class="input-group" role="group">
                                    <input type="text" name="price"
                                    class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                    placeholder="Enter price" value="{{ $medicine->price }}">
                                    <span class="bdt_button">BDT</span>
                                </div>
                                @include('alerts.feedback', ['field' => 'price'])
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="form-group col-md-12">

                                <label>{{ __('Image') }}</label>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                @include('alerts.feedback', ['field' => 'image'])
                            </div>
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </form>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.pro_cat').on('change', function() {
                let pro_sub_cat = $('.pro_sub_cat');
                let id = $(this).val();
                let url = ("{{ route('product.medicine.sub_cat.medicine_list', ['id']) }}");
                let _url = url.replace('id', id);

                pro_sub_cat.prop('disabled',false);

                $.ajax({
                    url: _url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        data.pro_sub_cats.forEach(function(cat) {
                            result += `<option value="${cat.id}">${cat.name}</option>`;
                        });
                        pro_sub_cat.html(result);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching local area manager data:', error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            var checkbox = $('.prescription_required');
            var max_quantity = $('.max_quantity');

            if (checkbox.is(':checked')) {
                max_quantity.prop('disabled',false);
            }else{
                max_quantity.prop('disabled',true);
            }
            checkbox.on('change', function() {
                if (checkbox.is(':checked')) {
                    max_quantity.prop('disabled',false);
                } else {
                    max_quantity.prop('disabled',true);
                }
            });
        })
    </script>
@endpush
