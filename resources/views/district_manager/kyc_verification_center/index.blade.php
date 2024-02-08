@extends('district_manager.layouts.master', ['pageSlug' => 'kyc_verification'])
@push('css')
<style>
    .form-group .form-control, .input-group .form-control {
    padding: 8px 0px 10px 18px;
    }
    .input-group .form-control:first-child, .input-group-btn:first-child>.dropdown-toggle, .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle) {
        border-right: 1px solid rgba(29, 37, 59, 0.5);
    }
    .input-group .form-control:not(:first-child):not(:last-child), .input-group-btn:not(:first-child):not(:last-child) {
        border-radius: 0;
        border-right: 0;
    }
    .single_page_image{
        position: relative;
    }
    .single_page_image .image_delete{
        position: absolute;
        top: 20px;
        right: 20px;
    }
    .single_page_image .image_delete span{
        font-size: 20px;
        padding: 5px 10px;
        width: auto;
    }
</style>
@endpush


@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('KYC Verification Center') }}</h5>
                </div>
                <form method="POST" action="{{route('dm.kyc.store')}}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @include('alerts.success')
                        @if($details->form_data)
							@foreach(json_decode($details->form_data) as $k => $fd)
                            @php
                                $a = $fd->field_key;
                                $count = 0;
                            @endphp

                                @if($fd->type == "text")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="text" name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}" value="{{ json_decode($datas->submitted_data)->$a ?? old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "number")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="number" name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}" value="{{ json_decode($datas->submitted_data)->$a ?? old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "url")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="url" name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}" value="{{ json_decode($datas->submitted_data)->$a ?? old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "textarea")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <textarea name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}">
                                            {{ json_decode($datas->submitted_data)->$a ?? old($fd->field_key) }}
                                        </textarea>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "image")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="file" accept="image/*" name="{{$fd->field_key}}" id="{{$fd->field_key}}"
                                        class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                        @if(!empty(json_decode($datas->submitted_data)) && isset(json_decode($datas->submitted_data)->$a))
                                        data-existing-files="{{ storage_url(json_decode($datas->submitted_data)->$a) }}"
                                        data-delete-url="{{route('dm.kyc.file.delete', [$details->id, $a])}}"
                                        @endif
                                        >
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "image_multiple")
                                    @if(isset(json_decode($datas->submitted_data)->$a) && !empty(json_decode($datas->submitted_data)))
                                    @php
                                        $data = collect(json_decode($datas->submitted_data, true)[$a]);
                                        $result = '';
                                        $itemCount = count($data);
                                        foreach ($data as $index => $url) {
                                            $result .= route('dm.kyc.file.delete', [$details->id, $a, base64_encode($url)]);
                                            if($index === $itemCount - 1) {
                                                $result .= '';
                                            }else{
                                                $result .= ', ';
                                            }
                                        }
                                    @endphp
                                    @endif
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="file" accept="image/*" name="{{$fd->field_key}}[]" id="{{$fd->field_key}}"
                                        class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                        multiple
                                            @if(!empty(json_decode($datas->submitted_data)) && isset(json_decode($datas->submitted_data)->$a))
                                                data-existing-files="{{ storage_url($data) }}"
                                                data-delete-url="{{ $result }}"

                                            @endif
                                        >
                                        @include('alerts.feedback', ['field' => $fd->field_key])




                                    </div>
                                @elseif($fd->type == "file_single")

                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <input type="hidden" name="{{$fd->field_key}}[url]" class="file_url">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif

                                        <div class="input-group mb-3">
                                            <input type="text" name="{{$fd->field_key}}[title]" class="form-control file_title" placeholder="{{ _('Enter file name') }}" >
                                            <input type="file" accept="" name="{{$fd->field_key}}[file]" id="{{$fd->field_key}}" class="form-control fileInput {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}">
                                        </div>


                                        <div class="d-flex">
                                            <div class="progressBar bg-success" style="width: 0%; background: #ddd; height: 20px;"></div>
                                            <span class="cancelBtn"  style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i class="fa-solid fa-xmark"></i></span>
                                        </div>

                                        <div class="show_file">
                                            @if(!empty(json_decode($datas->submitted_data)) && isset(json_decode($datas->submitted_data)->$a))
                                            <div class="form-group">
                                                <label>{{ _('Uploded file') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" value="{{file_title_from_url(json_decode($datas->submitted_data)->$a)}}" disabled>
                                                    <input type="text" class="form-control" value="{{file_name_from_url(json_decode($datas->submitted_data)->$a)}}" disabled>
                                                    <a href="{{route('dm.kyc.file.delete', [$details->id, $a])}}">
                                                        <span class="input-group-text text-danger h-100"><i class="tim-icons icon-trash-simple"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>

                                @elseif($fd->type == "file_multiple")

                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif

                                        <div class="input-group mb-3">
                                            <input type="text" name="" class="form-control file_title" placeholder="{{ _('Enter file name') }}" >
                                            <input type="file" name="" id="{{$fd->field_key}}" class="form-control fileInput {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}" multiple @if(isset(json_decode($datas->submitted_data)->$a) && !empty(json_decode($datas->submitted_data)) ) data-count="{{collect(json_decode($datas->submitted_data)->$a)->count()}}" @else data-count="1" @endif>
                                        </div>


                                        <div class="d-flex">
                                            <div class="progressBar bg-success" style="width: 0%; background: #ddd; height: 20px;"></div>
                                            <span class="cancelBtn"  style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i class="fa-solid fa-xmark"></i></span>
                                        </div>

                                        <div class="show_file">
                                            @if(isset(json_decode($datas->submitted_data)->$a) && !empty(json_decode($datas->submitted_data)))
                                            @foreach(json_decode($datas->submitted_data)->$a as $url)
                                                @php
                                                    $count += 1
                                                @endphp
                                                <div class="form-group">
                                                    <label>{{ _('Uploded file - '.$count) }}</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control"   value="{{ file_title_from_url($url) }}" disabled>
                                                        <input type="text" class="form-control"  value="{{ file_name_from_url($url) }}" disabled>
                                                        <input type="hidden" class="d-none" name="{{$fd->field_key}}[{{$count}}][url]" value="{{ file_name_from_url($url) }}">
                                                        <input type="hidden" class="d-none" name="{{$fd->field_key}}[{{$count}}][title]" value="{{ file_title_from_url($url) }}">
                                                        <a href="{{route('dm.kyc.file.delete', [$details->id, $a, base64_encode($url)])}}">
                                                            <span class="input-group-text text-danger h-100"><i class="tim-icons icon-trash-simple"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == "email")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input type="email" name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}" value="{{ json_decode($datas->submitted_data)->$a ?? old($fd->field_key) }}" >
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>

                                @elseif($fd->type == "option")
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{$fd->field_key}}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <select  name="{{$fd->field_key}}" id="{{$fd->field_key}}" class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}" >
                                            @foreach ($fd->option_data as $value=>$label)

                                                <option value="{{$value}}" @if(isset(json_decode($datas->submitted_data)->$a) && (json_decode($datas->submitted_data)->$a == $value || old($fd->field_key) == $value)) selected @endif >{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @endif

							@endforeach
						@endif
                        <div id="message"></div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ _('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text" style="font-weight: 600;">
                        {{ _(json_decode($details->documentation)->title ?? '') }}
                    </p>
                    <div class="card-description content-description">
                        {!! _(json_decode($details->documentation)->details ?? '') !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_link')
<script>
    $(document).ready(function () {
        $(document).ready(function () {
        let xhr;

            $(document).on("change", ".fileInput", function () {
                const progressBar = $(this).parent().siblings(".d-flex").find(".progressBar");
                const cancelBtn = $(this).parent().siblings(".d-flex").find(".cancelBtn");
                const fileUrl = $(this).parent().parent().find(".file_url");
                const fileTitle = $(this).parent().find(".file_title");
                const showFile = $(this).parent().siblings(".show_file");
                const isMultiple = $(this).attr('multiple');
                if(isMultiple){
                    var count = $(this).data('count');
                    var key = $(this).attr('id');
                    count = count + 1;
                    $(this).data('count', count)
                }

                const formData = new FormData();
                formData.append('file', this.files[0]);

                xhr = $.ajax({
                    url: "{{ route('dm.kyc.file.upload') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhr: function () {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                const percentComplete = (evt.loaded / evt.total) * 100;
                                progressBar.css("width", percentComplete + "%");
                                cancelBtn.css("display", "block");
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.success) {

                            alert("File uploaded successfully.");

                            let url = ("{{ route('dm.kyc.file.delete', ['url']) }}");
                            let _url = url.replace('url', response.url);
                            if(isMultiple){
                                var file = `<div class="form-group">
                                                <label>{{ _('Uploded file - ${count}') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control"   value="${set_title(fileTitle.val(),'',response.title)}" disabled>
                                                    <input type="text" class="form-control"  value="${set_title(fileTitle.val(), response.extension, response.title)}" disabled>
                                                    <input type="hidden" class="d-none" name="${key}[${count}][url]" value="${response.file_path}">
                                                    <input type="hidden" class="d-none" name="${key}[${count}][title]" value="${set_title(fileTitle.val(),'',response.title)}">
                                                    <a href="${_url}">
                                                        <span class="input-group-text text-danger h-100 delete_file"><i class="tim-icons icon-trash-simple"></i></span>
                                                    </a>
                                                </div>
                                            </div>`;
                                showFile.append(file);

                            }else{
                                fileUrl.val(response.file_path);
                                var file = `<div class="form-group">
                                                <label>{{ _('Uploded file') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" value="${set_title(fileTitle.val(),'',response.title)}" disabled>
                                                    <input type="text" class="form-control" value="${set_title(fileTitle.val(), response.extension,response.title)}" disabled>
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
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Failed to upload file: " + textStatus);
                        progressBar.css("width", "0%");
                        cancelBtn.css("display", "none");
                    }
                });
            });

            $(document).on("click", ".cancelBtn", function () {
                if (xhr && xhr.readyState !== 4) {
                    xhr.abort();
                    alert("File upload canceled.");
                    $(this).siblings(".progressBar").css("width", "0%");
                    $(this).siblings(".cancelBtn").css("display", "none");
                }
            });


            $(document).on("click", ".delete_file", function (e) {
                e.preventDefault();
            });
        });
    });

    function set_title(input_val, extension = '', prev_val = $('.title').html()){
        if(input_val != null && input_val != ''){
            return input_val + ((extension === '') ? '' : '.' + extension);
        }else{
            return prev_val + ((extension === '') ? '' : '.' + extension);
        }
    }
</script>
@endpush
