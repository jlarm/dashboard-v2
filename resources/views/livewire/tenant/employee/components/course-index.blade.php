<x-table>
    <x-slot name="head">
        <x-table.row>
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Last Taken</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading></x-table.heading>
        </x-table.row>
    </x-slot>
    <x-slot name="body">
        @foreach($courses as $course)
            <livewire:tenant.employee.components.course-index-item :course="$course" :user="$user" :wire:key="$course->id" />
        @endforeach
    </x-slot>
</x-table>
