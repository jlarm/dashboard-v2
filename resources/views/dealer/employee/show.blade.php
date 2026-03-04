<x-dealer-app>
    @php
        $employeeSections = [
            [
                'label' => 'Courses',
                'route' => route('dealer.employees.show', $user),
                'key' => 'courses',
            ],
        ];

        if ($canManageCourses) {
            $employeeSections[] = [
                'label' => 'Manage Courses',
                'route' => route('dealer.employees.show.manage-courses', $user),
                'key' => 'manage-courses',
            ];
        }

        $employeeSections[] = [
            'label' => 'DOT Certificates',
            'route' => route('dealer.employees.show.certificates', $user),
            'key' => 'certificates',
        ];

        if ($videosActive) {
            $employeeSections[] = [
                'label' => 'Video Training Progress',
                'route' => route('dealer.employees.show.video-progress', $user),
                'key' => 'video-progress',
            ];
        }
    @endphp

    <x-slot name="header">
        <x-slot name="pageTitle">
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    {{ $user->name }}
                    @if($isQi)
                        <span x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false" class="group inline-flex items-center gap-x-0.5 text-xs font-medium text-green-500">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none">
                                <path d="M4.9971 5.0071C4.9971 5.00158 5.00158 4.9971 5.0071 4.9971H8.99876L11.9929 2.00293C11.9968 1.99902 12.0032 1.99902 12.0071 2.00293L15.0012 4.9971H18.9929C18.9984 4.9971 19.0029 5.00158 19.0029 5.0071V8.99876L21.9971 11.9929C22.001 11.9968 22.001 12.0032 21.9971 12.0071L19.0029 15.0012V18.9929C19.0029 18.9984 18.9984 19.0029 18.9929 19.0029H15.0012L12.0071 21.9971C12.0032 22.001 11.9968 22.001 11.9929 21.9971L9.00169 19.0058C8.99981 19.004 8.99727 19.0029 8.99461 19.0029H5.0071C5.00158 19.0029 4.9971 18.9984 4.9971 18.9929V15.0012L2.00293 12.0071C1.99902 12.0032 1.99902 11.9968 2.00293 11.9929L4.9971 8.99876V5.0071Z" stroke="currentColor" stroke-width="1.5" />
                                <path d="M9 12.8929C9 12.8929 10.2 13.5447 10.8 14.5C10.8 14.5 12.6 10.75 15 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" />
                            </svg>
                            <span x-show="show" x-cloak x-transition.opacity.duration.50ms class="whitespace-nowrap">Qualified Individual</span>
                        </span>
                   @endif
                </div>
                <ul class="flex flex-wrap items-center gap-x-3 font-normal">
                    <li class="relative before:hidden md:before:inline-block first:before:hidden first:before:ms-0 before:content-['•'] before:text-gray-800 before:me-1.5">
                      <span class="text-xs text-gray-800">
                        Department:
                      </span>
                        <span class="inline-flex items-center gap-x-2 text-xs text-gray-500">
                        {{ $user->department->name ?? '' }}
                      </span>
                    </li>

                    <li class="relative before:hidden md:before:inline-block first:before:hidden first:before:ms-0 before:content-['•'] before:text-gray-800 before:me-1.5">
                      <span class="text-xs text-gray-800">
                        Role:
                      </span>
                        <span class="inline-flex items-center gap-x-2 text-xs text-gray-500">
                    @foreach($roles as $role)
                                {{ $role }}
                            @endforeach
                  </span>
                    </li>

                    <li class="relative before:hidden md:before:inline-block first:before:hidden first:before:ms-0 before:content-['•'] before:text-gray-800 before:me-1.5">
                      <span class="text-xs text-gray-800">
                        Email:
                      </span>
                        <span class="inline-flex items-center gap-x-2 text-xs text-gray-500">
                        {{ Str::lower($user->email) }}
                      </span>
                    </li>
                </ul>
            </div>
            <x-slot name="actions">
                <livewire:dealer.employee.details :user="$user"/>
            </x-slot>
        </x-slot>
    </x-slot>
    <div class="">
        <div class="col-span-3">
            <div class="w-full">
                <div class="flex justify-center">
                    <div class="inline-flex h-10 max-w-[900px] rounded-lg bg-gray-800/5 p-1">
                        @foreach($employeeSections as $employeeSection)
                            <a
                                href="{{ $employeeSection['route'] }}"
                                class="{{ $section === $employeeSection['key'] ? 'shadow-sm bg-white text-gray-600' : 'border-transparent text-gray-600 hover:text-gray-800' }} flex flex-1 items-center justify-center whitespace-nowrap rounded-md px-4 text-sm"
                                @if($section === $employeeSection['key']) aria-current="page" @endif
                            >
                                {{ $employeeSection['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white">
                    @if($section === 'courses')
                        <section class="p-4">
                            @if($user->department)
                                <livewire:dealer.employee.course-results :user="$user"/>
                            @endif
                        </section>
                    @elseif($section === 'manage-courses')
                        <section class="p-4">
                            @if($user->department)
                                <livewire:dealer.employee.assign-custom-courses-form :user="$user" :autoload="true" />
                            @endif
                        </section>
                    @elseif($section === 'certificates')
                        <section class="p-4">
                            <div class="col-span-1">
                                <livewire:dealer.employee.dot-cert :user="$user" :autoload="true" />
                                <livewire:dealer.employee.cert-index :user="$user" :autoload="true" />
                            </div>
                        </section>
                    @elseif($section === 'video-progress')
                        <section class="p-4">
                            <div class="col-span-1">
                                <livewire:tenant.employee.video-progress :user="$user" :autoload="true" />
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dealer-app>
