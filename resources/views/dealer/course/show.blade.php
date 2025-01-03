<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">{{ $course->name }}</x-slot>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:dealer.course.show :course="$course"/>
        </div>
    </div>
</x-dealer-app>
