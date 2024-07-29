@extends('admin.layouts.master', ['pageSlug' => 'pc_' . $payment->activityTitle()])
@section('title', slugToTitle($payment->activityTitle()) . ' Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __(slugToTitle($payment->activityTitle()) . ' Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'pc.pc_list',
                                'params' => strtolower($payment->activityTitle()),
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="fw-bolder"> {{ __('Receiver Name') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $payment->receiver->name }} </td>
                                <td>|</td>
                                <td class="fw-bolder"> {{ __('Point') }} </td>
                                <td>{{ __(':') }}</td>
                                <td class="fw-bolder"> {{ number_format($payment->point, 2) }} ({!! get_taka_icon() . number_format($payment->point_history->eq_amount, 2) !!})
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder"> {{ __('Equivalent Amount') }} </td>
                                <td>{{ __(':') }}</td>
                                <td class="fw-bolder"> {!! get_taka_icon() !!}{{ number_format($payment->eq_amount, 2) }}
                                </td>
                                <td>|</td>
                                <td class="fw-bolder"> {{ __('Activity') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> <span
                                        class="{{ $payment->activityBg() }}">{{ slugToTitle($payment->activityTitle()) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder"> {{ __('Submitted Date') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ timeFormate($payment->created_at) }} </td>
                                <td>|</td>
                                <td class="fw-bolder"> {{ __('Submitted By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ c_user_name($payment->creater) . ' ( ' . getSubmitterType($payment->creater_type) . ' )' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bolder"> {{ __('Approved Date') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $payment->created_at != $payment->updated_at ? timeFormate($payment->updated_at) : '--' }}
                                </td>
                                <td>|</td>
                                <td class="fw-bolder"> {{ __('Approved By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ u_user_name($payment->updater) }} </td>
                            </tr>
                            @if ($payment->activity == -1)
                                <tr>
                                    <td class="fw-bolder"> {{ __('Reason') }} </td>
                                    <td>{{ __(':') }}</td>
                                    <td colspan="5"> <span class="text-danger">{!! $payment->description !!}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4 text-end">
                    @if ($payment->activity == 0)
                        @include('admin.partials.button', [
                            'routeName' => 'pc.pc_accept',
                            'className' => 'btn-primary',
                            'params' => ['id' => encrypt($payment->id)],
                            'label' => 'Accept',
                        ])
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Payment Declaine') }}</h5>
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
                        <a href="javascript:void(0)" data-id="{{ encrypt($payment->id) }}"
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
                let _url = ("{{ route('pc.pc_declined', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    type: 'POST',
                    url: __url,
                    data: form.serialize(),
                    success: function(response) {
                        $('.invalid-feedback').remove();
                        $('.view_modal').modal('hide');
                        window.location.href =
                            "{{ route('pc.pc_list', 'pending-clearance') }}";
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
