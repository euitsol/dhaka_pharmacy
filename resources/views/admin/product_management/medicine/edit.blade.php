@extends('admin.layouts.master', ['pageSlug' => 'medicine'])
@section('title', 'Edit Product')
@section('content')
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <form method="POST" action="{{ route('product.medicine.medicine_edit', $medicine->id) }}"
                enctype="multipart/form-data">
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
                                <input type="text" name="name" id="title"
                                    class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    placeholder="Enter name" value="{{ $medicine->name }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Slug') }}</label>
                                <input type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}"
                                    id="slug" name="slug"
                                    placeholder="{{ __('Enter Slug (must be use - on white speace)') }}"
                                    value="{{ $medicine->slug }}">
                                @include('alerts.feedback', ['field' => 'slug'])
                            </div>

                            <div class="form-group col-md-6">
                                <label>{{ __('Product Category') }}</label>
                                <select name="pro_cat_id"
                                    class="form-control {{ $errors->has('pro_cat_id') ? ' is-invalid' : '' }} pro_cat">
                                    <option selected hidden value=" ">{{ __('Select product category') }}</option>
                                    @foreach ($pro_cats as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $cat->id == $medicine->pro_cat_id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'pro_cat_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Product Sub Category') }}</label>
                                <select name="pro_sub_cat_id"
                                    class="form-control {{ $errors->has('pro_sub_cat_id') ? ' is-invalid' : '' }} pro_sub_cat">
                                    <option value="">{{ __('Select subcategory') }}</option>
                                    @foreach ($pro_sub_cats as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $cat->id == $medicine->pro_sub_cat_id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'pro_sub_cat_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Generic Name') }}</label>
                                <select name="generic_id"
                                    class="form-control {{ $errors->has('generic_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden value=" ">{{ __('Select generic name') }}</option>
                                    @foreach ($generics as $generic)
                                        <option value="{{ $generic->id }}"
                                            {{ $generic->id == $medicine->generic_id ? 'selected' : '' }}>
                                            {{ $generic->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'generic_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Company Name') }}</label>
                                <select name="company_id"
                                    class="form-control {{ $errors->has('company_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden value=" ">{{ __('Select company name') }}</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $medicine->company_id ? 'selected' : '' }}>
                                            {{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'company_id'])
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label>{{ __('Medicine Dosage') }}</label>
                                <select name="medicine_cat_id"
                                    class="form-control {{ $errors->has('medicine_cat_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden value=" ">{{ __('Select medicine dosage') }}</option>
                                    @foreach ($medicine_cats as $medicine_cat)
                                        <option value="{{ $medicine_cat->id }}"
                                            {{ ($medicine_cat->id == $medicine->medicine_cat_id) ? 'selected' : '' }}>
                                            {{ $medicine_cat->name }}</option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'medicine_cat_id'])
                            </div> --}}
                            <div class="form-group col-md-6">
                                <label>{{ __('Medicine Strength') }}</label>
                                <select name="strength_id"
                                    class="form-control {{ $errors->has('strength_id') ? ' is-invalid' : '' }}">
                                    <option selected hidden value=" ">{{ __('Select medicine strength') }}</option>
                                    @foreach ($strengths as $strength)
                                        <option value="{{ $strength->id }}"
                                            {{ $strength->id == $medicine->strength_id ? 'selected' : '' }}>
                                            {{ $strength->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'strength_id'])
                            </div>
                            <div class="form-group col-md-6">
                                <label>{{ __('Medicine Unit') }}</label>
                                <select name="unit[]"
                                    class="form-control {{ $errors->has('unit') ? ' is-invalid' : '' }} unit"
                                    multiple="multiple">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ in_array($unit->id, $medicine->units->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                            <small>({{ $unit->quantity }})</small>
                                            <small>{{ $unit->type ? '-' . $unit->type : '' }}</small>
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'unit'])
                            </div>
                            <div class="form-group col-md-12">

                                <label>{{ __('Description') }}</label>
                                <textarea name="description" placeholder="Enter description"
                                    class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $medicine->description }}</textarea>
                                @include('alerts.feedback', ['field' => 'description'])
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Product Requirements  --}}
                <div class="card">
                    <div class="card-header">
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
                                        <input class="form-check-input prescription_required" type="checkbox"
                                            name="prescription_required" value="1"
                                            {{ $medicine->prescription_required == 1 ? 'checked' : '' }}>
                                        <span
                                            class="form-check-sign"><strong>{{ __('Prescription Required') }}</strong></span>
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
                                        <input class="form-check-input" type="checkbox" name="kyc_required" value="1"
                                            {{ $medicine->kyc_required == 1 ? 'checked' : '' }}>
                                        <span class="form-check-sign"><strong>{{ __('KYC Required') }}</strong></span>
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
                            <div class="col-8">
                                <h4 class="card-title">{{ __('Product Pricing') }}</h4>
                            </div>
                            @if ($discounts->isNotEmpty())
                                <div class="col-4 text-end">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        title="Discount History" data-target="#discount_modal">
                                        <i class="fa-solid fa-info"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{ __('Maximum Retail Price') }} <small>{{ __('(MRP)') }}</small></label>
                                <div class="input-group" role="group">
                                    <input type="text" name="price"
                                        class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                        placeholder="Enter price"
                                        value="{{ number_format(proDisPrice($medicine->price, $medicine->discounts), 2) }}">
                                    <span class="bdt_button">BDT</span>
                                </div>
                                @include('alerts.feedback', ['field' => 'price'])
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Discount') }}</label>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios2" value="0"
                                            @if (empty(calculateProductDiscount($medicine, false))) checked @endif>
                                        {{ __('NO') }}
                                        <span class="form-check-sign"></span>
                                    </label>
                                    <label class="form-check-label ms-5">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios1" value="1"
                                            @if (!empty(calculateProductDiscount($medicine, false))) checked @endif>
                                        {{ __('YES') }}
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-md-4" style="display: none;">
                                <label>{{ __('Discount Percentage') }}</label>
                                <div class="input-group" role="group">
                                    <input type="text" id="discount_percentage" name="discount_percentage"
                                        class="form-control {{ $errors->has('discount_percentage') ? ' is-invalid' : '' }}"
                                        placeholder="Enter discount percentage"
                                        value="{{ isset($discount->discount_percentage) ? formatPercentageNumber($discount->discount_percentage) : '' }}">
                                    <span class="bdt_button">{{ __('%') }}</span>
                                </div>
                                @include('alerts.feedback', ['field' => 'discount_percentage'])
                            </div>
                            <div class="form-group col-md-4" style="display: none;">
                                <label>{{ __('Discount Amount') }}</label>
                                <input type="text" id="discount_amount" name="discount_amount"
                                    class="form-control {{ $errors->has('discount_amount') ? ' is-invalid' : '' }}"
                                    placeholder="Enter discount percentage"
                                    value="{{ optional($discount)->discount_amount }}">
                                @include('alerts.feedback', ['field' => 'discount_amount'])
                            </div>
                            <div class="form-group col-md-12 row mt-2" id="unit-prices-container">
                                @foreach ($medicine->units as $unit)
                                    <div class="form-group col-md-6 unit-price-item">
                                        <label for="price-unit-14">Price for Unit: {{ $unit->name }}</label>
                                        <input type="hidden" class="d-none" id="unit-14"
                                            name="units[{{ $unit->id }}][id]" value="{{ $unit->id }}">
                                        <input type="number" value="{{ $unit->pivot->price }}" class="form-control"
                                            id="price-unit-{{ $unit->id }}" name="units[{{ $unit->id }}][price]"
                                            placeholder="Enter price for {{ $unit->name }}">
                                    </div>
                                @endforeach
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
                            <div class="col-4">
                                <img src="{{ $medicine->image }}" alt="">
                            </div>
                            <div class="form-group col-md-12">

                                <label>{{ __('Image') }}</label>
                                <input type="file" name="image" accept="image/*"
                                    class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                                @include('alerts.feedback', ['field' => 'image'])
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Product Precaution  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title">{{ __('Product Precaution') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>{{ __('Precaution') }}</label>
                                <textarea name="precaution" placeholder="Enter product precaution"
                                    class="form-control {{ $errors->has('precaution') ? ' is-invalid' : '' }}">{{ $precaution ? $precaution->description : old('precaution') }}</textarea>
                                @include('alerts.feedback', ['field' => 'precaution'])
                            </div>
                            <div class="form-group col-md-4">
                                <label>{{ __('Status') }}</label>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="precaution_status"
                                            id="precaution1" value="1"
                                            {{ ($precaution && $precaution->status == 1) || !$precaution ? 'checked' : '' }}>
                                        {{ __('Active') }}
                                        <span class="form-check-sign"></span>
                                    </label>
                                    <label class="form-check-label ms-5">
                                        <input class="form-check-input" type="radio" name="precaution_status"
                                            id="precaution2" value="0"
                                            {{ $precaution && $precaution->status == 0 ? 'checked' : '' }}>
                                        {{ __('Deactive') }}
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary float-end">{{ __('Update') }}</button>
            </form>
        </div>


        {{-- Old Discount Modal  --}}
        <div class="modal discount_modal fade" id="discount_modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Discount Histories') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal_data">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SL') }}</th>
                                    <th>{{ __('Discount Amount') }}</th>
                                    <th>{{ __('Discount Percentage') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Created date') }}</th>
                                    <th>{{ __('Created by') }}</th>
                                    <th>{{ __('Updated date') }}</th>
                                    <th>{{ __('Updated by') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discounts as $discount)
                                    <tr>
                                        <td> {{ $loop->iteration }} </td>
                                        <td> {{ $discount->discount_amount }} </td>
                                        <td> {{ $discount->discount_percentage }} </td>
                                        <td>
                                            <span
                                                class="{{ $discount->getStatusBadgeClass() }}">{{ $discount->getStatus() }}</span>
                                        </td>
                                        <td>{{ timeFormate($discount->created_at) }}</td>
                                        <td> {{ c_user_name($discount->created_user) }} </td>
                                        <td>{{ timeFormate($discount->updated_at) }}</td>
                                        <td> {{ c_user_name($discount->updated_user) }} </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5], 'length' => 10])
