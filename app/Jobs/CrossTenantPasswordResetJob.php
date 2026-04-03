<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Dealership;
use App\Models\User;
use App\Notifications\TenantResetPasswordNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class CrossTenantPasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $email) {}

    /**
     * Iterates every non-suspended dealership, switches to its tenant DB, and if the
     * email matches a user it generates a fresh reset token and sends a notification
     * pointing to that tenant's subdomain. Dispatched from central context only.
     */
    public function handle(): void
    {
        Dealership::query()->each(function (Dealership $dealership): void {
            if ($dealership->isSuspended()) {
                return;
            }

            $domain = $dealership->domain();

            if ($domain === null) {
                return;
            }

            tenancy()->initialize($dealership);

            try {
                /** @var User|null $user */
                $user = User::query()->where('email', $this->email)->first();

                if ($user === null) {
                    return;
                }

                $token = Str::random(64);

                DB::table('password_reset_tokens')->upsert(
                    [
                        'email' => $this->email,
                        'token' => Hash::make($token),
                        'created_at' => now(),
                    ],
                    ['email'],
                    ['token', 'created_at'],
                );

                $resetUrl = 'https://'.$domain.'/reset-password/'.$token
                    .'?'.http_build_query(['email' => $this->email]);

                $user->notify(new TenantResetPasswordNotification($resetUrl));
            } finally {
                tenancy()->end();
            }
        });
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
