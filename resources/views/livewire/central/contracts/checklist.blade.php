<div class="border rounded-md p-3">
    <h2 class="text-sm font-semibold leading-6 text-gray-900">Checklist</h2>
    <ul class="divide-y divide-gray-100">
        <li class="flex justify-between gap-x-6 py-3">
            <div class="flex items-center gap-x-3">
                @if(in_array(1, $this->progress()))
                    <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @else
                    <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @endif
                <h2 class="min-w-0 text-sm leading-6">
                    Create Contract
                </h2>
            </div>
        </li>
        <li class="flex justify-between gap-x-6 py-3">
            <div class="flex items-center gap-x-3">
                @if(in_array(2, $this->progress()))
                    <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @else
                    <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @endif
                <h2 class="min-w-0 text-sm leading-6">
                    Contract sent for review
                </h2>
            </div>
        </li>
        <li class="flex justify-between gap-x-6 py-3">
            <div class="flex items-center gap-x-3">
                @if(in_array(3, $this->progress()))
                    <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @else
                    <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @endif
                <h2 class="min-w-0 text-sm leading-6">
                    Contract signed by Dealer
                </h2>
            </div>
        </li>
        <li class="flex justify-between gap-x-6 py-3">
            <div class="flex items-center gap-x-3">
                @if(in_array(4, $this->progress()))
                    <div class="flex-none rounded-full p-1 text-green-400 bg-green-400/10">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @else
                    <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @endif
                <h2 class="min-w-0 text-sm leading-6">
                    Contract signed by ARMP
                </h2>
            </div>
        </li>
        <li class="flex justify-between gap-x-6 py-3">
            <div class="flex items-center gap-x-3">
                @if(in_array(5, $this->progress()))
                    <span>🎉</span>
                @else
                    <div class="flex-none rounded-full p-1 text-gray-500 bg-gray-100">
                        <div class="h-2 w-2 rounded-full bg-current"></div>
                    </div>
                @endif
                <h2 class="min-w-0 text-sm leading-6">
                    Contract approved and completed
                </h2>
            </div>
        </li>
    </ul>
</div>
