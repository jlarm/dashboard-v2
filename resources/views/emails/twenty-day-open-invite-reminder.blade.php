@component('mail::message')
    # Hi {{ $name }}
    This is your final reminder to join the {{ $company }} compliance dashboard. Please click the link below to finish your registration.
    If you do not complete your registration within the next 10 days, your invitation will be deleted.
    @component('mail::button', ['url' => $link])
        Complete Registration
    @endcomponent
    Thanks,
    {{ $company }}
@endcomponent
