@extends('frontend.layouts.master')
@section('title', 'Terms And Conditions')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/terms_and_conditions.css') }}">
@endpush
@section('content')
    <section class="tream-condition py-4 py-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center page-title">
                        <h1>{{__('Terms and Conditions')}}</h1>
                    </div>
                </div>
                <div class="col mt-2 mt-lg-4">
                    <h2>{{__('Cancel Order:')}}</h2>
                    <ul>
                        <li>{{__('1. If customer want to cancel the order then they have to cancel before 1:10 PM. After 1:10 PM, cancellation will NOT be accepted.')}}</li>
                        <li>{{__('2.To cancel the order, email support@lazzpharma.Com, and include the order number.')}}</li>
                        <li>{{__('3. For medicine orders, you must submit or show your prescriptions while ordering or receiving medicines from us. Otherwise, Dhaka Pharmacy may cancel the order and return the products.')}}</li>
                    </ul>
                    <hr>
                    <h2>{{__('Disclaimer:')}}</h2>
                    <ul>
                        <li>{{__('1. Dhaka Pharmacy is a retail pharmacy that resells medications by maintaining the local government law.')}}</li>
                        <li>{{__('2. A patient should carefully read the medicines’ full description, dosage, side effect etc. before consumption.')}}</li>
                        <li>{{__('3. You must consult with registered doctors before ordering/consuming any medicine. For any medicine related consequences, Dhaka Pharmacy and/or its representatives, associates, owners will not be responsible.')}}</li>
                        <li>{{__('4. Manufactures and importers are the only entities that are solely responsible for the medicines’ quality, packaging and trademarks. Dhaka Pharmacy only resell those medicine.')}}</li>
                        <li>{{__('5. For any emergency, or in the case that immediate medical support is required, consult with a registered doctor and purchase medicine from your nearest pharmacy.')}}</li>
                        <li>{{__('6. Your order confirmation will be considered after you receive verbal confirmation over the telephone from Dhaka Pharmacy hotline.')}}</li>
                        <li>{{__('7. To have a successful and uninterrupted order, make sure that your device is virus free. It may affect the ordering system.')}}</li>
                        <li>{{__('8. For a smooth delivery, Dhaka Pharmacy will communicate via SMS, email and telephone calls. We may also send you offers or promotions periodically through these channels.')}}</li>
                        <li>{{__('9.Our system may receive some information from device/computer such as: IP address, location, time, browser type etc. This is due to the default communication protocol, and your information will not be used or kept on our database.')}}</li>
                        <li>{{__('10. Orders may be delayed or exceed the lead time due to natural disasters, emergency law enforcement restrictions & other national/local crises.')}}</li>
                        <li>{{__('11. Dhaka Pharmacy has the right to cancel any order based on inventory or any issue.')}}li>
                        <li>{{__('12. Some product or medicine prices may vary from the price stated online.')}}</li>
                    </ul>
                    <hr>
                    <h2>{{__('Customer Must Know:')}}</h2>
                    <p>{{__('Seductive, antibiotic and medicine which has side effects will not be delivered without prescription. In that case no “Prescription on delivery” will be allowed. Dhaka Pharmacy has the rights to cancel order if there is no proper documentation from the customer regarding the medicine.Without signing of NOC, products will not be delivered.')}}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
