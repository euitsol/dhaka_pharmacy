@if ($submitted_kyc)
    @php
        $save_datas = json_decode($submitted_kyc->submitted_data, true);
        $form_datas = json_decode($submitted_kyc->kyc->form_data, true);
    @endphp
    <table class="table table-striped">
        <tbody>
            <tr>
                <th>{{ __('KYC Status') }}</th>
                <th>:</th>
                <td>
                    <span class="{{ $dm->getKycStatusClass() }}">{{ $dm->getKycStatus() }}</span>
                </td>
            </tr>
            @foreach ($form_datas as $key => $form_data)
                @if ($form_data['type'] == 'text' || $form_data['type'] == 'number')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                {{ $save_datas[$form_data['field_key']] }}
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'url')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                <a
                                    href="{{ $save_datas[$form_data['field_key']] }}">{{ removeHttpProtocol($save_datas[$form_data['field_key']]) }}</a>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'email')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                <a
                                    href="{{ 'mailto:' . $save_datas[$form_data['field_key']] }}">{{ $save_datas[$form_data['field_key']] }}</a>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'date')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                {{ timeFormate($save_datas[$form_data['field_key']]) }}
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'option')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                <span
                                    class="badge {{ $save_datas[$form_data['field_key']] == 1 ? 'badge-success' : 'badge-info' }}">{{ $save_datas[$form_data['field_key']] == 1 ? 'True' : 'False' }}</span>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'textarea')
                    <tr>
                        <th class="main_th1">{{ $form_data['field_name'] }}</th>
                        <th class="main_th2">:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                {!! $save_datas[$form_data['field_key']] !!}
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'file_single')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                <a class="btn btn-info btn-sm"
                                    href="{{ route('dm_management.dm_kyc.kyc_list.download.district_manager_kyc_details', base64_encode($save_datas[$form_data['field_key']])) }}"><i
                                        class="fa-regular fa-circle-down"></i></a>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'file_multiple')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                @foreach ($save_datas[$form_data['field_key']] as $file)
                                    <a class="imagePreviewDiv btn btn-info btn-sm"
                                        href="{{ route('dm_management.dm_kyc.kyc_list.download.district_manager_kyc_details', base64_encode($file)) }}"><i
                                            class="fa-regular fa-circle-down"></i></a>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'image')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                <div class="imagePreviewDiv">
                                    <img class="imagePreview"
                                        src="{{ storage_url($save_datas[$form_data['field_key']]) }}" alt="">
                                </div>
                            @endif
                        </td>
                    </tr>
                @endif
                @if ($form_data['type'] == 'image_multiple')
                    <tr>
                        <th>{{ $form_data['field_name'] }}</th>
                        <th>:</th>
                        <td>
                            @if (isset($save_datas[$form_data['field_key']]))
                                @foreach ($save_datas[$form_data['field_key']] as $image)
                                    <div class="imagePreviewDiv d-inline-block">
                                        <img class="imagePreview" src="{{ storage_url($image) }}" alt="">
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@else
    <h5 class="text-center text-muted">{{ __('The KYC has not been submitted yet') }}</h5>
@endif
