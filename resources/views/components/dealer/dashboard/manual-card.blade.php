<a
    class="group p-4 bg-white border border-gray-200 rounded-xl hover:shadow-lg hover:-translate-y-0.5 focus:outline-hidden focus:shadow-lg focus:-translate-y-0.5 transition"
    href="{{ route('dealer.manual.' . $link . '.index') }}"
>
    <div class="flex gap-x-3">
        <div class="grow">
            <p class="font-semibold text-gray-800">
                {{ $title }}
            </p>
        </div>
        {{ $icon }}
    </div>
    <span
        @class([
            'mt-3 inline-flex items-center gap-x-1 text-sm font-medium',
            'text-teal-600 group-hover:text-teal-500 group-focus:text-teal-500' => $status,
            'text-red-600 group-focus:text-red-500' => !$status,
        ])
    >
      {{ $status ? 'Active' : 'Needs to be signed' }}
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
    </span>
</a>
