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
                    <span class="{{ $lam->getKycStatusClass() }}">{{ $lam->getKycStatus() }}</span>
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
                                {{ $form_data['option_data'][$save_datas[$form_data['field_key']]] }}
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
                                @if (isImage($save_datas[$form_data['field_key']]))
                                    <div class="imagePreviewDiv d-inline-block">
                                        <div id="lightbox" class="lightbox">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($save_datas[$form_data['field_key']]) }}"
                                                    class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
                                    </div>
                                @else
                                    <a class="btn btn-info btn-sm"
                                        href="{{ route('lam_management.lam_kyc.submitted_kyc.download.lams_kyc_details', base64_encode($save_datas[$form_data['field_key']])) }}"><i
                                            class="fa-regular fa-circle-down"></i></a>
                                @endif
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
                                    @if (isImage($file))
                                        <div class="imagePreviewDiv d-inline-block">
                                            <div id="lightbox" class="lightbox">
                                                <div class="lightbox-content">
                                                    <img src="{{ storage_url($file) }}" class="lightbox_image">
                                                </div>
                                                <div class="close_button fa-beat">X</div>
                                            </div>
                                        </div>
                                    @else
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('lam_management.lam_kyc.submitted_kyc.download.lams_kyc_details', base64_encode($file)) }}"><i
                                                class="fa-regular fa-circle-down"></i></a>
                                    @endif
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
                                    <div id="lightbox" class="lightbox">
                                        <div class="lightbox-content">
                                            <img src="{{ storage_url($save_datas[$form_data['field_key']]) }}"
                                                class="lightbox_image">
                                        </div>
                                        <div class="close_button fa-beat">X</div>
                                    </div>
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
                                        <div id="lightbox" class="lightbox">
                                            <div class="lightbox-content">
                                                <img src="{{ storage_url($image) }}" class="lightbox_image">
                                            </div>
                                            <div class="close_button fa-beat">X</div>
                                        </div>
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
