<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
        {{ $store->name }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $store->address }}<br>
        {{ $store->city }}, {{ $store->state }} {{ $store->zip }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{ $store->phone }}
    </td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <a href="{{ $store->website }}" target="_blank">{{ $store->website }}</a>
    </td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
        <a href="{{ route('dealer.stores.home', $store) }}"
           class="text-arm-blue-600 hover:text-arm-blue-900">View</a>
    </td>
</tr>
