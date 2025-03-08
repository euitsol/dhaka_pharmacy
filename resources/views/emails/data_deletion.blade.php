<!DOCTYPE html>
<html>

<head>
    <title>{{ __('Data Deletion Request From Dhaka Pharmacy User') }}</title>
</head>

<body>
    <h2>{{ __('Dear Sir,') }}</h2>
    <p>{{ __('A user has requested to delete their data from your system.') }}</p>

    <p><strong>{{ __('Reason for Deletion') }}:</strong> {{ $mailData['reason'] ?? '' }}</p>

    <p><strong>{{ __('User Details') }}:</strong></p>
    <p>
        <strong>{{ __('Name') }}:</strong> {{ $mailData['name'] ?? '' }}
    </p>
    <p>
        <strong>{{ __('Email') }}:</strong> {{ $mailData['email'] ?? '' }}
    </p>
    <p>
        <strong>{{ __('Phone') }}:</strong> {{ $mailData['phone'] ?? '' }}
    </p>
</body>

</html>
