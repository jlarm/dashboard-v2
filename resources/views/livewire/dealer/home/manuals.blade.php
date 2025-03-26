<div>
    <h2 class="inline-block font-semibold text-gray-800 mb-5">
        Manuals
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <x-dealer.dashboard.manual-card title="ISP" link="isp" :status="$isp" :store="$store">
            <x-slot name="icon">
                <svg class="shrink-0 size-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                    <ellipse cx="12" cy="12" rx="4" ry="10" stroke="currentColor" stroke-width="1.5" />
                    <path d="M2 12H22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-slot>
        </x-dealer.dashboard.manual-card>

        <x-dealer.dashboard.manual-card title="OSHA" link="osha" :status="$osha" :store="$store">
            <x-slot name="icon">
                <svg class="shrink-0 size-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                    <path d="M10.5077 6V9.5M10.5077 6C10.5077 5.17157 9.83669 4.5 9.00897 4.5C8.18125 4.5 7.51025 5.17157 7.51025 6V14L4.78483 10.5903C4.13315 9.77501 3.00841 9.77501 2.35673 10.5903C1.92184 11.1344 1.88076 11.895 2.25451 12.4828L5.01239 17C6.51073 20 9.0086 22 12.0064 22M10.5077 6V3.5C10.5077 2.67157 11.1787 2 12.0064 2C12.8341 2 13.5051 2.67157 13.5051 3.5V5.5M13.5051 5.5V9.5M13.5051 5.5C13.5051 4.67157 14.1761 4 15.0038 4C15.8316 4 16.5026 4.67157 16.5026 5.5V8M16.5026 8V9.5M16.5026 8C16.5026 7.17157 17.1736 6.5 18.0013 6.5C18.829 6.5 19.5 7.17157 19.5 8V9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M16 17L17 18L19 16M13 14C14.5 13.5 16 13 17.5 12C19 13 20.5 13.5 22 14C22 17 22 20.5 17.5 22C13 20.5 13 17 13 14Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-slot>
        </x-dealer.dashboard.manual-card>

        <x-dealer.dashboard.manual-card title="Red Flag" link="red-flag" :status="$redFlag" :store="$store">
            <x-slot name="icon">
                <svg class="shrink-0 size-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                    <path d="M4 7L4 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11.7576 3.90865C8.45236 2.22497 5.85125 3.21144 4.55426 4.2192C4.32048 4.40085 4.20358 4.49167 4.10179 4.69967C4 4.90767 4 5.10138 4 5.4888V14.7319C4.9697 13.6342 7.87879 11.9328 11.7576 13.9086C15.224 15.6744 18.1741 14.9424 19.5697 14.1795C19.7633 14.0737 19.8601 14.0207 19.9301 13.9028C20 13.7849 20 13.6569 20 13.4009V5.87389C20 5.04538 20 4.63113 19.8027 4.48106C19.6053 4.33099 19.1436 4.459 18.2202 4.71504C16.64 5.15319 14.3423 5.22532 11.7576 3.90865Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </x-slot>
        </x-dealer.dashboard.manual-card>

        <x-dealer.dashboard.manual-card title="CMS" link="cms" :status="$cms" :store="$store">
            <x-slot name="icon">
                <svg class="shrink-0 size-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                    <path d="M21 11.0511V6.12325C21 5.34825 20.4145 4.70502 19.6551 4.57302C16.595 4.04108 14.0546 2.85772 12.8152 2.20154C12.3077 1.93282 11.6923 1.93282 11.1848 2.20154C9.94542 2.85772 7.40502 4.04108 4.34489 4.57302C3.58552 4.70502 3 5.34825 3 6.12325V11.0511C3 17.4795 9.53762 20.9859 11.4689 21.8815C11.8097 22.0395 12.1903 22.0395 12.5311 21.8815C14.4624 20.9859 21 17.4795 21 11.0511Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </x-slot>
        </x-dealer.dashboard.manual-card>
    </div>
</div>
