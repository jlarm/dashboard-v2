<div class="space-y-4">
    <div class="w-1/4">
        <div>
            <label for="search" class="sr-only">Email</label>
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Employees...">
        </div>
    </div>
    <div class="overflow-hidden rounded border">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Phone</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Completed Courses</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            @foreach($users as $user)
                <livewire:central.employee.index-item :user="$user" :key="$user->id"/>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
