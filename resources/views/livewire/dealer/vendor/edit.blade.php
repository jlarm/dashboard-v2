<x-wire-elements-pro::tailwind.slide-over on-submit="send" :content-padding="false">
    <x-slot name="title">
        {{ ucwords(strtolower($vendor->name)) }}
        @if(tenant('locations'))
        <p class="text-sm text-gray-500 font-normal"> {{ $vendor->store->name ?? 'All Stores' }}</p>
        @endif
    </x-slot>

    <div class="flex flex-col h-full">
    <div class="border-t border-gray-200 p-3 flex-1 overflow-y-auto">
        <div class="mb-10 bg-gray-100 p-4 rounded-xl">
            <p class="text-sm text-gray-700 mb-2">Send new request</p>
            <form>
                <div class="flex gap-1">
                    <div>
                        <input wire:model.defer="name" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Name">
                        @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input wire:model.defer="email" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-arm-blue-500 focus:ring-arm-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Email Address">
                        @error('email')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="self-start py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-arm-blue-600 border border-arm-blue-600 text-white text-xs font-medium rounded-lg shadow-sm align-middle hover:bg-arm-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-arm-blue-300">
                        Send
                    </button>
                </div>
            </form>
        </div>
        <!-- List Group -->
        <div>
            <!-- Header Grid -->
            <div class="hidden md:grid md:grid-cols-12 md:gap-6 py-2">
                <div class="col-span-5">
                    <h5 class="text-sm text-gray-500">
                        Sent To
                    </h5>
                </div>
                <!-- End Col -->

                <div class="col-span-3">
                    <h5 class="text-sm text-gray-500">
                        Date
                    </h5>
                </div>
                <!-- End Col -->

                <div class="col-span-3">
                </div>
                <!-- End Col -->

                <div class="col-span-1">
                </div>
                <!-- End Col -->
            </div>
            <!-- End Header Grid -->

            @foreach($forms as $form)
                <!-- List -->
                <ul class="grid md:grid-cols-12 md:items-center gap-2 md:gap-6 py-3 border-t border-gray-200">
                    <!-- Item -->
                    <li class="md:col-span-5">
                        <div class="flex md:block gap-x-2">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Type:
                            </span>
                            <p class="text-xs font-medium text-gray-800">
                                {{ $form->name }}
                                <span class="block text-gray-400">{{ $form->email }}</span>
                            </p>
                        </div>
                    </li>
                    <!-- End Item -->

                    <!-- Item -->
                    <li class="col-span-3">
                        <div class="flex md:block gap-x-2">
                        <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                          Date:
                        </span>
                            <p class="text-xs text-gray-500">
                                @if(!$form->signature)
                                {{ $form->created_at->format('M d, Y') }}
                                @else
                                {{ $form->updated_at->format('M d, Y') }}
                                @endif
                            </p>
                        </div>
                    </li>
                    <!-- End Item -->

                    <!-- Item -->
                    <li class="col-span-2">
                        <div class="flex md:block gap-x-2">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Status:
                            </span>
                            <p class="text-sm text-arm-blue-600">
                                @if(!$form->signature)
                                <span class="py-1.5 px-2 inline-flex items-center gap-x-1.5 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                  Sent
                                </span>
                                @else
                                <span class="py-1.5 px-2 inline-flex items-center gap-x-1.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                  Signed
                                </span>
                                @endif
                            </p>
                        </div>
                    </li>
                    <!-- End Item -->

                    <!-- Item -->
                    <li class="col-span-2">
                        <div class="flex md:block gap-x-2 text-right">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Download:
                            </span>
                            <livewire:dealer.vendor.download :vendorForm="$form" :key="$form->id" />
                        </div>
                    </li>
                    <!-- End Item -->
                </ul>
                <!-- End List -->
            @endforeach

            <div class="mt-5">
                {{ $forms->links() }}
            </div>

            @if($vendor->created_at < \Carbon\Carbon::create(2024, 06, 23, 0, 0, 0))
            <ul class="grid md:grid-cols-12 md:items-center gap-2 md:gap-6 py-3 border-t border-gray-200">
                <!-- Item -->
                <li class="md:col-span-5">
                    <div class="flex md:block gap-x-2">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Type:
                            </span>
                        <p class="text-xs font-medium text-gray-800">
                            {{ ucwords(strtolower($vendor->contact_name)) }}
                            <span class="block text-gray-400">{{ Str::lower($vendor->contact_email) }}</span>
                        </p>
                    </div>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="col-span-3">
                    <div class="flex md:block gap-x-2">
                        <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                          Date:
                        </span>
                        <p class="text-xs text-gray-500">
                            @if(!$vendor->signature)
                                {{ $vendor->created_at->format('M d, Y') }}
                            @else
                                {{ $vendor->updated_at->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="col-span-2">
                    <div class="flex md:block gap-x-2">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Status:
                            </span>
                        <p class="text-sm text-arm-blue-600">
                            @if(!$vendor->signature)
                                <span class="py-1.5 px-2 inline-flex items-center gap-x-1.5 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                  Sent
                                </span>
                            @else
                                <span class="py-1.5 px-2 inline-flex items-center gap-x-1.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                  Signed
                                </span>
                            @endif
                        </p>
                    </div>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="col-span-2">
                    <div class="flex md:block gap-x-2 text-right">
                            <span class="md:hidden min-w-[100px] text-sm text-gray-600">
                              Download:
                            </span>
                            <livewire:dealer.vendor.old-download :vendor="$vendor" />
                    </div>
                </li>
                <!-- End Item -->
            </ul>
            @endif
        </div>
        <!-- End List Group -->
    </div>

    <div class="border-t border-gray-200 p-3 mt-auto">
        <button
            type="button"
            wire:click="$emit('modal.open', 'dealer.vendor.delete', {{ json_encode(['vendor' => $vendor->id]) }})"
            class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-red-600 text-red-600 hover:bg-red-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-red-300"
        >
            Delete
        </button>
    </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
