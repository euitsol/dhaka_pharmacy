@extends('pharmacy.layouts.master', ['pageSlug' => 'pharmacy_dashboard'])

@section('title', 'Pharmacy Dashboard')
@push('css')
    <style>
        .dashboard_wrap {
            height: 83vh;
        }

        .dashboard_wrap h2,
        .dashboard_wrap h4 {
            margin: 40px auto;
            font-family: 'Ubuntu', sans-serif;
            font-size: 90px;
            color: #182456;
            text-align: center;
            letter-spacing: 5px;
            text-shadow: 0 2px 1px #747474,
                -1px 3px 1px #767676,
                -2px 5px 1px #787878,
                -3px 7px 1px #7a7a7a,
                -4px 9px 1px #7f7f7f,
                -5px 11px 1px #838383,
                -6px 13px 1px #878787,
                -7px 15px 1px #8a8a8a,
                -8px 17px 1px #8e8e8e,
                -9px 19px 1px #949494,
                -10px 21px 1px #989898,
                -11px 23px 1px #9f9f9f,
                -12px 25px 1px #a2a2a2,
                -13px 27px 1px #a7a7a7,
                -14px 29px 1px #adadad,
                -15px 31px 1px #b3b3b3,
                -16px 33px 1px #b6b6b6,
                -17px 35px 1px #bcbcbc,
                -18px 37px 1px #c2c2c2,
                -19px 39px 1px #c8c8c8,
                -20px 41px 1px #cbcbcb,
                -21px 43px 1px #d2d2d2,
                -22px 45px 1px #d5d5d5,
                -23px 47px 1px #e2e2e2,
                -24px 49px 1px #e6e6e6,
                -25px 51px 1px #eaeaea,
                -26px 53px 1px #efefef;
        }

        .dashboard_wrap h4 {
            font-size: 60px;
            margin: 0;
            margin-bottom: 40px;
        }
    </style>
@endpush

@section('content')
    <div class="main-animation">
    </div>
    <div class="row">
        <div class="col-12">
            <div class="dashboard_wrap d-flex flex-column justify-content-center align-items-center">
                <h2>{{ __('DHAKA PHARMACY') }}</h2>
                <h4>{{ __('PHARMACIST') }}</h4>
                <h4>{{ __(strtoupper(optional(pharmacy()->operation_area)->name)) }}</h4>
                <h4>{{ __(strtoupper(optional(pharmacy()->operation_sub_area)->name)) }}</h4>
            </div>
        </div>
    </div>

@endsection
