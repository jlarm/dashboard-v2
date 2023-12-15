<tr>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
        {{ $manual->created_at->format('F d, Y') }}
    </td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 flex justify-end">
        <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="flex items-center">
            <svg wire:loading
                 class="animate-spin w-4 h-4 mr-2 text-gray-300 hover:cursor-pointer"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Download
        </a>
    </td>
</tr>
