<?php

declare(strict_types=1);

use App\Domain\Tenant\User\Actions\BuildEmployeesCsv;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;

it('starts the selection CSV with the expected header row', function (): void {
    $csv = resolve(BuildEmployeesCsv::class)->forSelection(User::query()->whereKey($this->consultant->id)->get());

    $firstLine = strtok($csv, "\n");
    expect($firstLine)->toBe('Name,Email,Store,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon');
});

it('writes one row per user with name, email, store names, and department', function (): void {
    $store = Store::query()->firstOrFail();
    $second = Store::query()->create(['name' => 'North Branch', 'slug' => 'north-'.uniqid()]);
    $department = Department::query()->create([
        'name' => 'Service '.uniqid(),
        'slug' => 'service-'.uniqid(),
    ]);

    $employee = User::query()->create([
        'name' => 'Pat Employee',
        'email' => 'pat-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
        'department_id' => $department->id,
    ]);
    $employee->stores()->attach([$store->id, $second->id]);

    $csv = resolve(BuildEmployeesCsv::class)->forSelection(
        User::query()->whereKey($employee->id)->get(),
    );

    $lines = array_values(array_filter(explode("\n", $csv)));
    expect($lines)->toHaveCount(2);

    $row = $lines[1];
    expect($row)->toContain($employee->name)
        ->toContain($employee->email)
        ->toContain($department->name);

    // The store list is comma-joined, so it must be quoted.
    expect($row)->toMatch('/"[^"]*'.preg_quote($store->name, '/').'[^"]*"/');
    expect($row)->toMatch('/"[^"]*'.preg_quote($second->name, '/').'[^"]*"/');
});

it('escapes commas, quotes, and newlines in user-supplied fields', function (): void {
    $store = Store::query()->firstOrFail();

    $tricky = User::query()->create([
        'name' => 'Last, First "Nicky"'."\nLine2",
        'email' => 'tricky-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $tricky->stores()->attach($store->id);

    $csv = resolve(BuildEmployeesCsv::class)->forSelection(
        User::query()->whereKey($tricky->id)->get(),
    );

    // Double quotes inside must be doubled and the whole field wrapped in quotes.
    expect($csv)->toContain('"Last, First ""Nicky""'."\n".'Line2"');
});

it('defaults all numeric summary columns to 0 when the user has no compliance summary', function (): void {
    $store = Store::query()->firstOrFail();

    $employee = User::query()->create([
        'name' => 'Untrained',
        'email' => 'untrained-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $employee->stores()->attach($store->id);

    $csv = resolve(BuildEmployeesCsv::class)->forSelection(
        User::query()->whereKey($employee->id)->get(),
    );

    $row = explode("\n", $csv)[1];
    $columns = str_getcsv($row);

    expect($columns[5])->toBe('0')
        ->and($columns[6])->toBe('0')
        ->and($columns[7])->toBe('0')
        ->and($columns[8])->toBe('0')
        ->and($columns[9])->toBe('0');
});

it('uses the report header (no Store column) for forReport output', function (): void {
    $csv = resolve(BuildEmployeesCsv::class)->forReport(User::query()->whereKey($this->consultant->id)->get());

    $firstLine = strtok($csv, "\n");
    expect($firstLine)->toBe('Name,Email,Department,Training Status,Valid Completed,Required Courses,Not Completed,Expired,Expiring Soon');
});

it('filters out users from the report when they have no outstanding training', function (): void {
    $employee = User::query()->create([
        'name' => 'Spotless',
        'email' => 'spotless-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('password'),
        'total_completed_courses' => 3,
        'total_user_courses' => 3,
    ]);

    $csv = resolve(BuildEmployeesCsv::class)->forReport(
        User::query()->whereKey($employee->id)->get(),
    );

    $lines = array_values(array_filter(explode("\n", $csv)));
    expect($lines)->toHaveCount(1); // header only — Spotless is excluded
});
