<div>
    <h2 class="inline-block font-semibold text-gray-800 dark:text-neutral-200 mb-5">
        Manuals
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <!-- Card -->
        <div class="p-4 group relative flex flex-col border border-gray-200 bg-white hover:border-gray-300 dark:bg-neutral-800 dark:border-neutral-700/50 dark:hover:border-neutral-700 rounded-lg">
            <div class="h-full flex gap-x-5">
                <div class="flex-shrink-0 size-8">
                    <svg class="flex-shrink-0 size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#4a90e2" fill="none">
                        <path d="M3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 13.9761 20.3643 15.8009 19.2858 17.2848L20.8746 18.4998C22.2104 16.6787 23 14.4302 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 14.4302 1.78926 16.6789 3.12504 18.5L4.71413 17.2848C3.6357 15.8009 3 13.976 3 12Z" fill="currentColor" />
                        <path d="M7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12C17 13.0615 16.6701 14.0442 16.1064 14.8535L17.6963 16.0693C18.5165 14.9227 19 13.5169 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 13.5169 5.48345 14.9226 6.30371 16.0692L7.89352 14.8535C7.32984 14.0442 7 13.0614 7 12Z" fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 21V12H13V21H15V23H9V21H11Z" fill="currentColor" />
                    </svg>
                </div>

                <div class="grow">
                    <div class="h-full flex flex-col">
                        <div>
                            <h3 class="inline-flex items-center gap-x-1 font-medium text-gray-800 dark:text-neutral-200">
                                ISP
                                @if(!$isp)
                                <span class="relative ml-2 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="pt-1 mt-auto">
                            @if(!$isp)
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium group-disabled:opacity-50 group-disabled:pointer-events-none text-red-600 group-hover:text-red-700 group-hover:underline group-hover:decoration-2 dark:text-blue-500 dark:group-hover:text-blue-400">
                                  Needs to be Signed
                                </span>
                            @else
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium text-green-600 dark:text-green-500">
                              Signed
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <a class="after:absolute after:inset-0 after:z-10" href="{{ route('dealer.manual.isp.index') }}"></a>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="p-4 group relative flex flex-col border border-gray-200 bg-white hover:border-gray-300 dark:bg-neutral-800 dark:border-neutral-700/50 dark:hover:border-neutral-700 rounded-lg">
            <div class="h-full flex gap-x-5">
                <div class="flex-shrink-0 size-8">
                    <svg class="flex-shrink-0 size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#417505" fill="none">
                        <path d="M17.5 22.75C18.8807 22.75 20 21.6307 20 20.25C20 18.8693 18.8807 17.75 17.5 17.75C16.1193 17.75 15 18.8693 15 20.25C15 21.6307 16.1193 22.75 17.5 22.75Z" fill="currentColor" />
                        <path d="M6.5 22.75C5.11929 22.75 4 21.6307 4 20.25C4 18.8693 5.11929 17.75 6.5 17.75C7.88071 17.75 9 18.8693 9 20.25C9 21.6307 7.88071 22.75 6.5 22.75Z" fill="currentColor" />
                        <path d="M20.5001 7.25C20.2553 7.24998 20.0259 7.36939 19.8856 7.56991L16.4594 12.4646L13.0641 14.8897C12.867 15.0305 12.75 15.2578 12.75 15.5V20.0001C12.75 20.4144 13.0858 20.7501 13.5 20.7501H13.7831C13.7613 20.5865 13.75 20.4196 13.75 20.25C13.75 18.1789 15.4289 16.5 17.5 16.5C19.5711 16.5 21.25 18.1789 21.25 20.25C21.25 20.4196 21.2387 20.5865 21.2169 20.7501H22V12.2501H18.4405L20.8905 8.75004L21.9999 8.75014L22.0001 7.25014L20.5001 7.25Z" fill="currentColor" />
                        <path d="M3.5 7.25C3.74476 7.24998 3.97414 7.36939 4.1145 7.56991L7.5407 12.4646L10.936 14.8897C11.1331 15.0305 11.2501 15.2578 11.2501 15.5V20.0001C11.2501 20.4144 10.9143 20.7501 10.5001 20.7501H10.217C10.2388 20.5865 10.2501 20.4196 10.2501 20.25C10.2501 18.1789 8.57114 16.5 6.50007 16.5C4.429 16.5 2.75007 18.1789 2.75007 20.25C2.75007 20.4196 2.76132 20.5865 2.78313 20.7501H2.00007V12.2501H5.5596L3.1096 8.75004L2.00014 8.75014L2 7.25014L3.5 7.25Z" fill="currentColor" />
                        <path d="M13.1755 1.79931C13.0947 1.50827 12.8471 1.29412 12.5475 1.25601C12.2478 1.21791 11.9546 1.36328 11.8034 1.62483L10.6314 3.65354L7.92138 2.33253C7.64066 2.1957 7.30453 2.24712 7.07757 2.46164C6.85061 2.67616 6.78033 3.00886 6.90114 3.29684L8.17554 6.33467L6.79645 6.7236C6.52969 6.79883 6.32618 7.01504 6.2672 7.28585C6.20822 7.55666 6.3034 7.83792 6.51471 8.01726L9.52459 10.5718C9.66014 10.6869 9.83213 10.75 10.0099 10.75H11.9181L11.0039 7.32752L12.4531 6.94043L13.4707 10.75H15.0346C15.3432 10.75 15.6203 10.561 15.7329 10.2736L17.6983 5.25694C17.8054 4.98376 17.7433 4.67325 17.5394 4.46224C17.3356 4.25123 17.0274 4.17847 16.7507 4.27602L14.1209 5.20309L13.1755 1.79931Z" fill="currentColor" />
                    </svg>
                </div>

                <div class="grow">
                    <div class="h-full flex flex-col">
                        <div>
                            <h3 class="inline-flex items-center gap-x-1 font-medium text-gray-800 dark:text-neutral-200">
                                OSHA
                                @if(!$osha)
                                    <span class="relative ml-2 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="pt-1 mt-auto">
                            @if(!$osha)
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium group-disabled:opacity-50 group-disabled:pointer-events-none text-red-600 group-hover:text-red-700 group-hover:underline group-hover:decoration-2 dark:text-blue-500 dark:group-hover:text-blue-400">
                              Needs to be Signed
                            </span>
                            @else
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium text-green-600 dark:text-green-500">
                              Signed
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <a class="after:absolute after:inset-0 after:z-10" href="{{ route('dealer.manual.osha.index') }}"></a>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="p-4 group relative flex flex-col border border-gray-200 bg-white hover:border-gray-300 dark:bg-neutral-800 dark:border-neutral-700/50 dark:hover:border-neutral-700 rounded-lg">
            <div class="h-full flex gap-x-5">
                <div class="flex-shrink-0 size-8">
                    <svg class="flex-shrink-0 size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#d0021b" fill="none">
                        <path d="M4.00422 2.75012C3.59002 2.75012 3.25424 3.08589 3.25423 3.5001L3.25391 21.25H5.25391L5.25391 16.2501H20C20.2766 16.2501 20.5307 16.0979 20.6613 15.854C20.7918 15.6101 20.7775 15.3142 20.624 15.0841L16.9014 9.50006L20.624 3.91602C20.7775 3.68588 20.7918 3.38997 20.6613 3.1461C20.5307 2.90223 20.2766 2.75 20 2.75L4.00422 2.75012Z" fill="currentColor" />
                    </svg>
                </div>

                <div class="grow">
                    <div class="h-full flex flex-col">
                        <div>
                            <h3 class="inline-flex items-center gap-x-1 font-medium text-gray-800 dark:text-neutral-200">
                                Red Flag
                                @if(!$redflag)
                                    <span class="relative ml-2 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="pt-1 mt-auto">
                            @if(!$redflag)
                            <span class="inline-flex items-center gap-x-2 text-sm font-medium group-disabled:opacity-50 group-disabled:pointer-events-none text-red-600 group-hover:text-red-700 group-hover:underline group-hover:decoration-2 dark:text-blue-500 dark:group-hover:text-blue-400">
                              Needs to be Signed
                            </span>
                            @else
                            <span class="inline-flex items-center gap-x-2 text-sm font-medium text-green-600 dark:text-green-500">
                              Signed
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <a class="after:absolute after:inset-0 after:z-10" href="{{ route('dealer.manual.red-flag.index') }}"></a>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="p-4 group relative flex flex-col border border-gray-200 bg-white hover:border-gray-300 dark:bg-neutral-800 dark:border-neutral-700/50 dark:hover:border-neutral-700 rounded-lg">
            <div class="h-full flex gap-x-5">
                <div class="flex-shrink-0 size-8">
                    <svg class="flex-shrink-0 size-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#f5a623" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.25017 1.99999C1.25018 1.58578 1.58596 1.25 2.00017 1.25H20C20.4142 1.25 20.75 1.58579 20.75 2V10.0488C20.2025 9.85528 19.6135 9.75 19 9.75C16.1023 9.75 13.75 12.0988 13.75 15C13.75 16.2976 14.2206 17.4847 15 18.4006V22.75H2C1.80109 22.75 1.61032 22.671 1.46967 22.5303C1.32902 22.3897 1.25 22.1989 1.25 22L1.25017 1.99999ZM7 8H15V6H7V8ZM7 13H12V11H7V13Z" fill="currentColor" />
                        <path d="M19 11.25C16.9301 11.25 15.25 12.9278 15.25 15C15.25 17.0722 16.9301 18.75 19 18.75C21.0699 18.75 22.75 17.0722 22.75 15C22.75 12.9278 21.0699 11.25 19 11.25Z" fill="currentColor" />
                        <path d="M16.5 22.75V19.0396C17.2263 19.49 18.083 19.75 19 19.75C19.917 19.75 20.7737 19.49 21.5 19.0396V22.75L19 21.25L16.5 22.75Z" fill="currentColor" />
                    </svg>
                </div>

                <div class="grow">
                    <div class="h-full flex flex-col">
                        <div>
                            <h3 class="inline-flex items-center gap-x-1 font-medium text-gray-800 dark:text-neutral-200">
                                CMS
                                @if(!$cms)
                                    <span class="relative ml-2 flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                @endif
                            </h3>
                        </div>

                        <div class="pt-1 mt-auto">
                            @if(!$cms)
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium group-disabled:opacity-50 group-disabled:pointer-events-none text-red-600 group-hover:text-red-700 group-hover:underline group-hover:decoration-2 dark:text-blue-500 dark:group-hover:text-blue-400">
                              Needs to be Signed
                            </span>
                            @else
                                <span class="inline-flex items-center gap-x-2 text-sm font-medium text-green-600 dark:text-green-500">
                              Signed
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <a class="after:absolute after:inset-0 after:z-10" href="{{ route('dealer.manual.cms.index') }}"></a>
        </div>
        <!-- End Card -->
    </div>

</div>
