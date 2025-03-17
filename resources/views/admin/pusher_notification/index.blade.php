@extends('admin.layouts.master', ['pageSlug' => 'push_notification'])
@section('title', 'Push Notification Setting')
@push('css_link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="row px-3">
        <div class="{{ $document ? 'col-md-8' : 'col-md-12' }} ">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title">{{ __('Push Notification Setting') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('push.update.ns') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">

                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Channel') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('App ID') }}</label>
                                            <input type="text" name="app_id"
                                                value="{{ $notification_settings['app_id'] ?? '' }}"
                                                class="form-control {{ $errors->has('app_id') ? ' is-invalid' : '' }}"
                                                placeholder="Enter app id" value="{{ old('app_id') }}">
                                            @include('alerts.feedback', ['field' => 'app_id'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Key') }}</label>
                                            <input type="text" name="key"
                                                value="{{ $notification_settings['key'] ?? '' }}"
                                                class="form-control {{ $errors->has('key') ? ' is-invalid' : '' }}"
                                                placeholder="Enter key" value="{{ old('key') }}">
                                            @include('alerts.feedback', ['field' => 'key'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Secret') }}</label>
                                            <input type="text" name="secret"
                                                value="{{ $notification_settings['secret'] ?? '' }}"
                                                class="form-control {{ $errors->has('secret') ? ' is-invalid' : '' }}"
                                                placeholder="Enter secret" value="{{ old('secret') }}">
                                            @include('alerts.feedback', ['field' => 'secret'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Cluster') }}</label>
                                            <input type="text" name="cluster"
                                                value="{{ $notification_settings['cluster'] ?? '' }}"
                                                class="form-control {{ $errors->has('cluster') ? ' is-invalid' : '' }}"
                                                placeholder="Enter cluster" value="{{ old('cluster') }}">
                                            @include('alerts.feedback', ['field' => 'cluster'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-header">
                                    <h4 class="card-title">{{ __('Beame') }}</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Instance ID') }}</label>
                                            <input type="text" name="instance_id"
                                                value="{{ $notification_settings['instance_id'] ?? '' }}"
                                                class="form-control {{ $errors->has('instance_id') ? ' is-invalid' : '' }}"
                                                placeholder="Enter instance id" value="{{ old('instance_id') }}">
                                            @include('alerts.feedback', ['field' => 'instance_id'])
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('Primary Key') }}</label>
                                            <input type="text" name="primary_key"
                                                value="{{ $notification_settings['primary_key'] ?? '' }}"
                                                class="form-control {{ $errors->has('primary_key') ? ' is-invalid' : '' }}"
                                                placeholder="Enter primary key" value="{{ old('primary_key') }}">
                                            @include('alerts.feedback', ['field' => 'primary_key'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary ">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.partials.documentation', ['document' => $document])
    </div>



    {{-- Notification Template  --}}
    <div class="row px-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Notification Templates') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th class="text-center">{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notification_templates as $nt)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $nt->name }} </td>
                                    <td> {{ str_limit($nt->message) }} </td>
                                    <td class="text-center">
                                        <div class="status">
                                            <input type="checkbox" value="1" {{ $nt->status == 1 ? 'checked' : '' }}
                                                class="valueToggle status" name='status' data-toggle="toggle"
                                                data-onlabel="Active" data-offlabel="Deactive" data-onstyle="success"
                                                data-offstyle="danger" data-style="ios" data-id="{{ $nt->id }}">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-info btn-sm text-white edit_nt" href="javascript:void(0)"
                                            data-id="{{ $nt->id }}"><i class="fa-solid fa-pen"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>



    <!-- Notification Template Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Notification Template') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Variable') }}</th>
                                        <th>{{ __('Meaning') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="variables">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form id="NtForm">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Message') }}</label>
                                    <textarea name="message" id="message" class="form-control"></textarea>
                                    @include('alerts.feedback', ['field' => 'message'])
                                </div>
                                <div class="text-end">
                                    <span type="submit" id="updateNt"
                                        class="btn btn-primary btn-sm">{{ __('Update') }}</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.datatable', ['columns_to_show' => [0, 1, 2, 3, 4]])

@push('js_link')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
@endpush
@push('js')
    <script>
        // Edit
        $(document).ready(function() {
            $('.edit_nt').on('click', function() {
                let id = $(this).data('id');
                let _url = ("{{ route('push.nt.ns', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        var variables = JSON.parse(data.notification_template.variables);

                        variables.forEach(function(variable) {
                            result += `
                                <tr>
                                    <td>{${variable.key}}</td>
                                    <td>{${variable.meaning}}</td>
                                </tr>
                            `;
                        });
                        $('.variables').html(result);



                        $('#updateNt').attr('data-id', data.notification_template.id)
                        $('#message').val(data.notification_template.message)
                        $('#exampleModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching member data:', error);
                    }
                });
            });
        });

        // Update
        $(document).ready(function() {
            $('#updateNt').click(function() {
                var form = $('#NtForm');
                let id = $(this).data('id');
                let _url = ("{{ route('push.nt.ns', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    type: 'PUT',
                    url: __url,
                    data: form.serialize(),
                    success: function(response) {
                        $('#exampleModal').modal('hide');
                        console.log(response.message);
                        window.location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                // Display validation errors
                                var errorHtml = '';
                                $.each(messages, function(index, message) {
                                    errorHtml +=
                                        '<span class="invalid-feedback d-block" role="alert">' +
                                        message + '</span>';
                                });
                                $('[name="' + field + '"]').after(errorHtml);
                            });
                        } else {
                            // Handle other errors
                            console.log('An error occurred.');
                        }
                    }
                });
            });
        });


        // Status Update
        $(document).ready(function() {
            $('.status').on('change', function() {
                let $this = $(this);
                let id = $this.data('id');
                let _url = ("{{ route('push.nt.status.ns', ['id']) }}");
                let __url = _url.replace('id', id);


                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        toastr.success(data.message);
                        $this.prop('checked', true);
                    },
                    error: function(xhr, status, error) {
                        // toastr.error(error);
                        console.error('Error fetching member data:', error);
                    }
                });
            });
        })
    </script>
@endpush
