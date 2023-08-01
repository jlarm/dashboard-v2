<div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            Name
                        </th>
                        <th scope="col"
                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Date
                            Completed
                        </th>
                        <th scope="col"
                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Score
                        </th>
                        <th scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Take</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($courses as $course)
                        <tr>
                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                {{ $course->name }}
                            </td>
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                @if(is_null($course->results->first()))
                                    {{ __('Not taken yet') }}
                                @else
                                    @if(Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() > 365)
                                        <span class="text-arm-orange-600">Outdated: Need To Retake</span>
                                    @else
                                        @if($course->results->first()->passed === 1)
                                            <span class="text-green-500">
                                            Passed On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                        </span>
                                        @else
                                            <span class="text-red-800">
                                            Last Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                        </span>
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                @if($course->results->first() && Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() < 365)
                                    @if($course->results->first() && $course->results->first()->passed === 1)
                                        <span
                                            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                        {{ $course->results->first()->percentage }}%
                                    </span>
                                    @elseif($course->results->first() && $course->results->first()->passed === 0)
                                        <span
                                            class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                        {{ $course->results->first()->percentage }}%
                                    </span>
                                    @else
                                        {{ __('') }}
                                    @endif
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                @if(count($course->questions))
                                    <a href="{{ route('courses.show', $course) }}"
                                       class="text-arm-blue-600 hover:text-arm-blue-900">Take<span
                                            class="sr-only">, {{ $course->name }}</span></a>
                                @else
                                    <span class="text-gray-300">No quiz</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t pt-5 mt-5">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
</div>
