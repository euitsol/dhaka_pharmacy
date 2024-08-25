@extends('admin.layouts.master', ['pageSlug' => 'dm_kyc_settings'])
@section('title', 'District Manager KYC Details')
@section('content')
    <div class="row px-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ __('District Manager KYC Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'dm_management.dm_kyc.settings.dm_kyc_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>
                    </div>
                </div>
                @php
                    $form_datas = json_decode($kyc->form_data, true);
                @endphp
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('SL') }}</th>
                                <th>{{ __('Field Name') }}</th>
                                <th>{{ __('Field Key') }}</th>
                                <th>{{ __('Filed Type') }}</th>
                                <th>{{ __('Filed Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($form_datas as $fd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $fd['field_name'] }}</td>
                                    <td>{{ $fd['field_key'] }}</td>
                                    <td>
                                        {{ $fd['type'] }}
                                        @if (isset($fd['option_data']))
                                            ({{ implode(', ', $fd['option_data']) }})
                                        @endif

                                    </td>
                                    <td>{{ $fd['required'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    @if ($kyc->status == 0)
                        <a href="{{ route('dm_management.dm_kyc.settings.dm_kyc_status', encrypt($kyc->id)) }}"
                            class="btn {{ $kyc->getStatusClass() }}">{{ $kyc->getBtnStatus() }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
