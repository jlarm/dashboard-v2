<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\Details;
use App\Models\Dealer\Department;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

it('renders working edit and delete event bindings for employee actions', function (): void {
    $this->consultant->givePermissionTo('create-stores');

    $department = Department::query()->create([
        'name' => 'Sales '.uniqid(),
        'slug' => 'sales-'.uniqid(),
    ]);

    $employee = User::query()->create([
        'name' => 'Detail View Employee',
        'email' => 'details-component@test.com',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $employee->assignRole('Employee');

    $this->actingAs($this->consultant);

    Livewire::test(Details::class, ['user' => $employee])
        ->assertSee('Edit')
        ->assertSee('Delete')
        ->assertSeeHtml("wire:click=\"\$emit('slide-over.open', 'dealer.employee.edit', { user: {$employee->id} })\"")
        ->assertSeeHtml("wire:click=\"\$emit('modal.open', 'dealer.employee.delete', { user: {$employee->id} })\"")
        ->assertDontSee('@js(');
});

it('applies the same small-height class to button and link render modes', function (): void {
    $html = Blade::render('<x-armp.button size="sm">Edit</x-armp.button><x-armp.button size="sm" href="/impersonate">Login as</x-armp.button>');

    expect(mb_substr_count($html, 'h-8 px-3 text-xs'))->toBe(2);
});
