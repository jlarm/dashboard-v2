<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Automated Reports</x-slot>
    </x-slot>

    <section class="p-2">
        <div class="max-w-4xl mx-auto">
            <form wire:submit.prevent="saveComplianceSummary">
                <div class="bg-white p-6 space-y-8">

                    {{-- Enable / Disable --}}
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 mb-1">Automated Compliance Summary Email</h2>
                        <p class="text-sm text-gray-600 mb-5">
                            When enabled, a PDF compliance summary report will be automatically emailed to the
                            selected recipients on your chosen schedule.
                        </p>
                        <div class="flex items-center justify-between py-3 border-t border-gray-100">
                            <span class="text-sm font-medium text-gray-900">Enable compliance summary emails</span>
                            <button
                                type="button"
                                wire:click="$toggle('compliance_summary_active')"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 {{ $compliance_summary_active ? 'bg-arm-blue-600' : 'bg-gray-200' }}"
                                role="switch"
                                aria-checked="{{ $compliance_summary_active ? 'true' : 'false' }}"
                            >
                                <span
                                    aria-hidden="true"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $compliance_summary_active ? 'translate-x-5' : 'translate-x-0' }}"
                                ></span>
                            </button>
                        </div>
                    </div>

                    {{-- Frequency --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">Frequency</h3>
                        <p class="text-sm text-gray-500 mb-4">Reports send on the first day of the selected period.</p>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input
                                    type="radio"
                                    wire:model="compliance_summary_frequency"
                                    value="monthly"
                                    class="h-4 w-4 text-arm-blue-600 border-gray-300 focus:ring-arm-blue-500"
                                >
                                <div>
                                    <span class="block text-sm font-medium text-gray-900">Monthly</span>
                                    <span class="block text-xs text-gray-500">First day of every month</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group ml-6">
                                <input
                                    type="radio"
                                    wire:model="compliance_summary_frequency"
                                    value="quarterly"
                                    class="h-4 w-4 text-arm-blue-600 border-gray-300 focus:ring-arm-blue-500"
                                >
                                <div>
                                    <span class="block text-sm font-medium text-gray-900">Quarterly</span>
                                    <span class="block text-xs text-gray-500">First day of every quarter</span>
                                </div>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('compliance_summary_frequency')" class="mt-2"/>
                    </div>

                    {{-- Recipients --}}
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-1">Recipients</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Select the users who should receive the compliance summary. At least one recipient
                            is required when the feature is enabled.
                        </p>

                        @if($availableRecipients->isEmpty())
                            <p class="text-sm text-gray-400 italic">
                                No qualifying users found. Users with Owner, GM, CFO, GSM, or Qualified Individual
                                roles will appear here.
                            </p>
                        @else
                            <div class="divide-y divide-gray-100 border border-gray-200 rounded-lg overflow-hidden">
                                @foreach($availableRecipients as $recipient)
                                    <label wire:key="recipient-{{ $recipient->id }}" class="flex items-center gap-4 px-4 py-3 hover:bg-gray-50 cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:model="compliance_summary_recipients"
                                            value="{{ $recipient->id }}"
                                            class="h-4 w-4 rounded text-arm-blue-600 border-gray-300 focus:ring-arm-blue-500"
                                        >
                                        <div class="min-w-0">
                                            <span class="block text-sm font-medium text-gray-900">{{ Str::title($recipient->name) }}</span>
                                            <span class="block text-xs text-gray-500 truncate">{{ Str::lower($recipient->email) }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <x-input-error :messages="$errors->get('compliance_summary_recipients')" class="mt-2"/>
                    </div>

                </div>

                <div class="py-3 flex items-center justify-between">
                    <button
                        type="button"
                        wire:click="sendNow"
                        wire:loading.attr="disabled"
                        wire:target="sendNow"
                        class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                        </svg>
                        <span wire:loading.remove wire:target="sendNow">Send Report Now</span>
                        <span wire:loading wire:target="sendNow">Sending&hellip;</span>
                    </button>
                    <x-primary-button wire:loading.attr="disabled">Save Settings</x-primary-button>
                </div>
            </form>
        </div>
    </section>
</div>
