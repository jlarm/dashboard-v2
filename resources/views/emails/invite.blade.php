@component('mail::message')
# Hi {{ $name }}
You have been invited to join the {{ $company }} compliance dashboard. Please click the link below to finish your registration.

Please do not disregard this request. If you have any questions or concerns, please speak with your manager.
@component('mail::button', ['url' => $link])
    Complete Registration
@endcomponent
Thanks,
{{ $company }}
@endcomponent

