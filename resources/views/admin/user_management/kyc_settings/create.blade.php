@extends('admin.layouts.master', ['pageSlug' => 'kyc_settings'])

@section('title', 'KYC Settings')
@push('css')
    <style>
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ _('KYC Settings') }}</h5>
                </div>
                <form method="POST" action="{{route('um.user_kyc.kyc_settings_update')}}" autocomplete="off">
                    @csrf
                    @forelse($kyc_settings as $key=>$setting)
                        <div class="card-body">
                            @include('alerts.success')
                            <div class="d-flex mb-3">
                                <div class="form-check form-check-radio me-3">
                                    <label class="form-check-label" for="exampleRadios{{$key}}">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios{{$key}}"
                                            value="1" {{($setting->status == 1) ? 'checked' : '' }} > ON
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label" for="exampleRadios{{$key+1}}">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios{{$key+1}}"
                                            value="2" {{($setting->status == 2) ? 'checked' : '' }} > OFF
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>{{__('Type')}}</label>
                                <select name="type" class="form-control">
                                    <option value="user" {{($setting->type == "user") ? 'selected' : '' }}>{{__('User')}}</option>
                                    <option value="rider" {{($setting->type == "rider") ? 'selected' : '' }}>{{__('Rider')}}</option>
                                    <option value="pharmacy" {{($setting->type == "pharmacy") ? 'selected' : '' }}>{{__('Pharmacy')}}</option>
                                    <option value="doctor" {{($setting->type == "doctor") ? 'selected' : '' }}>{{__('Doctor')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <label class="m-0">Input Fields</label>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded p-6 ml-4 generate_atf"
                                    data-count="{{count(json_decode($setting->form_data, true))}}"><i class="fa fa-plus-circle"></i>
                                    {{ trans('Add Field') }}
                                </a>

                            </div>
                            <div class="card-body">
                                @if(null !== (json_decode($setting->form_data)))
                                    @foreach(json_decode($setting->form_data, true) as $key=>$data)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input name="formdata[{{$key+1}}][field_name]" class="form-control " type="text" value="{{$data['field_name']}}" required>
                
                                                    <select name="formdata[{{$key+1}}][type]"  class="form-control form-data">
                                                        <option value="text" {{($data['type'] == 'text') ? 'selected' : ''}}>{{ trans('Input Text') }}</option>
                                                        <option value="number" {{($data['type'] == 'number') ? 'selected' : ''}}>{{ trans('Input Number') }}</option>
                                                        <option value="url" {{($data['type'] == 'url') ? 'selected' : ''}}>{{ trans('Input URL') }}</option>
                                                        <option value="email" {{($data['type'] == 'email') ? 'selected' : ''}}>{{ trans('Email') }}</option>
                                                        <option value="date" {{($data['type'] == 'date') ? 'selected' : ''}}>{{ trans('Date') }}</option>
                                                        <option value="option" {{($data['type'] == 'option') ? 'selected' : ''}}>{{ trans('Option') }}</option>
                                                        <option value="textarea" {{($data['type'] == 'textarea') ? 'selected' : ''}}>{{ trans('Textarea') }}</option>
                                                        <option value="image" {{($data['type'] == 'image') ? 'selected' : ''}}>{{ trans('Image') }}</option>
                                                        <option value="image_multiple" {{($data['type'] == 'image_multiple') ? 'selected' : ''}}>{{ trans('Multiple Image') }}</option>
                                                        <option value="file_single" {{($data['type'] == 'file_single') ? 'selected' : ''}}>{{ trans('File Single') }}</option>
                                                        <option value="file_multiple" {{($data['type'] == 'file_multiple') ? 'selected' : ''}}>{{ trans('File Multiple') }}</option>
                                                    </select>
                
                                                    <select name="formdata[{{$key+1}}][required]"  class="form-control  ">
                                                        <option value="required" {{$data['required'] == "required" ? "selected" : ''}}>{{ trans('Required') }}</option>
                                                        <option value="nullable" {{$data['required'] == "nullable" ? "selected" : ''}}>{{ trans('Optional') }}</option>
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
                                    </div>
                                    @endforeach
                                @endif
                                <div class="row addedField"> </div>

                                
                            </div>
                        </div>
                    @empty
                        <div class="card-body">
                            @include('alerts.success')
                            <div class="d-flex mb-3">
                                <div class="form-check form-check-radio me-3">
                                    <label class="form-check-label" for="exampleRadios{{counte($kyc_settings)+1}}">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios{{counte($kyc_settings)+1}}"
                                            value="1" checked=""> ON
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                                <div class="form-check form-check-radio">
                                    <label class="form-check-label" for="exampleRadios{{count($kyc_settings)+2}}">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios{{count($kyc_settings)+2}}"
                                            value="2" > OFF
                                        <span class="form-check-sign"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label>{{__('Type')}}</label>
                                <select name="type" class="form-control">
                                    <option selected hidden>{{__('Select Type')}}</option>
                                    <option value="user">{{__('User')}}</option>
                                    <option value="rider">{{__('Rider')}}</option>
                                    <option value="pharmacy">{{__('Pharmacy')}}</option>
                                    <option value="doctor">{{__('Doctor')}}</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <label class="m-0">Input Fields</label>
                                <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded p-6 ml-4 generate_atf"
                                    data-count="0"><i class="fa fa-plus-circle"></i>
                                    {{ trans('Add Field') }}
                                </a>

                            </div>
                            <div class="card-body">
                                <div class="row addedField">

                                </div>
                            </div>
                        </div>
                    @endforelse
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        {{ _('Blog') }}
                    </p>
                    <div class="card-description">
                        {{ _('The role\'s manages user permissions by assigning different roles to users. Each role defines specific access levels and actions a user can perform. It helps ensure proper authorization and security in the system.') }}
                    </div>
                </div>
            </div>
        </div>
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
