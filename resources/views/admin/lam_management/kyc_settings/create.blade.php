@extends('admin.layouts.master', ['pageSlug' => 'lam_kyc_settings'])
@section('title', 'Create Local Area Manager KCY')
@push('css_link')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Create Local Area Manager KYC') }}</h5>
                </div>
                <form method="POST" action="{{ route('lam_management.lam_kyc.settings.lam_kyc_create') }}" autocomplete="off">
                    @csrf
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <input type="checkbox" value="1" {{ old('status') == 1 ? 'checked' : '' }}
                                class="valueToggle" name='status' data-toggle="toggle" data-onlabel="Active"
                                data-offlabel="Deactive" data-onstyle="success" data-offstyle="danger" data-style="ios">
                            @include('alerts.feedback', ['field' => 'status'])
                        </div>

                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <label class="m-0">{{ __('KYC Requirements') }}</label>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded p-6 ml-4 generate_atf"
                                    data-count="1"><i class="fa fa-plus-circle"></i>
                                    {{ trans('Add Field') }}
                                </a>

                            </div>
                            <div class="card-body">
                                <div class="row addedField"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
@endsection
@push('js_link')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
@endpush
@push('js')
    <script>
        'use script'
        $(document).on('click', '.generate_atf', function() {
            let count = $(this).data('count') + 1;
            $(this).data('count', count);
            var form = `<div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="formdata[${count}][field_name]" class="form-control " type="text" value="" required placeholder="{{ trans('Field Name') }}">

                                    <select name="formdata[${count}][type]"  class="form-control form-data no-select">
                                        <option value="text">{{ trans('Input Text') }}</option>
                                        <option value="number">{{ trans('Input Number') }}</option>
                                        <option value="url">{{ trans('Input URL') }}</option>
                                        <option value="email">{{ trans('Email') }}</option>
                                        <option value="date">{{ trans('Date') }}</option>
                                        <option value="option">{{ trans('Option') }}</option>
                                        <option value="textarea">{{ trans('Textarea') }}</option>
                                        <option value="image">{{ trans('Image') }}</option>
                                        <option value="image_multiple">{{ trans('Multiple Image') }}</option>
                                        <option value="file_single">{{ trans('File Single') }}</option>
                                        <option value="file_multiple">{{ trans('File Multiple') }}</option>
                                    </select>

                                    <select name="formdata[${count}][required]"  class="form-control no-select">
                                        <option value="required">{{ trans('Required') }}</option>
                                        <option value="nullable">{{ trans('Optional') }}</option>
                                    </select>

                                    <button class="btn btn-danger delete_desc" type="button" style=" margin-top: 0px; padding-bottom: 8px;">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group select_option" style="display:none">
                                <label>Add select fields option and values (value = option) <small>(Eg. 0 = Off; 1 = On)</small> </label>
                                <textarea class="form-control" name="formdata[${count}][option_data]"></textarea>
                            </div>
                        </div>
                        `;

            $(this).closest('.card').find('.addedField').append(form);
        });

        $(document).on('click', '.delete_desc', function() {
            $(this).closest('.input-group').parent().remove();
        });

        $(document).on('change', '.form-data', function() {
            var selectedType = $(this).val();
            var optionInputs = $(this).closest('.col-md-12').find('.select_option');
            if (selectedType === 'option') {
                optionInputs.show();
            } else {
                optionInputs.hide();
            }
        });
    </script>
@endpush
