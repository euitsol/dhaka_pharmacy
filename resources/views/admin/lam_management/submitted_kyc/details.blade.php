@extends('admin.layouts.master', ['pageSlug' => 'lam_kyc_list'])
@section('title', 'Local Area Manager KYC Details')
@section('content')
    <div class="row px-3">
        <div class="col-md-12">
            {{-- Medicine Details Card  --}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{ c_user_name($data->creater) . __(' KYC Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'lam_management.lam_kyc.kyc_list.local_area_manager_kyc_list',
                                'className' => 'btn-primary',
                                'label' => 'Back',
                            ])
                        </div>

                        @if (!empty($data->note))
                            <div class="col-12">
                                <strong
                                    class="text-danger">{{ __('Previous Declined Reason: ') }}</strong>{!! $data->note !!}
                            </div>
                        @endif
                    </div>
                </div>
                @php
                    $save_datas = json_decode($data->submitted_data, true);
                    $form_datas = json_decode($kyc_setting->form_data, true);
                @endphp
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
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
                                                    href="{{ route('lam_management.lam_kyc.kyc_list.download.local_area_manager_kyc_details', base64_encode($save_datas[$form_data['field_key']])) }}"><i
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
                                                        href="{{ route('lam_management.lam_kyc.kyc_list.download.local_area_manager_kyc_details', base64_encode($file)) }}"><i
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
                                                        src="{{ storage_url($save_datas[$form_data['field_key']]) }}"
                                                        alt="">
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
                                                        <img class="imagePreview" src="{{ storage_url($image) }}"
                                                            alt="">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            <tr>
                                <th>{{ __('Verification Status') }}</th>
                                <th>:</th>
                                <td class="d-flex justify-content-between align-items-center">
                                    <div class="status">
                                        <span
                                            class="badge {{ $data->status === 1 ? 'badge-success' : ($data->status === 0 ? 'badge-info' : 'badge-warning') }}">{{ $data->status === 1 ? 'Accepted' : ($data->status === 0 ? 'Pending' : 'Declined') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="status_button text-end">
                        @if ($data->status === 0)
                            <a href="{{ route('lam_management.lam_kyc.kyc_list.accept.local_area_manager_kyc_status', $data->id) }}"
                                class="btn btn-sm btn-success">{{ __('Accept') }}</a>
                            <a href="javascript:void(0)" data-id="{{ $data->id }}"
                                class="btn btn-sm btn-warning declined">{{ __('Declined') }}</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Declined Reason') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card m-0">
                        <div class="card-body">
                            <form id="declined_form">
                                @csrf
                                <div class="form-group">
                                    <label>{{ __('Note') }} <span
                                            class="text-danger">{{ __('*') }}</span></label>
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                    @include('alerts.feedback', ['field' => 'note'])
                                </div>
                                <span type="submit" id="updateDeclinedNote"
                                    class="btn btn-primary btn-sm">{{ __('Update') }}</span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var main_th_width1 = $('.main_th1').width();
            var main_th_width2 = $('.main_th2').width();
            $('.content').find('tr th:first-child').css('width', main_th_width1 + 'px');
            $('.content').find('tr th:nth-child(2)').css('width', main_th_width2 + 'px');
        });
    </script>

    @push('js')
        <script>
            // Declined On Click
            $(document).ready(function() {
                $('.declined').on('click', function() {
                    let id = $(this).data('id');
                    $('#updateDeclinedNote').attr('data-id', id)
                    $('#exampleModal').modal('show');
                });
            });

            // Declined Update
            $(document).ready(function() {
                $('#updateDeclinedNote').click(function() {
                    var form = $('#declined_form');
                    let id = $(this).data('id');
                    let _url = (
                        "{{ route('lam_management.lam_kyc.kyc_list.declined.local_area_manager_kyc_status', ['id']) }}"
                        );
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




@endpush
