<tr>
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $user->name }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->phone }}</td>
    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->roles->first()->name }}</td>
    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-5">
            <a href="{{ route('employees.view', $user) }}" class="text-arm-blue-600 hover:text-arm-blue-900">View<span class="sr-only">, {{ $user->name }}</span></a>
{{--            <a href="#" class="text-arm-blue-600 hover:text-arm-blue-900">Edit<span class="sr-only">, {{ $user->name }}</span></a>--}}
{{--            <button--}}
{{--                class="text-red-500 hover:text-red-700"--}}
{{--                wire:click="$emit('modal.open', 'central.employee.delete',  @js(['user' => $user->id]))"--}}
{{--            >--}}
{{--                Delete--}}
{{--            </button>--}}
    </td>
</tr>
