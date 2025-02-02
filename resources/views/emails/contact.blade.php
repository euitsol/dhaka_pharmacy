<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Contact Mail From Dhaka Pharmacy User') }}</title>
</head>

<body>

    <h2>{{ __('Dear Sir,') }}</h2>
    <p>New contact request submitted from {{ config('app.name') }} website</p>
    <p>{{ $mailData['message'] }}</p>

    <p><strong>{{ __('Best Regards,') }}</strong></p>
    <p>
        <strong>{{ __('Name') }}:</strong> {{ $mailData['name'] }}
    </p>
    <p>
        <strong>{{ __('Email') }}:</strong> {{ $mailData['email'] }}
    </p>
    <p>
        <strong>{{ __('Phone') }}:</strong> {{ $mailData['phone'] }}
    </p>
    <p>
</body>

</html>
