@extends('district_manager.layouts.master', ['pageSlug' => 'kyc_verification'])
@push('css')
    <link rel="stylesheet" href="{{ asset('dm/css/kyc.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title">{{ __('KYC Verification Center') }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            @if (!empty($datas) && $datas->status === 1)
                                <span class="badge badge-success">{{ __('Accepted') }}</span>
                            @elseif(!empty($datas) && $datas->status === 0)
                                <span class="badge badge-info">{{ __('Pending') }}</span>
                            @elseif(!empty($datas) && $datas->status === null)
                                <span class="badge badge-danger">{{ __('Declined') }}</span>
                            @elseif(empty($datas))
                                <span class="badge badge-warning">{{ __('Empty') }}</span>
                            @endif
                        </div>
                        @if (!empty($datas) && $datas->status === null)
                            <div class="col-12">
                                <strong class="text-danger">{{ __('Declined Reason: ') }}</strong>{!! $datas->note !!}
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    if (isset($datas->status) && $datas->status !== null) {
                        $disabled = true;
                    } else {
                        $disabled = false;
                    }
                @endphp
                @if (isset($details->form_data))
                    <form method="POST" action="{{ route('dm.kyc.store') }}" autocomplete="off"
                        enctype="multipart/form-data" disabled>


                        @csrf
                        <div class="card-body">
                            @foreach (json_decode($details->form_data) as $k => $fd)
                                @php
                                    $a = $fd->field_key;
                                    $count = 0;
                                @endphp

                                @if ($fd->type == 'text')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="text"
                                            name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                            value="{{ isset($datas->submitted_data) ? json_decode($datas->submitted_data)->$a : old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'number')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="number"
                                            name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                            value="{{ isset($datas->submitted_data) ? json_decode($datas->submitted_data)->$a : old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'url')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="url"
                                            name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}"
                                            value="{{ isset($datas->submitted_data) ? json_decode($datas->submitted_data)->$a : old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'textarea')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <textarea {{ $disabled ? 'disabled' : '' }} name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control title {{ $errors->has($fd->field_key) ? ' is-invalid' : '' }}">{{ isset($datas->submitted_data) ? json_decode($datas->submitted_data)->$a : old($fd->field_key) }}</textarea>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'image')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="file" accept="image/*"
                                            name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                            @if (isset($datas->submitted_data) &&
                                                    isset(json_decode($datas->submitted_data)->$a) &&
                                                    !empty(json_decode($datas->submitted_data))) data-existing-files="{{ storage_url(json_decode($datas->submitted_data)->$a) }}"
                                        data-delete-url="{{ route('dm.kyc.file.delete', [$details->id, $a]) }}" @endif>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'image_multiple')
                                    @if (isset($datas->submitted_data) &&
                                            isset(json_decode($datas->submitted_data)->$a) &&
                                            !empty(json_decode($datas->submitted_data)))
                                        @php
                                            $data = collect(json_decode($datas->submitted_data, true)[$a]);
                                            $result = '';
                                            if (!empty($data)) {
                                                $itemCount = count($data);
                                                foreach ($data as $index => $url) {
                                                    $result .= route('dm.kyc.file.delete', [
                                                        $details->id,
                                                        $a,
                                                        base64_encode($url),
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
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="file" accept="image/*"
                                            name="{{ $fd->field_key }}[]" id="{{ $fd->field_key }}"
                                            class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }} image-upload"
                                            multiple
                                            @if (isset($datas->submitted_data) &&
                                                    isset(json_decode($datas->submitted_data)->$a) &&
                                                    !empty(json_decode($datas->submitted_data))) data-existing-files="{{ storage_url($data) }}"
                                                data-delete-url="{{ $result }}" @endif>
                                        @include('alerts.feedback', ['field' => $fd->field_key])




                                    </div>
                                @elseif($fd->type == 'file_single')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <input {{ $disabled ? 'disabled' : '' }} type="hidden"
                                            name="{{ $fd->field_key }}[url]" class="file_url">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif

                                        <div class="input-group mb-3">
                                            <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                name="{{ $fd->field_key }}[title]" class="form-control file_title"
                                                placeholder="{{ _('Enter file name') }}">
                                            <input {{ $disabled ? 'disabled' : '' }} type="file" accept=""
                                                name="{{ $fd->field_key }}[file]" id="{{ $fd->field_key }}"
                                                class="form-control fileInput {{ $disabled ? 'disabled' : '' }} {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}">
                                        </div>


                                        <div class="d-flex">
                                            <div class="progressBar bg-success"
                                                style="width: 0%; background: #ddd; height: 20px;"></div>
                                            <span class="cancelBtn"
                                                style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i
                                                    class="fa-solid fa-xmark"></i></span>
                                        </div>

                                        <div class="show_file">
                                            @if (isset($datas->submitted_data) &&
                                                    isset(json_decode($datas->submitted_data)->$a) &&
                                                    !empty(json_decode($datas->submitted_data)))
                                                <div class="form-group">
                                                    <label>{{ _('Uploded file') }}</label>
                                                    <div class="input-group mb-3">
                                                        <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                            class="form-control"
                                                            value="{{ file_title_from_url(json_decode($datas->submitted_data)->$a) }}"
                                                            disabled>
                                                        <input {{ $disabled ? 'disabled' : '' }} type="text"
                                                            class="form-control"
                                                            value="{{ file_name_from_url(json_decode($datas->submitted_data)->$a) }}"
                                                            disabled>
                                                        @if (!$disabled)
                                                            <a
                                                                href="{{ route('dm.kyc.file.delete', [$details->id, $a]) }}">
                                                                <span class="input-group-text text-danger h-100"><i
                                                                        class="tim-icons icon-trash-simple"></i></span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'file_multiple')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif

                                        <div class="input-group mb-3">
                                            <input {{ $disabled ? 'disabled' : '' }} type="text" name=""
                                                class="form-control file_title" placeholder="{{ _('Enter file name') }}">
                                            <input {{ $disabled ? 'disabled' : '' }} type="file" name=""
                                                id="{{ $fd->field_key }}"
                                                class="form-control fileInput {{ $disabled ? 'disabled' : '' }} {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}"
                                                multiple
                                                @if (isset($datas->submitted_data) &&
                                                        isset(json_decode($datas->submitted_data)->$a) &&
                                                        !empty(json_decode($datas->submitted_data))) data-count="{{ collect(json_decode($datas->submitted_data)->$a)->count() }}" @else data-count="1" @endif>
                                        </div>


                                        <div class="d-flex">
                                            <div class="progressBar bg-success"
                                                style="width: 0%; background: #ddd; height: 20px;"></div>
                                            <span class="cancelBtn"
                                                style="margin-left: 1rem; margin-right: 1rem; cursor: pointer; display:none;"><i
                                                    class="fa-solid fa-xmark"></i></span>
                                        </div>

                                        <div class="show_file">
                                            @if (isset($datas->submitted_data) &&
                                                    isset(json_decode($datas->submitted_data)->$a) &&
                                                    !empty(json_decode($datas->submitted_data)))
                                                @foreach (json_decode($datas->submitted_data)->$a as $url)
                                                    @php
                                                        $count += 1;
                                                    @endphp
                                                    <div class="form-group">
                                                        <label>{{ _('Uploded file - ' . $count) }}</label>
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
                                                                    href="{{ route('dm.kyc.file.delete', [$details->id, $a, base64_encode($url)]) }}">
                                                                    <span class="input-group-text text-danger h-100"><i
                                                                            class="tim-icons icon-trash-simple"></i></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'email')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <input {{ $disabled ? 'disabled' : '' }} type="email"
                                            name="{{ $fd->field_key }}" id="{{ $fd->field_key }}"
                                            class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}"
                                            value="{{ isset($datas->submitted_data) ? json_decode($datas->submitted_data)->$a : old($fd->field_key) }}">
                                        @include('alerts.feedback', ['field' => $fd->field_key])
                                    </div>
                                @elseif($fd->type == 'option')
                                    <div class="form-group {{ $errors->has($fd->field_key) ? ' has-danger' : '' }}">
                                        <label for="{{ $fd->field_key }}">{{ $fd->field_name }}</label>
                                        @if (isset($fd->required) && $fd->required == 'required')
                                            <span class="text-danger">*</span>
                                        @endif
                                        <select {{ $disabled ? 'disabled' : '' }} name="{{ $fd->field_key }}"
                                            id="{{ $fd->field_key }}"
                                            class="form-control  {{ $errors->has($fd->field_key) ? 'is-invalid' : '' }}">
                                            @foreach ($fd->option_data as $value => $label)
                                                <option value="{{ $value }}"
                                                    @if (isset($datas->submitted_data) &&
                                                            isset(json_decode($datas->submitted_data)->$a) &&
                                                            (json_decode($datas->submitted_data)->$a == $value || old($fd->field_key) == $value)) selected @endif>{{ $label }}
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
                            <div class="card-footer">
                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Update') }}</button>
                            </div>
                        @endif
                    </form>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text" style="font-weight: 600;">
                        {{ isset($details->documentation) ? __(json_decode($details->documentation)->title) : '' }}
                    </p>
                    <div class="card-description content-description">
                        {!! isset($details->documentation) ? json_decode($details->documentation)->details : '' !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_link')
    <script>
        const datas = {
            'file_upload': `{{ route('dm.kyc.file.upload') }}`,
            'file_delete': `{{ route('dm.kyc.file.delete', ['url']) }}`,
        };
        const disabled = `{{ $disabled }}`;
    </script>
    <script src="{{ asset('dm/js/kyc.js') }}"></script>
@endpush
