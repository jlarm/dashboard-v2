@component('mail::message')
    # Hi {{ $name }}

    You have been invited to join {{ $company }} as a {{ $role }}. Please click the link below to finish your registration.

    @component('mail::button', $link)
        Button Text
    @endcomponent

    Thanks,<br>
    {{ tenant('company') }}
@endcomponent
