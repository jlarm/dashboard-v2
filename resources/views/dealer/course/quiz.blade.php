<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">{{ $course->name }} Quiz</x-slot>
    </x-slot>
    <div>
        <livewire:dealer.course.quiz :course="$course"/>
    </div>
</x-dealer-app>
