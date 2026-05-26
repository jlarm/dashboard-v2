<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractNotification;
use App\Notifications\ContractPdfNotification;
use App\Notifications\ContractSignedNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contracts')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
});

describe('ContractNotification (review request)', function (): void {
    it('routes only through the mail channel', function (): void {
        $contract = Contract::factory()->create();

        expect((new ContractNotification($contract))->via(new AnonymousNotifiable))->toBe(['mail']);
    });

    it('builds a mail with the dealer name in the subject and the contact in the body', function (): void {
        $owner = User::factory()->create(['name' => 'Acme Rep', 'email' => 'rep@example.com']);
        $contract = Contract::factory()->create([
            'user_id' => $owner->id,
            'dealer_name' => 'Acme Motors',
        ]);

        $message = (new ContractNotification($contract))->toMail(new AnonymousNotifiable);

        expect($message)->toBeInstanceOf(MailMessage::class)
            ->and($message->subject)->toBe('ARMP Contract for '.$contract->dealer_name)
            ->and($message->actionText)->toBe('Review Contract');

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)
            ->toContain($owner->name)
            ->toContain($owner->email)
            ->toContain('expire in 7 days');
    });

    it('points the action at a temporary signed contracts.show URL keyed by uuid', function (): void {
        $contract = Contract::factory()->create(['uuid' => (string) Str::uuid()]);

        $message = (new ContractNotification($contract))->toMail(new AnonymousNotifiable);

        expect($message->actionUrl)
            ->toBeString()
            ->toContain('/contract/view/'.$contract->uuid)
            ->toContain('signature=')
            ->toContain('expires=');
    });
});

describe('ContractSignedNotification (dealer signed → notify ARMP)', function (): void {
    it('routes only through the mail channel', function (): void {
        $contract = Contract::factory()->create();

        expect((new ContractSignedNotification($contract))->via(new AnonymousNotifiable))->toBe(['mail']);
    });

    it('builds a mail with the dealer name in the subject and a link to edit', function (): void {
        $contract = Contract::factory()->create(['dealer_name' => 'Globex Auto']);

        $message = (new ContractSignedNotification($contract))->toMail(new AnonymousNotifiable);

        expect($message->subject)->toBe('Contract Signed by '.$contract->dealer_name.'.')
            ->and($message->actionText)->toBe('View Contract')
            ->and($message->actionUrl)->toBe(route('contracts.edit', $contract));

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)->toContain($contract->dealer_name)
            ->toContain('reviewed and signed');
    });
});

describe('ContractPdfNotification (signed PDF delivery)', function (): void {
    beforeEach(function (): void {
        Storage::fake('armpcon');
    });

    it('routes only through the mail channel', function (): void {
        $contract = Contract::factory()->create();

        expect((new ContractPdfNotification($contract))->via(new AnonymousNotifiable))->toBe(['mail']);
    });

    it('builds a mail with the dealer name in the subject and an attachment named after the dealer', function (): void {
        $owner = User::factory()->create(['name' => 'Jane Rep', 'email' => 'jane@example.com']);
        $contract = Contract::factory()->create([
            'user_id' => $owner->id,
            'dealer_name' => 'Big Box Dealership',
            'uuid' => (string) Str::uuid(),
            'pdf_path' => $contract_pdf = 'pdfs/'.uniqid().'.pdf',
        ]);
        Storage::disk('armpcon')->put($contract_pdf, 'pdf-bytes');

        $message = (new ContractPdfNotification($contract))->toMail(new AnonymousNotifiable);

        $expectedFilename = str_replace(' ', '-', mb_strtolower($contract->dealer_name)).'-armp-contract.pdf';

        expect($message->subject)->toBe($contract->dealer_name.' ARMP Contract PDF');

        $body = implode("\n", [...$message->introLines, ...$message->outroLines]);
        expect($body)
            ->toContain($owner->name)
            ->toContain($owner->email);

        expect($message->rawAttachments)->toHaveCount(0);
        expect($message->attachments)->toHaveCount(1);

        $attachment = $message->attachments[0];
        expect($attachment['options']['as'] ?? null)->toBe($expectedFilename)
            ->and($attachment['options']['mime'] ?? null)->toBe('application/pdf');
    });
});
