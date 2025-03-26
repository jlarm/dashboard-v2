@props(['subtitle' => '*Based on the total number of employees who finished all required training courses.'])

<x-dealer.card title="Course Completion by Department" :subtitle="$subtitle">
    <ul class="space-y-4">
        <livewire:dealer.employee.completed-courses-stat name="All" />
        <livewire:dealer.employee.completed-courses-stat :department="1" name="Sales" />
        <livewire:dealer.employee.completed-courses-stat :department="2" name="Accounting" />
        <livewire:dealer.employee.completed-courses-stat :department="3" name="Service" />
        <livewire:dealer.employee.completed-courses-stat :department="4" name="Parts" />
        <livewire:dealer.employee.completed-courses-stat :department="5" name="Body Shop" />
        <livewire:dealer.employee.completed-courses-stat :department="6" name="Finance" />
        <livewire:dealer.employee.completed-courses-stat :department="7" name="Porter/Driver" />
    </ul>
</x-dealer.card> 