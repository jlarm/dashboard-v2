<div class="col-span-2 bg-white shadow-sm border rounded-lg p-6">
    <div>
        <h3 class="text-lg font-medium text-gray-900">Top Issues</h3>
        <div class="flex flex-col text-xs divide-y">
            @foreach($issues as $index => $issue)
                <div class="flex justify-between items-center py-2.5 px-1">
                    <span>{{ $issue['statement'] }}</span>
                    <span>{{ $issue['count'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
