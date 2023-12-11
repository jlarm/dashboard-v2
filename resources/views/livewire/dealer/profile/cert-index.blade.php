<div>
    @if(count($certs) > 0)
    <div class="p-4 sm:p-8 bg-white border sm:rounded-lg">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Certificates') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('List of all current and previous course certificates.') }}
            </p>
        </header>

        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Course</th>
                <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Date of Completion</th>
                <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($certs as $cert)
                <livewire:dealer.profile.cert-index-item :cert="$cert" :key="$cert->id" />
            @endforeach
            </tbody>
        </table>

    </div>
    @endif
</div>
