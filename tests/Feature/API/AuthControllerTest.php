<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->user = User::query()->create([
        'name' => 'API Tester',
        'email' => 'api-tester-'.uniqid().'@example.test',
        'password' => Hash::make('secret-pass'),
        'phone' => '555-0100',
    ]);
});

it('issues a Sanctum personal access token for valid credentials', function (): void {
    $response = $this->postJson('/api/auth', [
        'email' => $this->user->email,
        'password' => 'secret-pass',
    ]);

    $response->assertOk()
        ->assertJson(['status' => true])
        ->assertJsonStructure(['status', 'user' => ['id', 'name', 'email'], 'token']);

    expect($this->user->fresh()->tokens()->count())->toBe(1);
});

it('rejects requests with no email field as invalid credentials', function (): void {
    $this->postJson('/api/auth', ['password' => 'secret-pass'])
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid credentials']);
});

it('rejects requests with a malformed email as invalid credentials', function (): void {
    $this->postJson('/api/auth', [
        'email' => 'not-an-email',
        'password' => 'secret-pass',
    ])
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid credentials']);
});

it('rejects requests with the wrong password as invalid credentials', function (): void {
    $this->postJson('/api/auth', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ])
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid credentials']);

    expect($this->user->fresh()->tokens()->count())->toBe(0);
});

it('rejects requests for an unknown email as invalid credentials', function (): void {
    $this->postJson('/api/auth', [
        'email' => 'nobody-here@example.test',
        'password' => 'whatever',
    ])
        ->assertStatus(401)
        ->assertJson(['message' => 'Invalid credentials']);
});

it('throttles after 5 invalid attempts within the rate-limit window', function (): void {
    for ($i = 0; $i < 5; $i++) {
        $this->postJson('/api/auth', [
            'email' => $this->user->email,
            'password' => 'wrong',
        ])->assertStatus(401);
    }

    $this->postJson('/api/auth', [
        'email' => $this->user->email,
        'password' => 'wrong',
    ])->assertStatus(429);
});
