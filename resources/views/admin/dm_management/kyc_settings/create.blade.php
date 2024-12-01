@extends('admin.layouts.master', ['pageSlug' => 'dm_kyc_settings'])
@section('title', 'District Manager KCY Setting')
@push('css_link')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header d-flex flex-row align-items-center justify-content-between">
                    <h5 class="title">{{ __('District Manager KYC Setting') }}</h5>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm history">{{ __('KYC History') }}</a>
                </div>
                <form method="POST" action="{{ route('dm_management.dm_kyc.settings.dm_kyc_create') }}" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <label class="m-0">{{ __('KYC Requirements') }}</label>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded p-6 ml-4 generate_atf"
                                    data-count="{{ isset($kyc_setting->form_data) && null !== json_decode($kyc_setting->form_data) ? count(json_decode($kyc_setting->form_data, true)) : 1 }}"><i
                                        class="fa fa-plus-circle"></i>
                                    {{ trans('Add Field') }}
                                </a>

                            </div>
                            <div class="card-body">
                                @if (isset($kyc_setting->form_data) && null !== json_decode($kyc_setting->form_data))
                                    @php
                                        $count = 1;
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
                                                            class="form-control form-data no-select">
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
                                                            class="form-control no-select">
                                                            <option value="required"
                                                                {{ $data['required'] == 'required' ? 'selected' : '' }}>
                                                                {{ trans('Required') }}</option>
                                                            <option value="nullable"
                                                                {{ $data['required'] == 'nullable' ? 'selected' : '' }}>
                                                                {{ trans('Optional') }}</option>
                                                        </select>
                                                        <button class="btn btn-danger delete_desc" type="button"
                                                            style=" margin-top: 0px; padding-bottom: 8px;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @php
                                                    if ($data['type'] == 'option') {
                                                        $option_data = $data['option_data'];
                                                        $string = implode(
                                                            '; ',
                                                            array_map(
                                                                function ($key, $value) {
                                                                    return "$key = $value";
                                                                },
                                                                array_keys($option_data),
                                                                $option_data,
                                                            ),
                                                        );
                                                    }
                                                @endphp
                                                <div class="form-group select_option"
                                                    style="{{ $data['type'] == 'option' ? 'display:block' : 'display:none' }}">
                                                    <label>Add select fields option and values (value = option) <small>(Eg.
                                                            0 =
                                                            Off; 1 = On)</small> </label>
                                                    <textarea class="form-control" name="formdata[{{ $count }}][option_data]">{{ $data['type'] == 'option' ? $string : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                @endif
                                <div class="row addedField"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>
    {{-- KYC History Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('KYC History') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Created date') }}</th>
                                <th>{{ __('Created by') }}</th>
                                <th>{{ __('Updated date') }}</th>
                                <th>{{ __('Updated by') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kycs as $kyc)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ Str::ucfirst($kyc->type) }} </td>
                                    <td>
                                        <span class="{{ $kyc->getStatusBadgeClass() }}">{{ $kyc->getStatus() }}</span>
                                    </td>
                                    <td>{{ timeFormate($kyc->created_at) }}</td>
                                    <td> {{ c_user_name($kyc->created_user) }}</td>
                                    <td>{{ $kyc->created_at != $kyc->updated_at ? timeFormate($kyc->updated_at) : 'Null' }}
                                    </td>
                                    <td> {{ u_user_name($kyc->updated_user) }}</td>
                                    <td>
                                        @include('admin.partials.action_buttons', [
                                            'menuItems' => [
                                                [
                                                    'routeName' => 'dm_management.dm_kyc.settings.dm_kyc_details',
                                                    'params' => encrypt($kyc->id),
                                                    'label' => 'Details',
                                                ],
                                            ],
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4, 5, 6]])
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
    <script>
        $(document).ready(function() {
            $('.history').on('click', function() {
                $('.view_modal').modal('show');
            });
        });
    </script>
@endpush
