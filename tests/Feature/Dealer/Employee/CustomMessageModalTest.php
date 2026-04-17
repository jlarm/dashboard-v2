<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\CustomMessageModal;
use App\Jobs\SendCustomEmployeeMessageJob;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Livewire\Livewire;
use Tests\TenantTestCase;

uses(TenantTestCase::class);

describe('custom message modal', function (): void {
    it('renders with user count', function (): void {
        $this->actingAs($this->consultant);

        $users = User::factory()->count(3)->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => $users->pluck('id')->all()])
            ->assertSee('3 employees');
    });

    it('renders singular employee label when one recipient is selected', function (): void {
        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->assertSee('1 employee')
            ->assertDontSee('1 employees');
    });

    it('prefills the subject with the authenticated user name', function (): void {
        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->assertSet('subject', 'Message from '.$this->consultant->name);
    });

    it('dispatches a queued job for each selected user', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        $users = User::factory()->count(2)->create();
        $userIds = $users->pluck('id')->all();

        Livewire::test(CustomMessageModal::class, ['userIds' => $userIds])
            ->set('subject', 'Please Complete Your Training')
            ->set('messageBody', '<p>You have outstanding compliance courses.</p>')
            ->call('send')
            ->assertHasNoErrors()
            ->assertDispatched('modal.close');

        Queue::assertPushed(SendCustomEmployeeMessageJob::class, 2);

        Queue::assertPushed(SendCustomEmployeeMessageJob::class, fn (SendCustomEmployeeMessageJob $job): bool => in_array($job->user->id, $users->pluck('id')->all())
                && $job->subject === 'Please Complete Your Training'
                && $job->messageBody === '<p>You have outstanding compliance courses.</p>');
    });

    it('validates that subject is required', function (): void {
        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->set('subject', '')
            ->set('messageBody', '<p>Some message</p>')
            ->call('send')
            ->assertHasErrors(['subject' => 'required']);
    });

    it('validates that message body is required', function (): void {
        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->set('subject', 'Training Reminder')
            ->set('messageBody', '')
            ->call('send')
            ->assertHasErrors(['messageBody' => 'required']);
    });

    it('does not dispatch jobs when validation fails', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->set('subject', '')
            ->set('messageBody', '')
            ->call('send')
            ->assertHasErrors(['subject', 'messageBody']);

        Queue::assertNothingPushed();
    });

    it('validates that the subject does not exceed 255 characters', function (): void {
        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->set('subject', str_repeat('a', 256))
            ->set('messageBody', '<p>Some message</p>')
            ->call('send')
            ->assertHasErrors(['subject' => 'max']);
    });

    it('swallows unexpected failures gracefully so they can be reported to Sentry', function (): void {
        Queue::fake();

        $this->actingAs($this->consultant);

        $user = User::factory()->create();

        $component = Livewire::test(CustomMessageModal::class, ['userIds' => [$user->id]])
            ->set('subject', 'Please Complete Your Training')
            ->set('messageBody', '<p>You have outstanding compliance courses.</p>');

        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=0');
        DB::connection('tenant')->statement('RENAME TABLE users TO users_broken');
        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=1');

        try {
            $component
                ->call('send')
                ->assertHasNoErrors()
                ->assertNotEmitted('modal.close');

            Queue::assertNothingPushed();
        } finally {
            DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=0');
            DB::connection('tenant')->statement('RENAME TABLE users_broken TO users');
            DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS=1');
        }
    });
});
