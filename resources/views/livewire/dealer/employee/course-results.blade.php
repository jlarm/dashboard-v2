<div>
    <div class="w-full bg-white">
        <div>
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <th scope="col"
                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Name
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Last Taken
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Pass/Fail</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($courses as $course)
                        <tr class="@if($store->state != 'California' && $course->slug === 'sexual-harassment-training-in-california') hidden @endif">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                {{ Str::limit($course->name, 40) }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($course->results->first())
                                    {{ $course->results->first()->created_at->format('F d, Y') ?? __('-') }}
                                @else
                                    {{ __('Never') }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($course->slug === 'dot-hazardous-materials-transportation' ||
                                $course->slug === 'dot-hazardous-materials-transportation-identifying-hazardous-materials' ||
                                $course->slug === 'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment' ||
                                $course->slug === 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding'
                                )
                                    @if($course->results->first() && $course->results->first()->passed === 1 && $course->results->first()->created_at < now()->subMonths(36))
                                        <span
                                            class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10">
                                    Expired
                                </span>
                                    @elseif($course->results->first() && $course->results->first()->passed === 1)
                                        <span
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Passed: {{ $course->results->first()->percentage }}%
                                </span>
                                    @elseif($course->results->first() && $course->results->first()->passed === 0)
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    Failed: {{ $course->results->first()->percentage }}%
                                </span>
                                    @else
                                        {{ __('-') }}
                                    @endif
                                @else
                                    @can('create-dealerships'){{ $course->id }}@endcan
                                    @if($course->results->first() && $course->results->first()->passed === 1 && $course->results->first()->created_at < now()->subMonths(12))
                                        <span
                                            class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10">
                                    Expired {{ $course->results->first()->created_at->format('F d, Y') }}
                                </span>
                                    @elseif($course->results->first() && $course->results->first()->passed === 1)
                                        <span
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                    Passed: {{ $course->results->first()->percentage }}%
                                </span>
                                    @elseif($course->results->first() && $course->results->first()->passed === 0)
                                        <span
                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                    Failed: {{ $course->results->first()->percentage }}%
                                </span>
                                    @else
                                        {{ __('-') }}
                                    @endif
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                @can('create-dealerships')
                                    @if(!$course->results->first())
                                        <span
                                            onclick="Livewire.emit('modal.open', 'dealer.employee.edit-course-taken', @js(['course' => $course->id, 'user' => $user->id]))"
                                            class="text-arm-blue-600 hover:text-arm-blue-900 hover:cursor-pointer">
                                    Edit
                                </span>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
{{--    <div class="mt-10">{{ $courses->links() }}</div>--}}
</div>
