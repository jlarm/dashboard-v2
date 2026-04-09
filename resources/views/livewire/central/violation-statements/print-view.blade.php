<div class="max-w-5xl mx-auto px-8 py-6">
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            .statement-card { break-inside: avoid; }
        }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #111; }
    </style>

    <div class="no-print mb-6 flex items-center justify-between">
        <a href="{{ route('violation-statements.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back</a>
        <button onclick="window.print()" class="rounded bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Print</button>
    </div>

    <header class="mb-8 border-b border-gray-300 pb-5">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Violation Statements</h1>
        <p class="mt-1 text-sm text-gray-500">{{ $statements->count() }} total &mdash; printed {{ now()->format('F j, Y') }}</p>
    </header>

    <div class="space-y-4">
        @foreach($statements as $statement)
            <div class="statement-card rounded border border-gray-200 p-4">
                <div class="flex items-start justify-between gap-4">
                    <p class="flex-1 text-sm leading-relaxed text-gray-900">
                        <span class="mr-1.5 text-xs font-semibold text-gray-400">{{ $loop->iteration }}.</span>
                        {{ $statement->statement }}
                    </p>
                    <span class="shrink-0 rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-semibold text-gray-700">
                        Weight: {{ $statement->weight }}
                    </span>
                </div>

                <div class="mt-2.5 flex flex-wrap gap-3 text-xs text-gray-500">
                    @if($statement->categories)
                        <div class="flex items-center gap-1.5">
                            <span class="font-semibold uppercase tracking-wide text-gray-400">Categories:</span>
                            <div class="flex flex-wrap gap-1">
                                @foreach($statement->categories as $category)
                                    <span class="rounded bg-blue-50 px-1.5 py-0.5 font-medium text-blue-700">
                                        {{ \App\Enums\ViolationStatementCategory::from($category)->label() }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($statement->keywords && count($statement->keywords) > 0)
                        <div class="flex items-center gap-1.5">
                            <span class="font-semibold uppercase tracking-wide text-gray-400">Keywords:</span>
                            <div class="flex flex-wrap gap-1">
                                @foreach($statement->keywords as $keyword)
                                    <span class="rounded bg-gray-100 px-1.5 py-0.5 text-gray-600">{{ $keyword }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>window.print()</script>
