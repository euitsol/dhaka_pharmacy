@extends('admin.layouts.master', ['pageSlug' => 'wm_' . $wm->statusTitle()])
@section('title', 'Withdraw Method Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Withdraw Method Details') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td> {{ __('Account Name') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->account_name }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Bank Name') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->bank_name }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Bank Brunch Name') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->bank_brunch_name }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Routing Number') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->routing_number }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Type') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->type() }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Status') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> <span class="{{ $wm->statusBg() }}">{{ $wm->statusTitle() }}</span> </td>
                            </tr>
                            <tr>
                                <td> {{ __('Note') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {!! '<p class="text-danger">' . $wm->note . '</p>' ?? '--' !!} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Submitted Date') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ timeFormate($wm->created_at) }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Submitted By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ c_user_name($wm->creater) . ' ( ' . getSubmitterType($wm->creater_type) . ' )' }}
                                </td>
                            </tr>
                            <tr>
                                <td> {{ __('Approved Date') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->created_at != $wm->updated_at ? timeFormate($wm->updated_at) : '--' }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Approved By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ u_user_name($wm->updater) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4 text-end">
                    @if ($wm->status !== 1)
                        @include('admin.partials.button', [
                            'routeName' => 'withdraw_method.wm_accept',
                            'className' => 'btn-primary',
                            'params' => ['id' => encrypt($wm->id)],
                            'label' => 'Accept',
                        ])
                    @endif
                    @if ($wm->status !== 2)
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger declined_btn">{{ __('Decline') }}</a>
                    @endif


                </div>
            </div>
        </div>
    </div>
    {{-- Delained Modal  --}}
    <div class="modal view_modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Declaine') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                    <form method="POST" class="declinedForm">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Reason') }}</label>
                            <textarea name="declined_reason" placeholder="Enter declined reason" class="form-control">{{ old('declined_reason') }}</textarea>
                            @include('alerts.feedback', ['field' => 'declined_reason'])
                        </div>
                        <a href="javascript:void(0)" data-id="{{ encrypt($wm->id) }}"
                            class="btn btn-primary float-end declined_submit">{{ __('Submit') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.declined_btn').on('click', function() {
                $('.view_modal').modal('show');
            });
        });

        $(document).ready(function() {
            $('.declined_submit').click(function() {
                var form = $('.declinedForm');
                let id = $(this).data('id');
                let _url = ("{{ route('withdraw_method.wm_declined', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    type: 'POST',
                    url: __url,
                    data: form.serialize(),
                    success: function(response) {
                        $('.invalid-feedback').remove();
                        $('.view_modal').modal('hide');
                        window.location.href =
                            "{{ route('withdraw_method.wm_list', 'Declined') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            $('.invalid-feedback').remove();
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
