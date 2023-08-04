<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url('/favicon.svg') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/ios-icon.png') }}">

    <title>@if(tenant('company'))
            {{ tenant('company') }} |
        @endif{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;900&display=swap"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">
{{--<div class="w-full h-screen bg-white grid grid-cols-8 grid-rows-6">--}}
{{--    <div class="col-span-3 col-start-1 p-20">--}}
{{--        <x-application-logo class="h-auto w-full"/>--}}
{{--    </div>--}}
{{--    <div class="col-span-5 row-span-4 col-start-1 row-start-2 bg-arm-blue-500 z-10 py-10 pr-10">--}}
{{--        <div class="w-full h-full flex flex-row items-center border-t border-r border-b border-white ">--}}
{{--            <div class="flex flex-col ml-10">--}}
{{--                <h1 class="text-7xl text-white">Deal Jacket Report<span--}}
{{--                        class="block font-bold">{{ $audit->store->name }}</span></h1>--}}
{{--                <p class="text-white text-2xl my-10">Complete On: {{ $audit->audit_date->format('n/d/Y') }}</p>--}}
{{--                <p class="text-white text-2xl">Report Created By:</p>--}}
{{--                <p class="text-white text-xl">--}}
{{--                    {{ $audit->user->name }}<br/>--}}
{{--                    {{ $audit->user->phoneNumber }}<br/>--}}
{{--                    {{ $audit->user->email }}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div--}}
{{--        style="background-image: url('{{ url('deal-jacket-audit-bg.jpg') }}');"--}}
{{--        class="col-span-5 row-span-6 bg-arm-orange-500 col-start-4 row-start-1 z-0 bg-cover"></div>--}}
{{--</div>--}}
<div class="w-full h-screen">
    {{ dd($audits) }}
    {{--    @foreach($audits as $manager => $audit)--}}
    {{--        Manager Name: {{ $manager }}<br/><br/><br/>--}}
    {{--        @foreach($audit as $issue)--}}
    {{--            {{ $issue->deal_jacket_date }}<br/><br/><br/><br/>--}}
    {{--        @endforeach--}}
    {{--    @endforeach--}}
</div>
<div class="w-full h-screen p-10">
    <h1 class="text-5xl text-center font-bold">Details by Finance Manager</h1>
    <div class="prose min-w-full mt-20">
        <div>
            <h2 class="w-full bg-gray-50 p-3 text-center">Frank Thomas</h2>
            <h3 class="text-arm-orange-500">9 Issues found</h3>
            <h4>Buyers Guide Filled Out Improperly</h4>
            <p>All information on the Buyers Guide must be accurate</p>
            <table>
                <tbody>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>INCORRECT BG (IMPLIED WARRANT NEEDED, NOT AS IS) AND POC NOT LISTED</td>
                </tr>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>INCORRECT BG (IMPLIED WARRANT NEEDED, NOT AS IS) AND POC NOT LISTED</td>
                </tr>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>INCORRECT BG (IMPLIED WARRANT NEEDED, NOT AS IS) AND POC NOT LISTED</td>
                </tr>
                </tbody>
            </table>
            <h4>Credit Score Disclosure: Not Found, Improper Form, or No Acknowledgement</h4>
            <p>Dealers must provide all credit applicants with a Credit Score Disclosure (CSD), which must contain the
                consumer's credit score, additional information pertaining to that score and standardized educational
                information about credit reports and credit scores. If a credit score for a customer is not available
                (e.g.,
                due to insufficient credit history), then a “No Score Disclosure” (NSD) form, different from the notice
                used
                to convey a consumer’s credit score, must be provided to that consumer. If multiple credit reporting
                agencies are unable to provide credit scores, a NSD form should be generated for each “no score”
                agency.</p>
            <p>It is recommended that dealers require customers to sign copies of the CSD and/or the NSD so the dealer
                can
                prove the notice was provided.</p>
            <p>It is essential that the signature does not obscure any of the language on either form. The
                customer-signed
                copy should be retained in the deal jacket.</p>
            <table>
                <tbody>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>NO COPY IN DEAL</td>
                </tr>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>NO COPY IN DEAL</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div>
            <h2 class="w-full bg-gray-50 p-3 text-center">Jane Doe</h2>
            <h3 class="text-arm-orange-500">2 Issues found</h3>
            <h4>Buyers Guide Filled Out Improperly</h4>
            <p>All information on the Buyers Guide must be accurate</p>
            <table>
                <tbody>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>INCORRECT BG (IMPLIED WARRANT NEEDED, NOT AS IS) AND POC NOT LISTED</td>
                </tr>
                </tbody>
            </table>
            <h4>Credit Score Disclosure: Not Found, Improper Form, or No Acknowledgement</h4>
            <p>Dealers must provide all credit applicants with a Credit Score Disclosure (CSD), which must contain the
                consumer's credit score, additional information pertaining to that score and standardized educational
                information about credit reports and credit scores. If a credit score for a customer is not available
                (e.g.,
                due to insufficient credit history), then a “No Score Disclosure” (NSD) form, different from the notice
                used
                to convey a consumer’s credit score, must be provided to that consumer. If multiple credit reporting
                agencies are unable to provide credit scores, a NSD form should be generated for each “no score”
                agency.</p>
            <p>It is recommended that dealers require customers to sign copies of the CSD and/or the NSD so the dealer
                can
                prove the notice was provided.</p>
            <p>It is essential that the signature does not obscure any of the language on either form. The
                customer-signed
                copy should be retained in the deal jacket.</p>
            <table>
                <tbody>
                <tr>
                    <td><strong>19428</strong></td>
                    <td>NO COPY IN DEAL</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="prose min-w-full">
        <h1 class="text-5xl text-center font-bold my-10">Details by Deal Jacket</h1>
        <div class="w-1/3">
            <table>
                <tbody>
                <tr>
                    <td>Stock Number:</td>
                    <td>19508</td>
                </tr>
                <tr>
                    <td>Finance Manager:</td>
                    <td>Frank Thomas</td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td>John Doe</td>
                </tr>
                <tr>
                    <td>Deal Type:</td>
                    <td>Cash</td>
                </tr>
                <tr>
                    <td>Vehicle Type:</td>
                    <td>New</td>
                </tr>
                <tr>
                    <td>Odometer Reading:</td>
                    <td>80</td>
                </tr>
                <tr>
                    <td>Date of Delivery:</td>
                    <td>7-21-2023</td>
                </tr>
                </tbody>
            </table>
            <h4>F&I Menu Missing or Terms Differ From Contract</h4>
        </div>
        <p>No law mandates the price at which various aftermarket products may be sold. That said, not having standard
            pricing in place can result in problems when a consumer pays more than most customers—particularly if
            certain protected classes of consumers tend to pay more than others. Also, some customers have accused
            dealers of failing to offer them an available F&I product that they would have purchased if they had known
            about it. To avoid potential actions by regulators (or consumer attorneys), it is recommended that dealers
            implement standardized pricing for aftermarket goods and services sold in the finance department, and that
            these prices be presented to consumers in a uniform manner through a “menu” system. Always print a final
            menu that matches the agreed upon terms that will be printed on the final agreements.</p>
    </div>
</div>
</body>
</html>
