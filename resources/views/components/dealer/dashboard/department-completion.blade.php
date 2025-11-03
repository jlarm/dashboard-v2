@props(['subtitle' => '*Based on the total number of employees who finished all required training courses.'])

<x-dealer.card title="Course Completion by Department" :subtitle="$subtitle">
    <livewire:dealer.employee.department-completion-stats />
</x-dealer.card> 