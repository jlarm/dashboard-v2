@component('mail::message')
    # Hi {{ $name }}

    You have been invited to join {{ $company }} compliance dashboard. Please click the link below to finish your registration.

    @component('mail::button', ['url' => $link])
        Complete Registration
    @endcomponent

    Thanks,<br>
    {{ $company }}
@endcomponent
