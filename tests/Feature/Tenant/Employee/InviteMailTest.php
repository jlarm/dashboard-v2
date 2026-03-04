<?php

declare(strict_types=1);

use App\Mail\InviteMail;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use Illuminate\Support\Str;

it('renders invite email with the tenant domain registration link', function (): void {
    $department = Department::query()->create([
        'name' => 'Invite Mail Department '.uniqid(),
        'slug' => 'invite-mail-department-'.uniqid(),
    ]);

    $invite = Invite::query()->create([
        'name' => 'Invite Mail User',
        'email' => 'invite-mail-user@test.com',
        'stores' => [],
        'department_id' => $department->id,
        'user_id' => $this->consultant->id,
        'roles' => ['Employee'],
        'invitation_token' => Str::random(32),
        'courses' => [],
    ]);

    $rendered = (new InviteMail($invite))->render();

    expect($rendered)->toContain('https://test-tenant.localhost/invite_registration/'.$invite->invitation_token);
});
