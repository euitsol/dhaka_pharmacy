@extends('frontend.layouts.master')
@section('title', 'Privacy Policy')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/asset/css/privacy_policy.css') }}">
@endpush
@section('content')
    <section class="tream-condition py-3 py-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center page-title">
                        <h1>{{__('Privacy Policy')}}</h1>
                    </div>
                </div>
                <div class="col mt-2 mt-lg-4">
                    <h2>{{__('Effective Date: 1st March, 2025')}}</h2>
                    <p>{{__('Welcome to Dhaka Pharmacy. Your privacy is important to us, and we are committed to protecting your personal information. This Privacy Policy explains how we collect, use, store, and protect your data when you use our website or mobile app.')}}</p>
                    <hr>
                    <h2>{{__('1. Information We Collect')}}</h2>
                    <p>{{__('When you use Dhaka Pharmacy, we may collect the following types of information:')}}</p>
                    <h3>{{__('1.1 Personal Information')}}</h3>
                    <ul>
                        <li>{{__('Name')}}</li>
                        <li>{{__('Phone number')}}</li>
                        <li>{{__('Email address')}}</li>
                        <li>{{__('Delivery address')}}</li>
                        <li>{{__('Prescription details (if applicable)')}}</li>
                        <li>{{__('Payment information (processed securely through third-party gateways)')}}</li>
                    </ul>
                    <h3>{{__('1.2 Non-Personal Information')}}</h3>
                    <ul>
                        <li>{{__('Device information (e.g., model, operating system)')}}</li>
                        <li>{{__('Browsing data and app usage statistics')}}</li>
                        <li>{{__('IP address and location data (with your permission)')}}</li>
                    </ul>
                    <hr>
                    <h2>{{__('2. How We Use Your Information')}}</h2>
                    <p>{{__('We use your data to:')}}</p>
                    <ul>
                        <li>{{ __('Process and deliver your medicine orders') }}</li>
                        <li>{{ __('Verify prescriptions as required by law') }}</li>
                        <li>{{ __('Provide customer support and respond to inquiries') }}</li>
                        <li>{{ __('Improve our app functionality and user experience') }}</li>
                        <li>{{ __('Notify you about offers, promotions, and updates (if you opt-in)') }}</li>
                        <li>{{ __('Prevent fraudulent activities and ensure security') }}</li>
                    </ul>
                    <hr>
                    <h2>{{__('3. Data Sharing & Disclosure')}}</h2>
                    <p>{{__('We do not sell or rent your personal information. However, we may share data with:')}}</p>
                    <ul>
                        <li>{{ __('Delivery Partners: To fulfill and deliver your orders') }}</li>
                        <li>{{ __('Payment Processors: To facilitate secure transactions') }}</li>
                        <li>{{ __('Legal Authorities: If required by law to comply with regulations') }}</li>
                    </ul>
                    <hr>
                    <h2>{{__('4. Data Security')}}</h2>
                    <p>{{__('We take strong measures to protect your data, including:')}}</p>
                    <ul>
                        <li>{{ __('Encryption of sensitive information') }}</li>
                        <li>Secure payment processing via trusted providers</li>
                        <li>Restricted access to personal data within our organization</li>

                    </ul>
                    <hr>
                    <h2>{{__('5. Your Rights & Choices')}}</h2>
                    <ul>
                        <li>{{__('Access & Update: You can review and update your personal information anytime.')}}</li>
                        <li>{{__('Opt-Out: You can unsubscribe from promotional messages.')}}</li>
                        <li>{{__('Data Deletion: You may request the deletion of your account and personal data by contacting our support team.')}}</li>
                    </ul>
                    <hr>
                    <h2>{{__('6. Cookies & Tracking Technologies')}}</h2>
                    <p>{{__('We use cookies and analytics to improve our services. You can manage cookie preferences in your browser settings.')}}</p>
                    <hr>
                    <h2>{{__('7. Third-Party Links')}}</h2>
                    <p>{{__('Our platform may contain links to external websites. We are not responsible for their privacy practices, so we encourage you to review their policies separately.')}}</p>
                    <hr>
                    <h2>{{__('8. Changes to This Policy')}}</h2>
                    <p>{{__('We may update this Privacy Policy periodically. Any significant changes will be communicated via email or app notifications.')}}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
