<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">{{ _('Email Templates') }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th>{{ __('SL') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($email_templates as $et)
                            <tr>
                                <td> {{ $loop->iteration }} </td>
                                <td> {{ $et->name }} </td>
                                <td> {{ $et->subject }} </td>
                                <td>
                                    <a class="btn btn-info btn-sm text-white edit_et" href="javascript:void(0)"
                                        data-id="{{ $et->id }}"><i class="fa-solid fa-pen"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Email Template') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatable">
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
                        <form id="emailTemplateForm">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('Subject') }}</label>
                                <input type="text" name="subject" id="subject" class="form-control"
                                    placeholder="Enter subject" value="">
                                @include('alerts.feedback', ['field' => 'subject'])
                            </div>
                            <div class="form-group">
                                <label>{{ __('Template') }}</label>
                                <textarea name="template" id="template" class="form-control"></textarea>
                                @include('alerts.feedback', ['field' => 'template'])
                            </div>
                            <span type="submit" id="updateEmailTemplate"
                                class="btn btn-primary btn-sm">{{ __('Update') }}</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        // Edit
        $(document).ready(function() {
            $('.edit_et').on('click', function() {
                let id = $(this).data('id');
                let _url = ("{{ route('settings.email_templates.site_settings', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    url: __url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var result = '';
                        var variables = JSON.parse(data.email_template.variables);

                        variables.forEach(function(variable) {
                            result += `
                                <tr>
                                    <td>{${variable.key}}</td>
                                    <td>{${variable.meaning}}</td>
                                </tr>
                            `;
                        });
                        $('.variables').html(result);



                        $('#updateEmailTemplate').attr('data-id', data.email_template.id)
                        $('#subject').val(data.email_template.subject)
                        $('#template').val(data.email_template.template);
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
            $('#updateEmailTemplate').click(function() {
                var form = $('#emailTemplateForm');
                let id = $(this).data('id');
                let _url = ("{{ route('settings.email_templates.site_settings', ['id']) }}");
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
    </script>
@endpush
