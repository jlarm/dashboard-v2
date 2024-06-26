<div class="space-y-5">
    <div class="grid grid-cols-2 gap-5">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Documents</h1>
        </div>
        <div class="flex justify-end space-x-5">
            @can('delete-dealerships')
            <x-primary-link-button href="{{ route('docs.create') }}">Upload</x-primary-link-button>
            @endcan
            <div>
                <div>
                    <label for="search" class="sr-only">Search Documents</label>
                    <input type="search" name="search" id="search"
                           wire:model="search"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm"
                           placeholder="Search Documents...">
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 xl:gap-5">
        @forelse($docs as $doc)
            <div class="flex flex-col bg-white border border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="relative group">

                    <!-- More Dropdown -->
                    <div class="absolute top-3 end-3">
                        <div class="p-0.5 sm:p-1 inline-flex items-center bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                            <!-- Button Icon -->
                            <livewire:central.docs.download :document="$doc"/>
                            <!-- End Button Icon -->

                            <div class="w-px h-5 mx-1 bg-gray-200 dark:bg-neutral-700"></div>

                            <!-- Button Icon -->
                            @can('delete-dealerships')
                            <div class="hs-tooltip inline-block">
                                <button wire:click="$emit('modal.open', 'central.docs.delete',  @js(['doc' => $doc->id]))" type="button" class="hs-tooltip-toggle size-[30px] inline-flex justify-center items-center gap-x-2 rounded-lg border border-transparent text-red-600 hover:bg-red-100  disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-red-100 dark:text-red-500 dark:hover:bg-red-500/20 dark:focus:bg-red-500/20" data-hs-overlay="#hs-pro-dupfmdl">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                                </button>

                                <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 inline-block absolute invisible z-20 py-1.5 px-2.5 bg-gray-900 text-xs text-white rounded-lg dark:bg-neutral-700" role="tooltip" data-popper-placement="bottom" style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(772px, 53px, 0px);">
                                    Delete
                                </span>
                            </div>
                            @endcan
                            <!-- End Button Icon -->
                        </div>
                    </div>
                    <!-- End More Dropdown -->
                </div>

                <!-- Body -->
                <div class="p-3 flex items-center gap-x-3">
                    <!-- Icon -->
                    <svg class="flex-shrink-0 size-7" width="400" height="492" viewBox="0 0 400 492" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip2)">
                            <path d="M50.7496 -0.174609C22.9188 -0.174609 -0.0878906 22.4611 -0.0878906 50.6629V440.664C-0.0878906 468.495 22.5478 491.502 50.7496 491.502H349.095C376.926 491.502 399.932 468.866 399.932 440.664V119.683C399.932 119.683 400.675 110.406 396.593 101.129C392.882 92.5945 386.574 86.6573 386.574 86.6573L312.729 13.9263C312.729 13.9263 306.421 7.98906 297.144 3.90722C286.012 -0.916768 274.88 -0.174609 274.88 -0.174609H50.7496Z" fill="currentColor" class="fill-red-500"></path>
                            <path d="M50.7494 16.5238H274.508C274.508 16.5238 283.414 16.5238 290.094 19.4924C296.402 22.09 300.855 26.1718 300.855 26.1718L374.699 98.5317C374.699 98.5317 379.152 103.356 381.378 108.18C383.234 112.262 383.234 119.312 383.234 119.312V119.683V441.035C383.234 459.96 368.02 475.174 349.095 475.174H50.7494C31.8245 475.174 16.6104 459.96 16.6104 441.035V50.6629C16.6104 31.738 31.8245 16.5238 50.7494 16.5238Z" fill="currentColor" class="fill-white dark:fill-neutral-800"></path>
                            <path d="M99.7314 292.976C88.2281 281.472 100.845 265.887 134.242 248.818L155.393 238.427L163.557 220.245C168.009 210.226 175.06 193.898 178.771 184.25L185.45 166.439L180.626 153.08C174.689 136.752 172.833 112.261 176.544 103.356C181.368 91.4812 197.696 92.5944 204.004 105.582C209.199 115.601 208.457 133.784 202.52 156.791L197.696 175.715L202.148 183.137C204.375 187.219 211.425 196.867 217.363 204.288L228.866 218.389L242.967 216.534C288.238 210.597 303.452 220.616 303.452 235.088C303.452 253.27 267.829 254.755 238.143 233.974C231.464 229.15 227.011 224.698 227.011 224.698C227.011 224.698 208.457 228.408 199.18 231.006C189.532 233.603 185.079 235.088 170.978 239.912C170.978 239.912 166.154 246.962 162.814 252.157C150.94 271.453 137.21 287.038 127.191 292.976C117.172 298.171 105.669 298.542 99.7314 292.976ZM117.914 286.296C124.222 282.214 137.581 267 146.487 252.528L150.198 246.591L133.499 255.126C107.895 268.113 96.0207 280.359 101.958 287.781C105.298 291.862 109.75 291.491 117.914 286.296ZM285.27 239.541C291.578 235.088 290.836 226.182 283.414 222.471C277.848 219.502 273.395 219.131 258.923 219.131C250.017 219.874 235.916 221.358 233.319 222.1C233.319 222.1 241.112 227.666 244.451 229.522C248.904 232.119 260.407 236.943 268.571 239.541C276.735 242.138 281.559 242.138 285.27 239.541ZM217.734 211.339C214.023 207.257 207.344 199.093 203.262 192.785C197.696 185.735 195.098 180.911 195.098 180.911C195.098 180.911 191.016 193.527 188.048 201.32L178.029 226.182L175.06 231.748C175.06 231.748 190.645 226.553 198.438 224.698C206.972 222.471 223.671 219.131 223.671 219.131L217.734 211.339ZM196.211 124.507C197.324 116.343 197.696 108.18 195.098 104.098C187.677 96.3051 179.142 102.613 180.626 121.538C180.997 127.847 182.853 138.979 184.708 145.658L188.419 157.904L191.016 148.627C192.501 143.803 194.727 132.671 196.211 124.507Z" fill="currentColor" class="fill-red-500"></path>
                            <path d="M119.398 346.04H137.952C143.889 346.04 148.713 346.782 152.424 347.895C156.135 349.008 159.104 351.606 161.701 355.316C164.299 359.027 165.412 363.851 165.412 369.046C165.412 373.87 164.299 378.323 162.443 381.663C160.217 385.374 157.619 387.971 154.28 389.455C150.94 390.94 145.374 391.682 138.323 391.682H132.015V420.997H119.398V346.04ZM132.015 355.688V382.034H138.323C143.889 382.034 147.6 380.921 149.827 379.065C152.053 376.839 153.166 373.499 153.166 369.046C153.166 365.707 152.424 362.738 150.94 360.512C149.456 358.285 147.971 357.172 146.487 356.43C145.003 356.059 142.034 355.688 138.694 355.688H132.015Z" fill="currentColor" class="fill-black dark:fill-white"></path>
                            <path d="M175.431 346.04H192.501C200.664 346.04 207.344 347.524 212.168 350.492C216.992 353.461 220.702 357.543 223.3 363.48C225.898 369.046 227.011 375.726 227.011 382.405C227.011 389.827 225.898 396.506 223.671 402.072C221.445 407.638 218.105 412.462 213.281 415.802C208.828 419.513 202.149 420.997 193.243 420.997H175.431V346.04ZM187.677 356.059V411.349H192.872C200.293 411.349 205.488 408.751 208.828 403.927C212.168 398.732 213.652 392.053 213.652 383.889C213.652 365.336 206.602 356.059 192.872 356.059H187.677Z" fill="currentColor" class="fill-black dark:fill-white"></path>
                            <path d="M238.885 346.04H280.816V356.059H251.501V378.694H274.879V388.713H251.501V421.368H238.885V346.04Z" fill="currentColor" class="fill-black dark:fill-white"></path>
                        </g>
                        <defs>
                            <clipPath id="clip2">
                                <rect width="400" height="491.75" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    <!-- End Icon -->

                    <div class="grow truncate">
                        <p class="block truncate text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            {{ $doc->title }}
                        </p>
                        <p class="block truncate text-xs text-gray-500 dark:text-neutral-500 font-mono">
                            {{ $doc->file_name }}
                        </p>
                    </div>
                </div>
                <!-- End Body -->
            </div>
        @empty
            <!-- Empty State -->
            <div class="p-5 min-h-96 flex flex-col justify-center items-center text-center w-full col-span-4">
                <svg class="w-48 mx-auto mb-4" width="178" height="90" viewBox="0 0 178 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" fill="currentColor" class="fill-white dark:fill-neutral-800"/>
                    <rect x="27" y="50.5" width="124" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-50 dark:stroke-neutral-700/10"/>
                    <rect x="34.5" y="58" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                    <rect x="66.5" y="61" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                    <rect x="66.5" y="73" width="77" height="6" rx="3" fill="currentColor" class="fill-gray-50 dark:fill-neutral-700/30"/>
                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" fill="currentColor" class="fill-white dark:fill-neutral-800"/>
                    <rect x="19.5" y="28.5" width="139" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100 dark:stroke-neutral-700/30"/>
                    <rect x="27" y="36" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                    <rect x="59" y="39" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                    <rect x="59" y="51" width="92" height="6" rx="3" fill="currentColor" class="fill-gray-100 dark:fill-neutral-700/70"/>
                    <g filter="url(#filter19)">
                        <rect x="12" y="6" width="154" height="40" rx="8" fill="currentColor" class="fill-white dark:fill-neutral-800" shape-rendering="crispEdges"/>
                        <rect x="12.5" y="6.5" width="153" height="39" rx="7.5" stroke="currentColor" class="stroke-gray-100 dark:stroke-neutral-700/60" shape-rendering="crispEdges"/>
                        <rect x="20" y="14" width="24" height="24" rx="4" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700 "/>
                        <rect x="52" y="17" width="60" height="6" rx="3" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                        <rect x="52" y="29" width="106" height="6" rx="3" fill="currentColor" class="fill-gray-200 dark:fill-neutral-700"/>
                    </g>
                    <defs>
                        <filter id="filter19" x="0" y="0" width="178" height="64" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="6"/>
                            <feGaussianBlur stdDeviation="6"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.03 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1187_14810"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1187_14810" result="shape"/>
                        </filter>
                    </defs>
                </svg>

                <div class="max-w-sm mx-auto">
                    <p class="mt-2 font-medium text-gray-800 dark:text-neutral-200">
                        No documents
                    </p>
                </div>
            </div>
            <!-- End Empty State -->
        @endforelse
    </div>
    <div>
        {{ $docs->links() }}
    </div>
</div>