@push('js')
    <script>
        $(document).ready(function() {
            $('.pro_cat').on('change', function() {
                let pro_sub_cat = $('.pro_sub_cat');
                let id = $(this).val();
                let url = ("{{ route('product.medicine.sub_cat.medicine_list', ['id']) }}");
                let _url = url.replace('id', id);

                pro_sub_cat.prop('disabled', false);

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
        $(document).ready(function() {
            var checkbox = $('.prescription_required');
            var max_quantity = $('.max_quantity');

            if (checkbox.is(':checked')) {
                max_quantity.prop('disabled', false);
            } else {
                max_quantity.prop('disabled', true);
            }
            checkbox.on('change', function() {
                if (checkbox.is(':checked')) {
                    max_quantity.prop('disabled', false);
                } else {
                    max_quantity.prop('disabled', true);
                }
            });
        })
    </script>
    <script>
        function generateSlug(str) {
            return str
                .toLowerCase()
                .replace(/\s+/g, "-")
                .replace(/[^\w\u0980-\u09FF-]+/g, "") // Allow Bangla characters (\u0980-\u09FF)
                .replace(/--+/g, "-")
                .replace(/^-+|-+$/g, "");
        }
        $(document).ready(function() {
            $("#title").on("keyup", function() {
                const titleValue = $(this).val().trim();
                const slugValue = generateSlug(titleValue);
                $("#slug").val(slugValue);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initially hide discount fields
            $('#discount_percentage, #discount_amount').closest('.form-group').hide();

            // Function to toggle discount fields visibility
            function toggleDiscountFields() {
                var discountValue = $('input[name="exampleRadios"]:checked').val();
                if (discountValue == 1) {
                    $('#discount_percentage, #discount_amount').closest('.form-group').show();
                } else {
                    $('#discount_percentage, #discount_amount').closest('.form-group').hide();
                    $('#discount_percentage, #discount_amount').val('');
                }
            }

            function toggleFieldDisabled() {
                var discountPercentage = $('#discount_percentage').val();
                var discountAmount = $('#discount_amount').val();

                if (discountPercentage !== '' && discountPercentage !== null) {
                    $('#discount_amount').prop('disabled', true);
                } else if (discountAmount !== '' && discountAmount !== null) {
                    $('#discount_percentage').prop('disabled', true);
                } else {
                    $('#discount_amount').prop('disabled', false);
                    $('#discount_percentage').prop('disabled', false);
                }
            }
            // Call the function on page load
            toggleDiscountFields();
            toggleFieldDisabled();

            // Call the function whenever radio button is changed
            $('input[name="exampleRadios"]').change(function() {
                toggleDiscountFields();
                toggleFieldDisabled();
            });
            $('#discount_percentage, #discount_amount').on('input, keyup', function() {
                toggleFieldDisabled();
            });

            $('.unit').on('change', function() {
                var selectedOptions = $(this).find('option:selected'); // Get selected options
                var container = $('#unit-prices-container');
                container.empty();

                if (selectedOptions.length > 0) {
                    selectedOptions.each(function() {
                        var unitId = $(this).val();
                        var unitName = $(this).text().trim();
                        var priceDiv = $('<div class="form-group col-md-6 unit-price-item">');
                        var label = $('<label for="price-unit-' + unitId + '">Price for Unit: ' +
                            unitName + ' (ID: ' + unitId + ')</label>');
                        priceDiv.append(label);

                        var input = $(`
                                    <input type="hidden" class="d-none" id="unit-${unitId}" name="units[${unitId}][id]" value="${unitId}">
                                    <input type="number" class="form-control" id="price-unit-${unitId}" name="units[${unitId}][price]" placeholder="Enter price for ${unitName}" step="0.01">
                        `);
                        priceDiv.append(input);

                        container.append(priceDiv);
                    });
                }
            });
        });
    </script>
@endpush
