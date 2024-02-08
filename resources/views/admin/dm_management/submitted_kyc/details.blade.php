@extends('admin.layouts.master', ['pageSlug' => 'dm_kyc_list'])
@section('content')
    <div class="row px-3 pt-3">
        <div class="col-md-12">
                {{-- Medicine Details Card  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="card-title">{{ $data->creater->name. __(' KYC Details') }}</h4>
                            </div>
                            <div class="col-4 text-right">
                                @include('admin.partials.button', [
                                    'routeName' => 'dm_management.dm_kyc.kyc_list.district_manager_kyc_list',
                                    'className' => 'btn-primary',
                                    'label' => 'Back',
                                ])
                            </div>
                        </div>
                    </div>
                    @php
                        $save_datas = json_decode($data->submitted_data, true);
                        $form_datas = json_decode($kyc_setting->form_data, true);
                    @endphp
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                @foreach ($form_datas as $key=>$form_data)
                                    @if($form_data['type'] == 'text' || $form_data['type'] == 'number')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']])){{$save_datas[$form_data['field_key']]}}@endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'url')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                <a href="{{$save_datas[$form_data['field_key']]}}">{{removeHttpProtocol($save_datas[$form_data['field_key']])}}</a>
                                            @endif
                                        </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'email')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                <a href="{{'mailto:'.$save_datas[$form_data['field_key']]}}">{{$save_datas[$form_data['field_key']]}}</a>
                                            @endif
                                        </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'date')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']])){{timeFormate($save_datas[$form_data['field_key']])}}@endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'option')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                    <span class="badge {{$save_datas[$form_data['field_key']] == 1 ? 'badge-success' : 'badge-info'}}">{{$save_datas[$form_data['field_key']] == 1 ? 'True' : 'False'}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'textarea')
                                        <tr>
                                            <th class="main_th1">{{$form_data['field_name']}}</th>
                                            <th class="main_th2">:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']])){!! $save_datas[$form_data['field_key']]!!}@endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'file_single')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                    <a class="btn btn-info btn-sm" href="{{route('dm_management.dm_kyc.kyc_list.download.district_manager_kyc_details',base64_encode($save_datas[$form_data['field_key']]))}}"><i class="fa-regular fa-circle-down"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'file_multiple')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                    @foreach ($save_datas[$form_data['field_key']] as $file)
                                                        <a class="imagePreviewDiv btn btn-info btn-sm" href="{{route('dm_management.dm_kyc.kyc_list.download.district_manager_kyc_details',base64_encode($file))}}"><i class="fa-regular fa-circle-down"></i></a>
                                                    @endforeach
                                                    
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'image')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                    <div class="imagePreviewDiv">
                                                        <img class="imagePreview" src="{{storage_url($save_datas[$form_data['field_key']])}}" alt="">
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if($form_data['type'] == 'image_multiple')
                                        <tr>
                                            <th>{{$form_data['field_name']}}</th>
                                            <th>:</th>
                                            <td>
                                                @if(isset($save_datas[$form_data['field_key']]))
                                                    @foreach ($save_datas[$form_data['field_key']] as $image)
                                                        <div class="imagePreviewDiv d-inline-block">
                                                            <img class="imagePreview" src="{{storage_url($image)}}" alt="">
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <th>{{__('Verification Status')}}</th>
                                    <th>:</th>
                                    <td class="d-flex justify-content-between align-items-center">
                                        <div class="status">
                                            <span class="badge {{($data->status === 1) ? 'badge-success' : (($data->status === 0) ? 'badge-info' : 'badge-warning') }}">{{($data->status === 1) ? 'Accepted' : (($data->status === 0) ? 'Pending' : 'Declined') }}</span>
                                        </div>
                                        <div class="status_button">
                                            @if($data->status === 0)
                                                <a href="{{route('dm_management.dm_kyc.kyc_list.district_manager_kyc_status',['id'=>$data->id, 'status'=>1])}}" class="btn btn-sm btn-success">{{__('Accept')}}</a>
                                                <a href="{{route('dm_management.dm_kyc.kyc_list.district_manager_kyc_status',$data->id)}}" class="btn btn-sm btn-warning">{{__('Declined')}}</a>
                                            @elseif($data->status === 1)
                                                <a href="{{route('dm_management.dm_kyc.kyc_list.district_manager_kyc_status',$data->id)}}" class="btn btn-sm btn-warning">{{__('Declined')}}</a>
                                            @endif
                                            
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function(){
        var main_th_width1 = $('.main_th1').width();
        var main_th_width2 = $('.main_th2').width();
        $('.content').find('tr th:first-child').css('width',main_th_width1+'px');
        $('.content').find('tr th:nth-child(2)').css('width',main_th_width2+'px');
    });
</script>
    
@endpush
