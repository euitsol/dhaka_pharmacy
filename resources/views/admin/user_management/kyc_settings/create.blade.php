@extends('admin.layouts.master', ['pageSlug' => 'user_kyc_settings'])

@section('title', 'KYC Settings')
@push('css')
    <style>
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="{{ $document->title ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('User KYC Settings') }}</h5>
                </div>
                <form method="POST" action="{{ route('um.user_kyc.user_kyc_settings') }}" autocomplete="off">
                    @csrf
                    {{-- @foreach ($kyc_setting as $key => $setting) --}}
                    <div class="card-body">
                        
                        <div class="d-flex mb-3">
                            <div class="form-check form-check-radio me-3">
                                <label class="form-check-label" for="exampleRadios1">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                        value="1" {{ optional($kyc_setting)->status == 1 ? 'checked' : '' }}> ON
                                    <span class="form-check-sign"></span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label" for="exampleRadios2">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                        value="2" {{ optional($kyc_setting)->status == 2 ? 'checked' : '' }}> OFF
                                    <span class="form-check-sign"></span>
                                </label>
                            </div>
                            @include('alerts.feedback', ['field' => 'status'])
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="m-0">Input Fields</label>
                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded p-6 ml-4 generate_atf"
                                data-count="{{ isset($kyc_setting->form_data) && null !== json_decode($kyc_setting->form_data) ? count(json_decode($kyc_setting->form_data, true)) : '1' }}"><i
                                    class="fa fa-plus-circle"></i>
                                {{ trans('Add Field') }}
                            </a>

                        </div>
                        <div class="card-body">
                            @if (isset($kyc_setting->form_data) && null !== json_decode($kyc_setting->form_data))
                                @php
                                    $count = 1
                                @endphp
                                @foreach (json_decode($kyc_setting->form_data, true) as $key => $data)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input name="formdata[{{ $count }}][field_name]"
                                                        class="form-control " type="text"
                                                        value="{{ $data['field_name'] }}" required>

                                                    <select name="formdata[{{ $count }}][type]"
                                                        class="form-control form-data">
                                                        <option value="text"
                                                            {{ $data['type'] == 'text' ? 'selected' : '' }}>
                                                            {{ trans('Input Text') }}</option>
                                                        <option value="number"
                                                            {{ $data['type'] == 'number' ? 'selected' : '' }}>
                                                            {{ trans('Input Number') }}</option>
                                                        <option value="url"
                                                            {{ $data['type'] == 'url' ? 'selected' : '' }}>
                                                            {{ trans('Input URL') }}</option>
                                                        <option value="email"
                                                            {{ $data['type'] == 'email' ? 'selected' : '' }}>
                                                            {{ trans('Email') }}</option>
                                                        <option value="date"
                                                            {{ $data['type'] == 'date' ? 'selected' : '' }}>
                                                            {{ trans('Date') }}</option>
                                                        <option value="option"
                                                            {{ $data['type'] == 'option' ? 'selected' : '' }}>
                                                            {{ trans('Option') }}</option>
                                                        <option value="textarea"
                                                            {{ $data['type'] == 'textarea' ? 'selected' : '' }}>
                                                            {{ trans('Textarea') }}</option>
                                                        <option value="image"
                                                            {{ $data['type'] == 'image' ? 'selected' : '' }}>
                                                            {{ trans('Image') }}</option>
                                                        <option value="image_multiple"
                                                            {{ $data['type'] == 'image_multiple' ? 'selected' : '' }}>
                                                            {{ trans('Multiple Image') }}</option>
                                                        <option value="file_single"
                                                            {{ $data['type'] == 'file_single' ? 'selected' : '' }}>
                                                            {{ trans('File Single') }}</option>
                                                        <option value="file_multiple"
                                                            {{ $data['type'] == 'file_multiple' ? 'selected' : '' }}>
                                                            {{ trans('File Multiple') }}</option>
                                                    </select>

                                                    <select name="formdata[{{ $count }}][required]"
                                                        class="form-control  ">
                                                        <option value="required"
                                                            {{ $data['required'] == 'required' ? 'selected' : '' }}>
                                                            {{ trans('Required') }}</option>
                                                        <option value="nullable"
                                                            {{ $data['required'] == 'nullable' ? 'selected' : '' }}>
                                                            {{ trans('Optional') }}</option>
                                                    </select>

                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger delete_desc" type="button"
                                                            style=" margin-top: 0px; padding-bottom: 8px;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                                @php
                                                    if($data['type'] == 'option'){
                                                        $option_data = $data['option_data'];
                                                        $string = implode('; ', array_map(function ($key, $value) {
                                                            return "$key = $value";
                                                        }, array_keys($option_data), $option_data));
                                                    }
                                                @endphp
                                            <div class="form-group select_option"
                                                style="{{ $data['type'] == 'option' ? 'display:block' : 'display:none' }}">
                                                <label>Add select fields option and values (value = option) <small>(Eg. 0 =
                                                        Off; 1 = On)</small> </label>
                                                <textarea class="form-control" name="formdata[{{ $count }}][option_data]">{{($data['type'] == 'option') ? $string : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $count++
                                    @endphp
                                @endforeach
                            @endif
                            <div class="row addedField"> </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation'['document'=>$document])
    </div>
@endsection

@push('js_link')
    <script>
        'use script'
        $(document).on('click', '.generate_atf', function() {
            let count = $(this).data('count') + 1;
            $(this).data('count', count);
            var form = `<div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <input name="formdata[${count}][field_name]" class="form-control " type="text" value="" required placeholder="{{ trans('Field Name') }}">

                                    <select name="formdata[${count}][type]"  class="form-control form-data">
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

                                    <select name="formdata[${count}][required]"  class="form-control  ">
                                        <option value="required">{{ trans('Required') }}</option>
                                        <option value="nullable">{{ trans('Optional') }}</option>
                                    </select>

                                    <span class="input-group-btn">
                                        <button class="btn btn-danger delete_desc" type="button" style=" margin-top: 0px; padding-bottom: 8px;">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group select_option" style="display:none">
                                <label>Add select fields option and values (value = option) <small>(Eg. 0 = Off; 1 = On)</small> </label>
                                <textarea class="form-control" name="formdata[${count}][option_data]"></textarea>
                            </div>
                        </div>
                        `;

            // $('.addedField').append(form);
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
