<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

function replaceArtisanCommand(string $name, callable $handler): void
{
    $kernel = app(Illuminate\Contracts\Console\Kernel::class);
    $reflection = new ReflectionMethod($kernel, 'getArtisan');
    $app = $reflection->invoke($kernel);
    $app->add(new class($name, $handler) extends SymfonyCommand
    {
        public function __construct(string $name, private $handler)
        {
            parent::__construct();
            $this->setName($name);
            $this->ignoreValidationErrors();
        }

        protected function execute(InputInterface $i, OutputInterface $o): int
        {
            return (int) ($this->handler)($i, $o);
        }
    });
}

describe('backups:go', function (): void {
    it('runs backup:run once per tenant and emits a "completed successfully" line per tenant', function (): void {
        Mail::fake();
        $invocations = 0;
        replaceArtisanCommand('backup:run', function () use (&$invocations): int {
            $invocations++;

            return 0;
        });

        config(['backup.notifications.mail.to' => 'ops@example.test']);

        tenancy()->end();
        $this->artisan('backups:go', ['--tenants' => [$this->tenant->id]])
            ->expectsOutputToContain('Running backup command for tenant')
            ->expectsOutputToContain('Command completed successfully')
            ->assertExitCode(0);

        expect($invocations)->toBe(1);
    });

    it('reports an error line per failing tenant when backup:run throws', function (): void {
        Mail::fake();
        replaceArtisanCommand('backup:run', function (): never {
            throw new RuntimeException('disk unavailable');
        });

        config(['backup.notifications.mail.to' => 'ops@example.test']);

        tenancy()->end();
        $this->artisan('backups:go', ['--tenants' => [$this->tenant->id]])
            ->expectsOutputToContain('Error running backup for tenant')
            ->assertExitCode(0);
    });

    it('skips email when no admin recipient is configured', function (): void {
        Mail::fake();
        replaceArtisanCommand('backup:run', fn (): int => 0);
        config(['backup.notifications.mail.to' => null, 'app.admin_email' => null]);

        tenancy()->end();
        $this->artisan('backups:go', ['--tenants' => [$this->tenant->id]])->assertExitCode(0);

        Mail::assertNothingSent();
    });
});

describe('backups:clean', function (): void {
    it('delegates to backup:clean once per tenant', function (): void {
        $invocations = 0;
        replaceArtisanCommand('backup:clean', function () use (&$invocations): int {
            $invocations++;

            return 0;
        });

        tenancy()->end();
        $this->artisan('backups:clean', ['--tenants' => [$this->tenant->id]])->assertExitCode(0);

        expect($invocations)->toBe(1);
    });
});

describe('backups:check', function (): void {
    it('returns SUCCESS when every tenant has a backup newer than 24h', function (): void {
        Storage::fake('armp-backups');
        $slug = Str::slug((string) $this->tenant->name);
        Storage::disk('armp-backups')->put("tenant-{$this->tenant->id}-{$slug}/today.zip", 'fresh');

        tenancy()->end();
        $this->artisan('backups:check', ['--tenants' => [$this->tenant->id], '--disk' => 'armp-backups'])
            ->expectsOutputToContain('passed')
            ->assertExitCode(0);
    });

    it('returns FAILURE and lists tenants with no backup directory at all', function (): void {
        Storage::fake('armp-backups');

        tenancy()->end();
        $this->artisan('backups:check', ['--tenants' => [$this->tenant->id], '--disk' => 'armp-backups'])
            ->expectsOutputToContain('no backups found')
            ->assertExitCode(1);
    });
});
