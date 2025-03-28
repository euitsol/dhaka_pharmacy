@extends('pharmacy.layouts.master', ['pageSlug' => 'kyc_verification'])
@section('title', 'KYC Verification Center')
@push('css')
    <style>
        .form-group .form-control,
        .input .input-group .form-control {
            padding: 8px 0px 8px 18px;
        }

        .input .input-group .form-control:first-child,
        .input .input-group-btn:first-child>.dropdown-toggle,
        .input .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle) {
            border-right: 1px solid rgba(29, 37, 59, 0.5);
        }

        .input .input-group .form-control:not(:first-child):not(:last-child),
        .input .input-group-btn:not(:first-child):not(:last-child) {
            border-radius: 0;
            border-right: 0;
        }

        .single_page_image {
            position: relative;
        }

        .single_page_image .image_delete {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .single_page_image .image_delete span {
            font-size: 20px;
            padding: 5px 10px;
            width: auto;
        }
    </style>
    @if (!empty($kyc->p_submitted_kyc) && $kyc->p_submitted_kyc->status != -1)
        <style>
            .imagePreviewDiv a {
                display: none;
            }
        </style>
    @endif
@endpush

@php
    $submitted_kyc = isset($kyc->p_submitted_kyc) ? $kyc->p_submitted_kyc : null;
@endphp
@section('content')
    <div class="row">
        <div class="{{ empty($submitted_kyc) || $submitted_kyc->status == -1 ? 'col-8' : 'col-12' }}">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title">{{ __('KYC Verification Center') }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            @if (!empty($submitted_kyc))
                                @if ($submitted_kyc->status === 1)
                                    <span class="badge badge-success">{{ __('Verified') }}</span>
                                @elseif($submitted_kyc->status === 0)
                                    <span class="badge badge-info">{{ __('Pending') }}</span>
                                @elseif($submitted_kyc->status === -1)
                                    <span class="badge badge-danger">{{ __('Declined') }}</span>
                                @endif
                            @else
                                <span class="badge badge-info">{{ __('Pending') }}</span>
                            @endif
                        </div>
                        @if (!empty($submitted_kyc) && $submitted_kyc->status === -1)
                            <div class="col-12">
                                <strong class="text-danger">{{ __('Declined Reason: ') }}</strong>{!! $submitted_kyc->note !!}
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    $disabled = !empty($submitted_kyc) && $submitted_kyc->status !== -1 ? true : false;
                @endphp
                @if (!empty($submitted_kyc) && $submitted_kyc->status == 1)
                    <div class="kyc_varified text-center" style="height: 85vh">
                        <img src="{{ asset('default_img/kyc_varified.svg') }}" width="25%" class="py-5" alt="">
                    </div>
                @else
                    @if (isset($kyc->form_data))
                        <form method="POST" action="{{ route('pharmacy.kyc.store') }}" autocomplete="off"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                @foreach (json_decode($kyc->form_data) as $k => $fd)
                                    @php
                                        $a = $fd->field_key;
                                        $count = 0;
                                    @endphp

                                    @if ($fd->type == 'text')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                                value="{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}">
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'number')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="number"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                                value="{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}">
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'url')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="url"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                                value="{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}">
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'date')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="date"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                                value="{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}">
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'textarea')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <textarea {{ $disabled ? 'disabled' : '' }} name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}">{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}</textarea>
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'image')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="file" accept="image/*"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                                @if (isset($submitted_kyc->submitted_data) &&
                                                        isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                        !empty(json_decode($submitted_kyc->submitted_data))) data-existing-files="{{ storage_url(json_decode($submitted_kyc->submitted_data)->$a) }}"
                                        data-delete-url="{{ route('kyc.file.delete', ['id' => encrypt($submitted_kyc->id), 'key' => $a]) }}" @endif>
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'image_multiple')
                                        @if (isset($submitted_kyc->submitted_data) &&
                                                isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                !empty(json_decode($submitted_kyc->submitted_data)))
                                            @php
                                                $data = collect(json_decode($submitted_kyc->submitted_data, true)[$a]);
                                                $result = '';
                                                if (!empty($data)) {
                                                    $itemCount = count($data);
                                                    foreach ($data as $index => $url) {
                                                        $result .= route('kyc.file.delete', [
                                                            'id' => encrypt($submitted_kyc->id),
                                                            'key' => $a,
                                                            'url' => encrypt($url),
                                                        ]);
                                                        if ($index === $itemCount - 1) {
                                                            $result .= '';
                                                        } else {
                                                            $result .= ', ';
                                                        }
                                                    }
                                                }
                                            @endphp
                                        @endif
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="file" accept="image/*"
                                                name="{{ $fd->field_key }}[]" id="{{ $fd->field_key }}"
                                                class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                                multiple
                                                @if (isset($submitted_kyc->submitted_data) &&
                                                        isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                        !empty(json_decode($submitted_kyc->submitted_data))) data-existing-files="{{ storage_url($data) }}"
                                                data-delete-url="{{ $result }}" @endif>
                                            @include('alerts.feedback', ['field' => $fd->field_key])




                                        </div>
                                    @elseif($fd->type == 'file_single')
                                        <div class="form-group">
                                            <input {{ $disabled ? 'disabled' : '' }} type="hidden"
                                                name="{{ $fd->field_key }}[url]" class="file_url">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif

                                            <div class="input-group mb-3">
                                                <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                    name="{{ $fd->field_key }}[title]"
                                                    class="form-control file_title {{ $errors->has($fd->field_key . '.title') ? 'is-invalid' : '' }}"
                                                    placeholder="{{ __('Enter file name') }}">
                                                <input {{ $disabled ? 'disabled' : '' }} type="file" accept=""
                                                    name="{{ $fd->field_key }}[file]" id="{{ $fd->field_key }}"
                                                    class="form-control fileInput {{ $disabled ? 'disabled' : '' }} {{ $errors->has($fd->field_key . '.url') ? 'is-invalid' : '' }}">
                                            </div>
                                            <div class="d-flex">
                                                <div class="progressBar bg-success"
                                                    style="width: 0%; background: #ddd; height: 20px;"></div>
                                                <span class="cancelBtn"
                                                    style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i
                                                        class="fa-solid fa-xmark"></i></span>
                                            </div>

                                            <div class="show_file">
                                                @if (isset($submitted_kyc->submitted_data) &&
                                                        isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                        !empty(json_decode($submitted_kyc->submitted_data)))
                                                    <div class="form-group">
                                                        <label>{{ __('Uploded file') }}</label>
                                                        <div class="input-group mb-3">
                                                            <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                                class="form-control"
                                                                value="{{ file_title_from_url(json_decode($submitted_kyc->submitted_data)->$a) }}"
                                                                disabled>
                                                            <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                                class="form-control"
                                                                value="{{ file_name_from_url(json_decode($submitted_kyc->submitted_data)->$a) }}"
                                                                disabled>
                                                            @if (!$disabled)
                                                                <a
                                                                    href="{{ route('kyc.file.delete', [
                                                                        'id' => encrypt($submitted_kyc->id),
                                                                        'key' => $a,
                                                                    ]) }}">
                                                                    <span class="input-group-text text-danger h-100"><i
                                                                            class="tim-icons icon-trash-simple"></i></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            @include('alerts.feedback', [
                                                'field' => $fd->field_key . '.url',
                                            ])
                                            @include('alerts.feedback', [
                                                'field' => $fd->field_key . '.title',
                                            ])
                                        </div>
                                    @elseif($fd->type == 'file_multiple')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <div class='temp-input'>
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="{{ $fd->field_key . '[1][title]' }}">
                                                    <input type="hidden" name="{{ $fd->field_key . '[1][url]' }}">
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <input {{ $disabled ? 'disabled' : '' }} type="text" name=""
                                                    class="form-control file_title"
                                                    placeholder="{{ __('Enter file name') }}"
                                                    {{ $errors->has($fd->field_key . '.*.title') ? 'is-invalid' : '' }}>
                                                <input {{ $disabled ? 'disabled' : '' }} type="file" name=""
                                                    id="{{ $fd->field_key }}"
                                                    class="form-control fileInput {{ $disabled ? 'disabled' : '' }} {{ $errors->has($fd->field_key . '.*.url') ? 'is-invalid' : '' }}"
                                                    multiple
                                                    @if (isset($submitted_kyc->submitted_data) &&
                                                            isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                            !empty(json_decode($submitted_kyc->submitted_data))) data-count="{{ collect(json_decode($submitted_kyc->submitted_data)->$a)->count() }}" @else data-count="1" @endif>
                                            </div>


                                            <div class="d-flex">
                                                <div class="progressBar bg-success"
                                                    style="width: 0%; background: #ddd; height: 20px;"></div>
                                                <span class="cancelBtn"
                                                    style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i
                                                        class="fa-solid fa-xmark"></i></span>
                                            </div>

                                            <div class="show_file">
                                                @if (isset($submitted_kyc->submitted_data) &&
                                                        isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                        !empty(json_decode($submitted_kyc->submitted_data)))
                                                    @foreach (json_decode($submitted_kyc->submitted_data)->$a as $url)
                                                        @php
                                                            $count += 1;
                                                        @endphp
                                                        <div class="form-group">
                                                            <label>{{ __('Uploded file - ' . $count) }}</label>
                                                            <div class="input-group mb-3">
                                                                <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                                    class="form-control"
                                                                    value="{{ file_title_from_url($url) }}" disabled>
                                                                <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                                    class="form-control"
                                                                    value="{{ file_name_from_url($url) }}" disabled>
                                                                <input {{ $disabled ? 'disabled' : '' }} type="hidden"
                                                                    class="d-none"
                                                                    name="{{ $fd->field_key }}[{{ $count }}][url]"
                                                                    value="{{ file_name_from_url($url) }}">
                                                                <input {{ $disabled ? 'disabled' : '' }} type="hidden"
                                                                    class="d-none"
                                                                    name="{{ $fd->field_key }}[{{ $count }}][title]"
                                                                    value="{{ file_title_from_url($url) }}">
                                                                @if (!$disabled)
                                                                    <a
                                                                        href="{{ route('kyc.file.delete', [
                                                                            'id' => encrypt($submitted_kyc->id),
                                                                            'key' => $a,
                                                                            'url' => encrypt($url),
                                                                        ]) }}">
                                                                        <span class="input-group-text text-danger h-100"><i
                                                                                class="tim-icons icon-trash-simple"></i></span>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            @include('alerts.feedback', [
                                                'field' => $fd->field_key . '.*.url',
                                            ])
                                            @include('alerts.feedback', [
                                                'field' => $fd->field_key . '.*.title',
                                            ])
                                        </div>
                                    @elseif($fd->type == 'email')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input {{ $disabled ? 'disabled' : '' }} type="email"
                                                name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                                class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}"
                                                value="{{ isset($submitted_kyc->submitted_data) && isset(json_decode($submitted_kyc->submitted_data)->$a) ? json_decode($submitted_kyc->submitted_data)->$a : old($fd->field_key) }}">
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @elseif($fd->type == 'option')
                                        <div class="form-group">
                                            <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                            @if (isset($fd->required) && $fd->required == 'required')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <select {{ $disabled ? 'disabled' : '' }} name="{{ $fd->field_key }}"
                                                id="{{ $fd->field_key }}"
                                                class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}">
                                                <option value=" " selected hidden>
                                                    {{ __('Select ' . $fd->field_name) }}</option>
                                                @foreach ($fd->option_data as $value => $label)
                                                    <option value="{{ $value }}"
                                                        @if (isset($submitted_kyc->submitted_data) &&
                                                                isset(json_decode($submitted_kyc->submitted_data)->$a) &&
                                                                (json_decode($submitted_kyc->submitted_data)->$a == $value || old($fd->field_key) == $value)) selected @endif>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @include('alerts.feedback', ['field' => $fd->field_key])
                                        </div>
                                    @endif
                                @endforeach

                                <div id="message"></div>
                            </div>
                            @if (!$disabled)
                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
                                </div>
                            @endif
                        </form>
                    @endif
                @endif

            </div>
        </div>
        @if (empty($submitted_kyc) || $submitted_kyc->status == -1)
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="card-body">
                        <p class="card-text" style="font-weight: 600;">
                            {{ isset($kyc->documentation) ? __(json_decode($kyc->documentation)->title) : '' }}
                        </p>
                        <div class="card-description content-description">
                            {!! isset($kyc->documentation) ? json_decode($kyc->documentation)->details : '' !!}</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('js_link')
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                let xhr;

                $(document).on("change", ".fileInput {{ $disabled ? 'disabled' : '' }}", function() {
                    const progressBar = $(this).parent().siblings(".d-flex").find(".progressBar");
                    const cancelBtn = $(this).parent().siblings(".d-flex").find(".cancelBtn");
                    const fileUrl = $(this).parent().parent().find(".file_url");
                    const fileTitle = $(this).parent().find(".file_title");
                    const showFile = $(this).parent().siblings(".show_file");
                    const isMultiple = $(this).attr('multiple');
                    if (isMultiple) {
                        $('.temp-input').remove();
                        var count = $(this).data('count');
                        var key = $(this).attr('id');
                        count = count + 1;
                        $(this).data('count', count)
                    }

                    const formData = new FormData();
                    formData.append('file', this.files[0]);

                    xhr = $.ajax({
                        url: "{{ route('pharmacy.kyc.file.upload') }}",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        xhr: function() {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    const percentComplete = (evt.loaded / evt
                                        .total) * 100;
                                    progressBar.css("width", percentComplete +
                                        "%");
                                    cancelBtn.css("display", "block");
                                }
                            }, false);
                            return xhr;
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {

                                alert("File uploaded successfully.");

                                let url = (
                                    "{{ route('kyc.file.delete', ['url' => '_url']) }}"
                                );
                                let _url = url.replace('_url', response
                                    .url);
                                if (isMultiple) {
                                    var file = `<div class="form-group">
                                                <label>{{ __('Uploded file - ${count}') }}</label>
                                                <div class="input-group mb-3">
                                                    <input {{ $disabled ? 'disabled' : '' }} type="text" class="form-control"   value="${set_title(fileTitle.val(),'',response.title)}" disabled>
                                                    <input {{ $disabled ? 'disabled' : '' }} type="text" class="form-control"  value="${set_title(fileTitle.val(), response.extension, response.title)}" disabled>
                                                    <input {{ $disabled ? 'disabled' : '' }} type="hidden" class="d-none" name="${key}[${count}][url]" value="${response.file_path}">
                                                    <input {{ $disabled ? 'disabled' : '' }} type="hidden" class="d-none" name="${key}[${count}][title]" value="${set_title(fileTitle.val(),'',response.title)}">
                                                    <a href="${_url}">
                                                        <span class="input-group-text text-danger h-100 delete_file"><i class="tim-icons icon-trash-simple"></i></span>
                                                    </a>
                                                </div>
                                            </div>`;
                                    showFile.append(file);

                                } else {
                                    fileUrl.val(response.file_path);
                                    var file = `<div class="form-group">
                                                <label>{{ __('Uploded file') }}</label>
                                                <div class="input-group mb-3">
                                                    <input {{ $disabled ? 'disabled' : '' }} type="text" class="form-control" value="${set_title(fileTitle.val(),'',response.title)}" disabled>
                                                    <input {{ $disabled ? 'disabled' : '' }} type="text" class="form-control" value="${set_title(fileTitle.val(), response.extension,response.title)}" disabled>
                                                    <a href="${_url}">
                                                        <span class="input-group-text text-danger h-100 delete_file"><i class="tim-icons icon-trash-simple"></i></span>
                                                    </a>
                                                </div>
                                            </div>`;
                                    showFile.html(file);

                                }

                            } else {
                                alert("Failed to upload file. Please try again.");
                            }
                            progressBar.css("width", "0%");
                            cancelBtn.css("display", "none");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert("Failed to upload file: " + textStatus);
                            progressBar.css("width", "0%");
                            cancelBtn.css("display", "none");
                        }
                    });
                });

                $(document).on("click", ".cancelBtn", function() {
                    if (xhr && xhr.readyState !== 4) {
                        xhr.abort();
                        alert("File upload canceled.");
                        $(this).siblings(".progressBar").css("width", "0%");
                        $(this).siblings(".cancelBtn").css("display", "none");
                    }
                });


                $(document).on("click", ".delete_file", function(e) {
                    e.preventDefault();


                    let url = $(this).parent().attr('href');
                    let this_ = $(this);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            this_.closest('.show_file').siblings(
                                '.input-group').find('.fileInput').val('')
                            this_.closest('.form-group').remove();
                            toastr.success(data.message);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching admin data:', error);
                        }
                    });

                });
            });
        });

        function set_title(input_val, extension = '', prev_val = $('.title').html()) {
            if (input_val != null && input_val != '') {
                return input_val + ((extension === '') ? '' : '.' + extension);
            } else {
                return prev_val + ((extension === '') ? '' : '.' + extension);
            }
        }
    </script>
@endpush
