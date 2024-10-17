<div>
    <div class="w-full bg-white">
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    @include('components.course-table.table-header', ['text' => 'Name'])
                    @include('components.course-table.table-header', ['text' => 'Last Taken'])
                    @include('components.course-table.table-header', ['text' => 'Pass/Fail'])
                    <th></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($courses as $course)
                    @include('components.course-table.course-row', ['course' => $course, 'store' => $store, 'user' => $user])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
