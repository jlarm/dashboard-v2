<li class="flex justify-between items-center gap-x-2">
    <div class="w-full grid grid-cols-2 items-center gap-x-2">
        <span class="text-sm text-gray-800 dark:text-neutral-200">
         {{ $formattedName }}
        </span>
        <div class="flex justify-end" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
            <div class="h-1.5 flex flex-col justify-center overflow-hidden bg-arm-green-500 rounded-full text-xs text-white text-center whitespace-nowrap"  style="width: {{ $this->percentage() }}%"></div>
        </div>
    </div>
    <div class="min-w-[60px] text-end">
        <span class="text-sm text-gray-500 dark:text-neutral-500">
         {{ $this->percentage() }}%
        </span>
    </div>
</li>
