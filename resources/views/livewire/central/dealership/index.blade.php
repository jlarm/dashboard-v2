<div class="space-y-5">
    <div class="md:w-1/4">
        <div>
            <label for="search" class="sr-only">Search</label>
            <input type="search" name="search" id="search"
                   wire:model="search"
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                   placeholder="Search Dealerships...">
        </div>
    </div>

    <table class="min-w-full divide-y divide-gray-300">
        <thead>
        <tr>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                Name
            </th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                Consultant
            </th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                Dashboard
            </th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">
                Multiple Locations
            </th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                <span class="sr-only">Edit</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        @forelse($dealerships as $dealership)
            <tr>
                <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-0">
                    {{ $dealership->name }}
                    @role('super-admin')
                    <div
                        x-data="{
                            link: '{{ $dealership->id }}',
                            copied: false,
                            timeout: null,
                            copy () {
                                $clipboard(this.link)
                                this.copied = true
                                clearTimeout(this.timeout)
                                this.timeout = setTimeout(() => {
                                    this.copied = false
                                }, 3000)
                            }
                        }"
                    >
                        <span class="relative font-light font-mono text-gray-400 hover:cursor-pointer" x-on:click="copy">
                            {{ $dealership->id }}
                            <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 absolute -right-5 top-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                            </svg>
                        </span>
                    </div>
                    @endrole
                    <dl class="font-normal lg:hidden">
                        <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ $dealership->user->name }}</dd>
                        <dd class="mt-1 truncate text-gray-700">
                            <a class="flex items-center space-y-3" target="_blank"
                               href="https://{{ $dealership->domain }}/dashboard">
                                {{ $dealership->domain }}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5"
                                     stroke="currentColor" class="w-3 h-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                </svg>
                            </a>
                        </dd>
                    </dl>
                </td>
                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ $dealership->user->name }}</td>
                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                    <a class="flex items-center space-y-3" target="_blank"
                       href="https://{{ $dealership->domain }}/dashboard">
                        {{ $dealership->domain }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                        </svg>
                    </a>
                </td>
                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                    <span
                        class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                    {{ $dealership->locations ? 'Yes' : 'No' }}
                </span>
                </td>
                <td class="hidden py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 lg:table-cell">
                    <button
                        wire:click="$emit('slide-over.open', 'central.dealership.edit', @js(['dealership' => $dealership->id]))"
                        class="text-arm-blue-600 hover:text-arm-blue-900">Edit
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td class="py-4 pl-4 pr-3 text-center font-medium text-arm-blue-700 sm:pl-6" colspan="5">No
                    Dealerships
                    have been added.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
