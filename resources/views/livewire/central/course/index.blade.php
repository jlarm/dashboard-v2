<div class="bg-white rounded-md p-6">
    <div>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Courses</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <div class="flex justify-end">

                </div>
            </div>
        </div>
        <div>
            <div>
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($courses as $course)
                            <tr>
                                <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                    <span class="truncate">{{ $course->name }}</span>
                                </td>
                                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                    @if(is_null($course->results->first()))
                                        {{ __('Not taken yet') }}
                                    @else
                                        @if(Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() > 365)
                                            <span class="text-arm-orange-600">Outdated: Need To Retake</span>
                                        @else
                                            @if($course->results->first()->passed === 1)
                                                Passed
                                                On: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                            @else
                                                Last
                                                Attempt: {{ Carbon\Carbon::parse($course->results->first()->created_at)->format('F d, Y') }}
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-900">
                                    @if($course->results->first() && Carbon\Carbon::parse($course->results->first()->created_at)->diffInDays() < 365)
                                        @if($course->results->first() && $course->results->first()->passed === 1)
                                            <span
                                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        {{ $course->results->first()->percentage }}%
                                    </span>
                                        @elseif($course->results->first() && $course->results->first()->passed === 0)
                                            <span
                                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
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
