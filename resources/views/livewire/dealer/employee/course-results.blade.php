<div class="w-full bg-white rounded-md shadow-sm shadow-gray-300">
    <div>
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full">
                <thead
                    class="text-xs font-semibold tracking-widest text-gray-600 uppercase border-t border-b border-gray-100 bg-gray-50">
                <tr>
                    <td class="px-4 py-4">Name</td>
                    <td class="px-4 py-4">Last Taken</td>
                    <td class="px-4 py-4">Pass/Fail</td>
                </tr>
                </thead>
                <tbody class="text-gray-700 whitespace-nowrap divide-y divide-gray-100">
                @foreach($courses as $course)
                    <tr>
                        <td class="px-4 py-4">
                            <div class="flex space-x-4 w-max">
                                <div class="flex-1">
                                    <span class="text-sm font-semibold text-gray-800">{{ $course->name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            @if($course->results->first())
                                {{ $course->results->first()->created_at->format('F d, Y') ?? __('-') }}
                            @else
                                {{ __('Never') }}
                            @endif
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            @if($course->results->first() && $course->results->first()->passed === 1)
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    Passed: {{ $course->results->first()->percentage }}%
                                </span>
                            @elseif($course->results->first() && $course->results->first()->passed === 0)
                                <span
                                    class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    Failed: {{ $course->results->first()->percentage }}%
                                </span>
                            @else
                                {{ __('-') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
