<div class="shadow-sm sm:rounded-lg">
    <div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full overflow-hidden align-middle">
                <table class="min-w-full">
                    <thead
                        class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                    <tr>
                        <td class="px-4 py-4">Name</td>
                        <td class="px-4 py-4">Email</td>
                        <td class="px-4 py-4">Phone</td>
                        <td class="px-4 py-4">Role</td>
                        <td class="px-4 py-4">Courses</td>
                        <td class="px-4 py-4">&nbsp;</td>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700 whitespace-nowrap">
                    @foreach($users as $user)
                        <livewire:dealer.employee.manager-index-item :user="$user" :key="$user->id"/>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
