@extends('admin.layouts.master', ['pageSlug' => 'p_kyc_settings'])
@section('title', 'Pharmacy KYC Details')
@section('content')
    <div class="row px-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{{__('Pharmacy KYC Details') }}</h4>
                        </div>
                        <div class="col-4 text-right">
                            @include('admin.partials.button', [
                                'routeName' => 'pm.pharmacy_kyc.settings.p_kyc_list',
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
                                <th>{{__('SL')}}</th>
                                <th>{{__('Field Name')}}</th>
                                <th>{{__('Field Key')}}</th>
                                <th>{{__('Filed Type')}}</th>
                                <th>{{__('Filed Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($form_datas as $fd)
                                <tr>
                                   <td>{{$loop->iteration}}</td>
                                   <td>{{$fd['field_name']}}</td>
                                   <td>{{$fd['field_key']}}</td>
                                   <td>
                                    {{$fd['type']}} 
                                    @if(isset($fd['option_data']))
                                        ({{implode(', ',$fd['option_data'])}})
                                    @endif

                                   </td>
                                   <td>{{$fd['required']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-end">
                    <a href="{{route('pm.pharmacy_kyc.settings.p_kyc_status',encrypt($kyc->id))}}" class="btn {{$kyc->getStatusClass()}}">{{$kyc->getBtnStatus()}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
