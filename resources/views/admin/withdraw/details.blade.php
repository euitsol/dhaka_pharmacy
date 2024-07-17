@extends('admin.layouts.master', ['pageSlug' => 'w_' . $withdraw->statusTitle()])
@section('title', 'Withdraw Details')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('Withdraw Details') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">{{ __('Withdraw Request Information') }}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td class="fw-bolder"> {{ __('Receiver Name') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->receiver->name }} </td>
                                        <td>|</td>
                                        <td class="fw-bolder"> {{ __('Withdraw Point') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td class="fw-bolder"> {{ getPendingWithdrawPoints($withdraw->earnings) }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder"> {{ __('Withdraw Equivalent Amount') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td class="fw-bolder"> {!! get_taka_icon() !!}{{ $withdraw->amount }} </td>
                                        <td>|</td>
                                        <td class="fw-bolder"> {{ __('Status') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> <span
                                                class="{{ $withdraw->statusBg() }}">{{ $withdraw->statusTitle() }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder"> {{ __('Created Date') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ timeFormate($withdraw->created_at) }} </td>
                                        <td>|</td>
                                        <td class="fw-bolder"> {{ __('Created By') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ c_user_name($withdraw->creater) }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bolder"> {{ __('Accepted At') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->created_at != $withdraw->updated_at ? timeFormate($withdraw->updated_at) : '--' }}
                                        </td>
                                        <td>|</td>
                                        <td class="fw-bolder"> {{ __('Accepted By') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ u_user_name($withdraw->updater) }} </td>
                                    </tr>
                                    @if ($withdraw->status == 2)
                                        <tr>
                                            <td class="fw-bolder"> {{ __('Reason') }} </td>
                                            <td>{{ __(':') }}</td>
                                            <td colspan="5"> <span class="text-danger">{!! $withdraw->reason !!}</span>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">{{ __('Withdraw Method Information') }}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td> {{ __('Account Name') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->account_name }} </td>
                                        <td>|</td>
                                        <td> {{ __('Bank Name') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->bank_name }} </td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('Bank Brunch Name') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->bank_brunch_name }} </td>
                                        <td>|</td>
                                        <td> {{ __('Routing Number') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->routing_number }} </td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('Type') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->type }} </td>
                                        <td>|</td>
                                        <td> {{ __('Status') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> <span
                                                class="{{ $withdraw->withdraw_method->statusBg() }}">{{ $withdraw->withdraw_method->statusTitle() }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('Created Date') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ timeFormate($withdraw->withdraw_method->created_at) }} </td>
                                        <td>|</td>
                                        <td> {{ __('Created By') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ c_user_name($withdraw->withdraw_method->creater) }} </td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('Accepted At') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ $withdraw->withdraw_method->created_at != $withdraw->withdraw_method->updated_at ? timeFormate($withdraw->withdraw_method->updated_at) : '--' }}
                                        </td>
                                        <td>|</td>
                                        <td> {{ __('Accepted By') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td> {{ u_user_name($withdraw->withdraw_method->updater) }} </td>
                                    </tr>
                                    <tr>
                                        <td> {{ __('Note') }} </td>
                                        <td>{{ __(':') }}</td>
                                        <td colspan="5"> {!! '<p class="text-danger">' . $withdraw->withdraw_method->note . '</p>' ?? '--' !!} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title">{{ __('Withdraw Point Rate Information') }}</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> {{ __('Equivalent Amount Per Point') }} </th>
                                        <th>{{ __('Total Withdraw Point') }}</th>
                                        <th>{{ __('Total Withdraw Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdraw->earnings as $er)
                                        <tr>
                                            <td>
                                                {{ __('1 Point = ') }}{!! get_taka_icon() !!}{{ number_format($er->point_history->eq_amount, 2) }}
                                            </td>
                                            <td>{{ number_format($er->point, 2) }}</td>
                                            <td>{!! get_taka_icon() !!}{{ number_format($er->eq_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-4 text-end">
                    @if ($withdraw->status == 0)
                        @include('admin.partials.button', [
                            'routeName' => 'withdraw.w_accept',
                            'className' => 'btn-primary',
                            'params' => ['id' => encrypt($withdraw->id)],
                            'label' => 'Accept',
                        ])
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger declained_btn">{{ __('Declained') }}</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Withdraw Declaine') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_data">
                    <form method="POST" class="declainedForm">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Reason') }}</label>
                            <textarea name="declained_reason" placeholder="Enter declained reason" class="form-control">{{ old('declained_reason') }}</textarea>
                            @include('alerts.feedback', ['field' => 'declained_reason'])
                        </div>
                        <a href="javascript:void(0)" data-id="{{ encrypt($withdraw->id) }}"
                            class="btn btn-primary float-end declained_submit">{{ __('Submit') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.declained_btn').on('click', function() {
                $('.view_modal').modal('show');
            });
        });

        $(document).ready(function() {
            $('.declained_submit').click(function() {
                var form = $('.declainedForm');
                let id = $(this).data('id');
                let _url = ("{{ route('withdraw.w_declained', ['id']) }}");
                let __url = _url.replace('id', id);
                $.ajax({
                    type: 'POST',
                    url: __url,
                    data: form.serialize(),
                    success: function(response) {
                        $('.invalid-feedback').remove();
                        $('.view_modal').modal('hide');
                        window.location.href =
                            "{{ route('withdraw.w_list', 'Declained') }}";
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
