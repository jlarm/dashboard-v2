<table class="min-w-full divide-y divide-gray-300">
    <thead class="bg-gray-50">
    <tr>
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Deleted</th>
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Edit</span>
        </th>
    </tr>
    </thead>
    <tbody class="divide-y divide-gray-200 bg-white">
    @foreach($users as $user)
        <tr>
            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $user->name }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->phone }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->roles->first()->name }}</td>
            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->deleted_at->format('F d, Y') }}</td>
            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 space-x-5">
                <button
                    class="text-arm-blue-600 hover:text-arm-blue-900"
                    wire:click="$emit('modal.open', 'central.employee.restore',  @js(['user' => $user->id]))"
                >
                    Restore
                </button>
                <button
                    class="text-red-500 hover:text-red-700"
                    wire:click="$emit('modal.open', 'central.employee.delete',  @js(['user' => $user->id]))"
                >
                    Permanently Delete
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
