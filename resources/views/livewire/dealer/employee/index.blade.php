<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mb-4">
            <div class="flex justify-between items-center">
                <div class="-ml-4 flex items-center gap-x-3">
                    <div class="w-full max-w-xs mx-auto">
                        <label>
                            <input type="search" wire:model="search" placeholder="Search"
                                   class="flex w-full h-10 px-3 py-2 text-sm bg-white border rounded-md border-neutral-200 ring-offset-background placeholder:text-neutral-500 focus:border-neutral-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50"/>
                        </label>
                    </div>
                    <div class="w-full max-w-xs">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input wire:model="showIncompleteCourseUsers" name="custom-checkbox"
                                       id="custom-checkbox" type="checkbox" class="hidden peer"
                                       required>
                                <label for="custom-checkbox"
                                       class="peer-checked:[&_svg]:scale-100 text-sm font-medium text-neutral-600 peer-checked:text-arm-green-600 [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-arm-green-500 peer-checked:[&_.custom-checkbox]:bg-arm-green-500 select-none flex items-center space-x-2">
                                    <span
                                        class="flex items-center justify-center w-5 h-5 border-2 rounded custom-checkbox text-neutral-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="3"
                                             stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                      </svg>
                                    </span>
                                    <span>Incomplete Courses</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{--                    @if($showIncompleteCourses)--}}
                    {{--                        <a--}}
                    {{--                            wire:click="hideIncompleteCourses"--}}
                    {{--                            class="hover:cursor-pointer inline-flex items-center gap-x-0.5 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">--}}
                    {{--                            Clear--}}
                    {{--                            <button type="button"--}}
                    {{--                                    class="group relative -mr-1 h-3.5 w-3.5 rounded-sm">--}}
                    {{--                                <span class="sr-only">Remove</span>--}}
                    {{--                                <svg viewBox="0 0 14 14"--}}
                    {{--                                     class="h-3.5 w-3.5 stroke-gray-600/50 group-hover:stroke-gray-600/75">--}}
                    {{--                                    <path d="M4 4l6 6m0-6l-6 6"/>--}}
                    {{--                                </svg>--}}
                    {{--                                <span class="absolute -inset-1"></span>--}}
                    {{--                            </button>--}}
                    {{--                        </a>--}}
                    {{--                    @endif--}}
                </div>
                <div class="flex flex-row-reverse">
                    {{--                    @can('delete-stores')--}}
                    {{--                        @if (count($selected) > 0)--}}
                    {{--                            <x-primary-button wire:click="exportCsv" class="mr-3">--}}
                    {{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                    {{--                                     stroke-width="1.5"--}}
                    {{--                                     stroke="currentColor" class="w-4 h-4 mr-2">--}}
                    {{--                                    <path stroke-linecap="round" stroke-linejoin="round"--}}
                    {{--                                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>--}}
                    {{--                                </svg>--}}
                    {{--                                Export--}}
                    {{--                            </x-primary-button>--}}
                    {{--                        @endif--}}
                    {{--                    @endcan--}}
                </div>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            {{--                            @can('delete-stores')--}}
                            {{--                                <th scope="col" class="relative px-7 sm:w-12 sm:px-6">--}}
                            {{--                                    <input--}}
                            {{--                                        wire:model="selectPage"--}}
                            {{--                                        type="checkbox"--}}
                            {{--                                        class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-arm-blue-600 focus:ring-arm-blue-600"--}}
                            {{--                                    >--}}
                            {{--                                </th>--}}
                            {{--                            @endcan--}}
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                                Name
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact
                            </th>
                            @if(tenant('locations'))
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Store(s)
                                </th>
                            @endif
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Department
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Completed
                                Courses
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                <span class="sr-only">View</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        {{--                        @if ($selectPage)--}}
                        {{--                            <tr class="bg-gray-100" wire:key="row-message">--}}
                        {{--                                <td colspan="7"--}}
                        {{--                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">--}}
                        {{--                                    @unless($selectAll)--}}
                        {{--                                        <div>--}}
                        {{--                                                                    <span>You selected <strong>{{ $users->count() }}</strong> employees, do you want to--}}
                        {{--                                                                select--}}
                        {{--                                                                all--}}
                        {{--                                                                <strong></strong>?</span>--}}
                        {{--                                            <button wire:click="selectAll" class="text-arm-blue-500 ml-3">Select All--}}
                        {{--                                            </button>--}}
                        {{--                                        </div>--}}
                        {{--                                    @else--}}
                        {{--                                        <span>You are currently selecting all <strong></strong>--}}
                        {{--                                                                employees.</span>--}}
                        {{--                                    @endunless--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                        @endif--}}
                        @forelse($users as $user)
                            <livewire:dealer.employee.index-item :user="$user" :key="$user->id"/>
                        @empty
                            <tr>
                                <td colspan="7"
                                    class="px-4 py-4 text-center text-xl text-arm-blue-500 font-medium sm:pr-6 space-x-3">
                                    No Employees
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-10">
            @if(!$showIncompleteCourseUsers)
                {{ $users->links() }}
            @endif
        </div>
    </div>
</div>
