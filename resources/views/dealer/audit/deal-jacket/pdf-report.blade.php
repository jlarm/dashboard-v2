<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Deal Jacket Report</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .page-break {
            page-break-after: always;
        }

        .stat-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            page-break-inside: avoid;
        }

        .detail-row {
            border-bottom: 1px solid #f1f5f9;
        }

        /* Prevent content from breaking across pages */
        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        /* Keep deal jacket cards together */
        .deal-jacket-card {
            page-break-inside: avoid;
        }

        /* Keep issue blocks together */
        .issue-block {
            page-break-inside: avoid;
        }

        /* Keep user sections together when possible */
        .user-section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body class="bg-white">

{{-- Cover Page --}}
<div class="w-full min-h-screen bg-white flex items-center justify-center page-break">
    <div class="max-w-4xl mx-auto px-12 text-center">
        <div class="mb-12">
            <x-application-logo class="h-16 w-auto mx-auto mb-8"/>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-12">
            <div class="space-y-6">
                <h1 class="text-5xl font-bold text-gray-900 tracking-tight">
                    Deal Jacket Report
                </h1>

                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>

                <div class="text-2xl font-semibold text-gray-700">
                    {{ $dealJacketGroup->store->name }}
                </div>

                <div class="space-y-4 pt-6 text-gray-600">
                    <div class="flex items-center justify-center gap-2 text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Completed: {{ $dealJacketGroup->created_at->format('F d, Y') }}</span>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-500 mb-2">Report Created By</p>
                        <p class="text-base font-semibold text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->phoneNumber }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Issue Count Summary --}}
<div class="w-full min-h-screen px-12 py-16 page-break">
    <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Issues Summary</h2>

    <div class="grid grid-cols-2 gap-6 max-w-4xl mx-auto">
        @foreach($issuesByUser as $userName => $count)
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 mb-1">Finance Manager</p>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ $userName }}</h3>
                    </div>
                    <div class="text-right">
                        <div class="text-4xl font-bold text-gray-900">{{ $count }}</div>
                        <p class="text-sm text-gray-500 mt-1">{{ Str::plural('Issue', $count) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-arm-blue-600 to-arm-blue-700 rounded-2xl p-8 text-white text-center">
            <p class="text-sm font-medium opacity-90 mb-2">Total Issues Found</p>
            <p class="text-5xl font-bold">{{ $totalIssues }}</p>
        </div>
    </div>
</div>

{{-- Details by User --}}
@foreach($dealJacketsByUser as $userName => $userDealJackets)
    <div class="w-full min-h-screen px-12 py-16 page-break">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-t-xl px-8 py-6">
                <h2 class="text-3xl font-bold text-white">{{ $userName }}</h2>
                <p class="text-gray-300 mt-1">{{ $issuesByUser[$userName] ?? 0 }} {{ Str::plural('Issue', $issuesByUser[$userName] ?? 0) }} Found</p>
            </div>

            <div class="bg-white rounded-b-xl border border-gray-200 border-t-0">
                @foreach($userDealJackets as $index => $dealJacket)
                    <div class="p-8 {{ $index > 0 ? 'border-t border-gray-200' : '' }}">
                        <div class="space-y-6">
                            @foreach($dealJacket['issues'] as $issue)
                                <div class="bg-red-50 border-l-4 border-red-500 rounded-r-lg p-4 issue-block">
                                    <h4 class="text-sm font-semibold text-red-900 mb-2">{{ $issue['statement'] }}</h4>
                                    @if($issue['comment'])
                                        <p class="text-sm text-red-800">{{ $dealJacket['customer_deal_number'] }} — {{ $issue['comment'] }}</p>
                                    @else
                                        <p class="text-sm text-red-800">{{ $dealJacket['customer_deal_number'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach

{{-- Details by Deal Jacket --}}
<div class="w-full min-h-screen px-12 py-16">
    <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Details by Deal Jacket</h2>

    <div class="max-w-5xl mx-auto space-y-8">
        @foreach($dealJacketDetails as $dealJacket)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden deal-jacket-card">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Customer: {{ $dealJacket['customer_name'] }}
                    </h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-2 gap-x-8 gap-y-4 mb-6">
                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Customer Number</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['customer_deal_number'] }}</dd>
                        </div>

                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Finance Manager</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['user_name'] }}</dd>
                        </div>

                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Deal Type</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['purchase_type'] ?? '—' }}</dd>
                        </div>

                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Vehicle Type</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['vehicle_type'] ?? '—' }}</dd>
                        </div>

                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Odometer Reading</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['mileage'] ? number_format($dealJacket['mileage']) : '—' }}</dd>
                        </div>

                        <div class="detail-row py-3">
                            <dt class="text-sm font-medium text-gray-500">Date of Delivery</dt>
                            <dd class="text-sm text-gray-900 mt-1">{{ $dealJacket['date_of_deal_jacket']?->format('F d, Y') ?? '—' }}</dd>
                        </div>
                    </div>

                    @if(count($dealJacket['issues']) > 0)
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Issues Found</h4>
                            <ul class="space-y-2">
                                @foreach($dealJacket['issues'] as $issue)
                                    <li class="text-sm text-gray-900">
                                        <span class="font-medium">•</span> {{ $issue['statement'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-green-600 font-medium">✓ No issues found</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
