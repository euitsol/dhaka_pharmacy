@extends('admin.layouts.master', ['pageSlug' => 'wm_' . $wm->statusTitle()])
@section('title', 'Withdraw Method Details')
@push('css')
    <style>
        .declained_form {
            height: 0;
            opacity: 0;
            visibility: hidden;
            transition: .4s;
        }

        .declained_form.active {
            height: auto;
            opacity: 1;
            visibility: visible;
        }
    </style>
@endpush
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
                                <td> {{ $wm->type }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Status') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> <span class="{{ $wm->statusBg() }}">{{ $wm->statusTitle() }}</span> </td>
                            </tr>
                            <tr>
                                <td> {{ __('Note') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {!! $wm->note ?? '--' !!} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Created At') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ timeFormate($wm->created_at) }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Created By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ c_user_name($wm->creater) }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Updated At') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ $wm->created_at != $wm->updated_at ? timeFormate($wm->updated_at) : '--' }} </td>
                            </tr>
                            <tr>
                                <td> {{ __('Updated By') }} </td>
                                <td>{{ __(':') }}</td>
                                <td> {{ u_user_name($wm->updater) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4 text-end">
                    @include('admin.partials.button', [
                        'routeName' => 'withdraw_method.status.wm_details',
                        'className' => 'btn-primary',
                        'params' => ['id' => encrypt($wm->id)],
                        'label' => 'Accept',
                    ])
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger declained_btn">{{ __('Declained') }}</a>
                    <form action="" method="POST" class="declained_form">
                        @csrf
                        <div class="form-group text-start">
                            <label>{{ __('Declained Reason') }}</label>
                            <textarea name="declained_reason" placeholder="Enter declained reason" class="form-control">{{ old('declained_reason') }}</textarea>
                            @include('alerts.feedback', ['field' => 'declained_reason'])
                        </div>
                        <input type="submit" value="Submit" class="btn btn-primary">
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
                $('.declained_form').toggleClass('active');
            });
        });
    </script>
@endpush
