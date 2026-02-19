<div>
    @if(! $isLoaded)
        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 mt-6">
            Select the "DOT Certificates" tab to load certificates.
        </div>
    @elseif(count($certs) > 0)
        <div class="max-w-xl mx-auto border rounded-md mt-10 p-3">
            <div>
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($certs as $cert)
                        <li class="flex items-center justify-between gap-x-6">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold text-gray-900">{{ $cert->course_name }} Certificate</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $cert->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ $this->temporaryUrl($cert->file_name) }}" target="_blank" class="text-arm-blue-600 hover:text-arm-blue-900 text-sm">Download</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
