<x-wire-elements-pro::tailwind.modal :content-padding="false">
    <div>
        <img class="w-full object-cover" src="{{ $violation->getMedia('violation_files_' . $filesId)->first()->getTemporaryUrl(\Carbon\Carbon::now()->addMinutes(45), 'audit-view') }}" alt="">
    </div>
</x-wire-elements-pro::tailwind.modal>
