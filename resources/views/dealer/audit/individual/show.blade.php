<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-20 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">Deal Jacket Audits for
                {{ $individualAudit->audit_date->format('F d, Y') }}</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4 space-x-5">
            {{--            @if($individualAudit->pdf_path)--}}
            <livewire:dealer.audit.individual.download :individualAudit="$individualAudit"/>
            {{--            @else--}}
            <a class="inline-flex items-center px-4 py-2 bg-arm-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-arm-blue-700 focus:bg-arm-blue-700 active:bg-arm-blue-900 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
               href="{{ route('dealer.audit.individual.create', $individualAudit) }}">
                Create Audit
            </a>

            @if(!$drafts)
                <livewire:dealer.audit.individual.generate :individualAudit="$individualAudit"/>
            @endif
            {{--            @endif--}}
        </div>
    </div>

    <div class="py-12">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">
                    Customer Number
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Customer Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                    <span class="sr-only">Edit</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr>
                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $individualAudit->customer_number }}
                <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $individualAudit->customer_name }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    @if($individualAudit->draft)
                        <span
                            class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
                    @else
                        <span
                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
                    @endif
                </td>
                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                    <div class="space-x-5">
                        <a href="{{ route('dealer.audit.individual.edit', $individualAudit) }}"
                           class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        >
                            Edit
                        </a>
                        {{--                        <button--}}
                        {{--                            class="text-red-500 text-sm"--}}
                        {{--                            wire:click="$emit('modal.open', 'dealer.audit.individual.delete',  @js(['individualAudit' => $individualAudit->id]))"--}}
                        {{--                        >--}}
                        {{--                            Delete--}}
                        {{--                        </button>--}}
                    </div>
                </td>
            </tr>
            @foreach($audits as $audit)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $audit->customer_number }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900">{{ $audit->customer_name }}
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        @if($audit->draft)
                            <span
                                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">Draft</span>
                        @else
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Completed</span>
                        @endif
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                        <div class="space-x-5">
                            <a
                                href="{{ route('dealer.audit.individual.edit', $audit) }}"
                                class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                Edit
                            </a>
                            {{--                            <button--}}
                            {{--                                class="text-red-500 text-sm"--}}
                            {{--                                wire:click="$emit('modal.open', 'dealer.audit.individual.delete',  @js(['individualAudit' => $individualAudit->id]))"--}}
                            {{--                            >--}}
                            {{--                                Delete--}}
                            {{--                            </button>--}}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-dealer-app>
