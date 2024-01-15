<div class="px-4 sm:px-6 lg:px-8">
    <div class="flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <ul class="text-sm text-gray-700 divide-y divide-gray-100">
                    @forelse($reports as $day => $report)
                        <li class="flex justify-between gap-x-4 py-2">
                            <p>{{ $day }}</p>
                            <div class="flex gap-5">
                                @foreach($report as $r)
                                    @if($r->type === 'executive')
                                        <a
                                            target="_blank"
                                            class="text-gray-500 transition flex items-center"
                                            href="https://armp-scan-reports.nyc3.cdn.digitaloceanspaces.com/{{ $r->path }}"
                                        >
                                            Executive Report
                                        </a>
                                    @else
                                        <a
                                            target="_blank"
                                            class="text-gray-500 transition flex items-center"
                                            href="https://armp-scan-reports.nyc3.cdn.digitaloceanspaces.com/{{ $r->path }}
                                            "
                                        >
                                            Technical Report
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                    @empty
                        <li class="py-2">
                            <p>Scans are not setup or have not been run yet.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
