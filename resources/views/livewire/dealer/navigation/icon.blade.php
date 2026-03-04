@php
    $strokeClass = $active ? 'stroke-gray-600' : 'stroke-gray-400 group-hover:stroke-gray-500';
    $auditStrokeClass = $active ? 'stroke-arm-blue-500' : 'stroke-gray-400 group-hover:stroke-gray-500';
@endphp

@switch($name)
    @case('home')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M10 2H2v8h8V2ZM22 2h-8v8h8V2ZM10 14H2v8h8v-8ZM22 14h-8v8h8v-8Z"/>
        </svg>
        @break

    @case('courses')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M7.99 2H3v19.961h17.962v-7.984"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M21.428 5.19v5.14m-2.545-3.965-.35 4.361c-1.01.967-3.632 2.195-6.061.131l-.398-4.492m3.362-4.402L9.09 4.9a.01.01 0 0 0 0 .018l2.68 1.307 3.671 1.69 3.752-1.69 2.803-1.298a.01.01 0 0 0 0-.018l-6.55-2.946a.011.011 0 0 0-.01 0Z"/>
        </svg>
        @break

    @case('employees')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M14 10.5a3 3 0 1 0 0-6M2 20.5h14a7 7 0 1 0-14 0ZM18 19.5h3a6 6 0 0 0-6-6M12.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/>
        </svg>
        @break

    @case('scans')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M3 8h18"/>
            <path class="{{ $strokeClass }}" stroke-linecap="square" stroke-linejoin="round" stroke-width="1.5" d="M7 5h.009M11 5h.009"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M14 16.5V15a2 2 0 1 0-4 0v1.5m-1.5 0h7V22h-7v-5.5Z"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M6 20H3.01a.01.01 0 0 1-.01-.01V2.01a.01.01 0 0 1 .01-.01h17.98a.01.01 0 0 1 .01.01v17.978a.01.01 0 0 1-.01.01H18"/>
        </svg>
        @break

    @case('manuals')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="m9.869 21.988-7.023.01a.01.01 0 0 1-.01-.01V9.001l7.033-6.999h10.036a.01.01 0 0 1 .01.01l-.01 8.986M9.869 2.563V9h-6.47M15.305 21.998h-2.519v-2.472l5.522-5.514a.01.01 0 0 1 .014 0l2.51 2.5a.01.01 0 0 1 0 .013l-5.527 5.473Z"/>
        </svg>
        @break

    @case('audits')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $auditStrokeClass }}" stroke-width="1.5" d="M19.007 11.493V2H3v19.985h9.004"/>
            <path class="{{ $auditStrokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M7.002 6.996h8.003m-8.003 3.997h4.002"/>
            <path class="{{ $auditStrokeClass }}" stroke-width="1.5" d="M18.863 19.838a3.371 3.371 0 0 0 1.008-2.442 3.438 3.438 0 0 0-3.44-3.436c-1.9 0-3.44 1.538-3.44 3.436a3.438 3.438 0 0 0 3.44 3.437c.937 0 1.811-.388 2.432-.995Zm0 0 2.136 2.16"/>
        </svg>
        @break

    @case('vendors')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M12.999 5c0 .351-.06.688-.171 1.001h5.17v5.17a3 3 0 1 1 0 5.658v5.17h-5.17a3 3 0 1 0-5.66 0H2.001v-5.17a3 3 0 1 0 0-5.66V6.002h5.17A3 3 0 1 1 13 5Z"/>
        </svg>
        @break

    @case('ridgeback')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
            <path class="{{ $strokeClass }}" d="M14 10.5V9C14 7.89543 13.1046 7 12 7C10.8954 7 10 7.89543 10 9V10.5M8.5 10.5H15.5V16H8.5V10.5Z" stroke="currentColor" stroke-width="1.5" />
            <path class="{{ $strokeClass }}" d="M21 11V5C16 4.5 12 2 12 2C12 2 8 4.5 3 5V11C3 18.5 12 22 12 22C12 22 21 18.5 21 11Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
        </svg>
        @break

    @case('phishing')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="m18.004 12 1.5 1.5m0 0 1.501 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5m-5.002-3 1.5 1.5m0 0 1.5 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5M8 12l1.5 1.5m0 0 1.501 1.5m-1.5-1.5 1.5-1.5m-1.5 1.5-1.5 1.5M3 12l1.5 1.5m0 0L6 15m-1.5-1.5L6 12m-1.5 1.5L3 15"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M18.626 18.099c-1.635 1.918-3.89 3.233-6.566 3.902-2.618-.586-4.966-1.95-6.68-4.034M21.496 9.06a22.456 22.456 0 0 0-.488-4.084c-3.661 0-5.408-3.043-8.98-2.976-3.624 0-5.761 3.16-9.075 2.934A21.404 21.404 0 0 0 2.5 9.06"/>
        </svg>
        @break

    @case('documents')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M6.989 6.509h14.905a.1.1 0 0 1 .1.1v4.38m-11.016 9.5H2.105a.1.1 0 0 1-.1-.1V2.6a.1.1 0 0 1 .1-.1h6.871l3.08 4.008M19.013 12.487h-4.925a.1.1 0 0 0-.1.1V21.4a.1.1 0 0 0 .1.1H21.9a.1.1 0 0 0 .1-.1v-5.897l-2.987-3.016Z"/>
        </svg>
        @break

    @case('osha-300')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M16 18.394C16 16.867 14.21 16 12 16s-4 .672-4 1.5S9.79 19 12 19c1.657 0 3 .672 3 1.5S13.657 22 12 22c-1.285 0-2.809-.711-2.973-1.645M13.5 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM12 5v11M16.242 5c-.893 2.115-3.31 5.334-4.242 5.738 4.5 5.016 9.166.435 10-1.734-.883 0-4.05-1.91-5.758-4.004ZM7.758 5c.893 2.115 3.31 5.334 4.242 5.738-4.5 5.016-9.166.435-10-1.734.883 0 4.05-1.91 5.758-4.004Z"/>
        </svg>
        @break

    @case('sds')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
            <path class="{{ $strokeClass }}" d="M22 21V11H2.00019L2 21H22Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"></path>
            <path class="{{ $strokeClass }}" d="M4 11L4.00016 7H20V11" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"></path>
            <path class="{{ $strokeClass }}" d="M6 7L6.00012 3H18V7" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"></path>
            <path class="{{ $strokeClass }}" d="M16 15L14.5 17H9.5L8 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"></path>
        </svg>
        @break

    @case('settings')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M14.953 2H9.047v2.582L7.155 5.694 4.953 4.402 2 9.598l2.202 1.291v2.222L2 14.4l2.953 5.197 2.202-1.292 1.892 1.113V22h5.906v-2.581l1.892-1.113 2.202 1.292L22 14.402l-2.201-1.291v-2.222L22 9.6l-2.953-5.197-2.202 1.292-1.892-1.112V2Z"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M15.5 12a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"/>
        </svg>
        @break

    @case('locations')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
            <path class="{{ $strokeClass }}" d="M13 2L2 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M12 3V22H7C5.11438 22 4.17157 22 3.58579 21.4142C3 20.8284 3 19.8856 3 18V7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M12 7L22 12" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M10 21.9997H17C18.8856 21.9997 19.8284 21.9997 20.4142 21.4139C21 20.8281 21 19.8853 21 17.9997V11.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M18 10L18 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M7 11H8M7 15H8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M16 14H17" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            <path class="{{ $strokeClass }}" d="M16.5 22V18" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        @break

    @case('logs')
        <svg class="mr-3 h-4 w-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path class="{{ $strokeClass }}" stroke-linejoin="round" stroke-width="1.5" d="M2.998 21h18V3h-18v18Z"/>
            <path class="{{ $strokeClass }}" stroke-width="1.5" d="M8.998 21V3M20.998 9h-18M20.998 15h-18"/>
        </svg>
        @break
@endswitch
