<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use App\Models\Contract;
use App\Models\Document;
use App\Models\Sds;
use App\Models\SharedDocument;
use App\Models\User;
use App\Models\ViolationStatement;
use App\Policies\Central\ContractPolicy;
use App\Policies\Central\DealershipPolicy;
use App\Policies\Central\DocumentPolicy;
use App\Policies\Central\InvitePolicy;
use App\Policies\Central\SdsPolicy;
use App\Policies\Central\SharedDocumentPolicy;
use App\Policies\Central\ViolationStatementPolicy;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contracts')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function centralUserWith(string $role): User
{
    $user = User::factory()->create();
    $user->assignRole($role);

    return $user;
}

describe('Central\DealershipPolicy', function (): void {
    $policy = new DealershipPolicy;

    foreach (['viewAny', 'create'] as $method) {
        it("allows super-admin and Consultant to {$method}", function () use ($policy, $method): void {
            expect($policy->{$method}(centralUserWith('super-admin')))->toBeTrue();
            expect($policy->{$method}(centralUserWith('Consultant')))->toBeTrue();
        });

        it("denies Manager and Employee to {$method}", function () use ($policy, $method): void {
            expect($policy->{$method}(centralUserWith('Manager')))->toBeFalse();
            expect($policy->{$method}(centralUserWith('Employee')))->toBeFalse();
        });
    }
});

describe('Central\DocumentPolicy', function (): void {
    $policy = new DocumentPolicy;
    $doc = new Document;

    it('allows super-admin and Consultant on viewAny/view', function () use ($policy, $doc): void {
        expect($policy->viewAny(centralUserWith('super-admin')))->toBeTrue();
        expect($policy->viewAny(centralUserWith('Consultant')))->toBeTrue();
        expect($policy->view(centralUserWith('Consultant'), $doc))->toBeTrue();
    });

    it('restricts create and delete to super-admin only (Consultants denied)', function () use ($policy): void {
        expect($policy->create(centralUserWith('super-admin')))->toBeTrue();
        expect($policy->delete(centralUserWith('super-admin')))->toBeTrue();
        expect($policy->create(centralUserWith('Consultant')))->toBeFalse();
        expect($policy->delete(centralUserWith('Consultant')))->toBeFalse();
    });

    it('denies Manager and Employee for everything', function () use ($policy, $doc): void {
        foreach (['Manager', 'Employee'] as $role) {
            expect($policy->viewAny(centralUserWith($role)))->toBeFalse();
            expect($policy->view(centralUserWith($role), $doc))->toBeFalse();
            expect($policy->create(centralUserWith($role)))->toBeFalse();
            expect($policy->delete(centralUserWith($role)))->toBeFalse();
        }
    });
});

describe('Central\InvitePolicy', function (): void {
    $policy = new InvitePolicy;
    $invite = new UserInvite;

    it('denies every role at the policy level (super-admin bypass is via Gate::before only)', function () use ($policy, $invite): void {
        foreach (['super-admin', 'Consultant', 'Manager', 'Employee'] as $role) {
            $u = centralUserWith($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
            expect($policy->delete($u, $invite))->toBeFalse();
        }
    });
});

describe('Central\SdsPolicy', function (): void {
    $policy = new SdsPolicy;
    $sds = new Sds;

    it('allows super-admin and Consultant on viewAny/view', function () use ($policy, $sds): void {
        foreach (['super-admin', 'Consultant'] as $role) {
            expect($policy->viewAny(centralUserWith($role)))->toBeTrue();
            expect($policy->view(centralUserWith($role), $sds))->toBeTrue();
        }
    });

    it('restricts create/update/delete to super-admin only', function () use ($policy, $sds): void {
        $admin = centralUserWith('super-admin');
        $consultant = centralUserWith('Consultant');

        foreach (['create' => null, 'update' => $sds, 'delete' => $sds] as $method => $arg) {
            $result = $arg === null
                ? [$policy->{$method}($admin), $policy->{$method}($consultant)]
                : [$policy->{$method}($admin, $arg), $policy->{$method}($consultant, $arg)];
            expect($result[0])->toBeTrue();
            expect($result[1])->toBeFalse();
        }
    });

    it('denies Manager and Employee at every gate', function () use ($policy, $sds): void {
        foreach (['Manager', 'Employee'] as $role) {
            $u = centralUserWith($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->view($u, $sds))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
            expect($policy->update($u, $sds))->toBeFalse();
            expect($policy->delete($u, $sds))->toBeFalse();
        }
    });
});

describe('Central\SharedDocumentPolicy', function (): void {
    $policy = new SharedDocumentPolicy;
    $shared = new SharedDocument;

    it('allows super-admin and Consultant on viewAny/view; restricts create/delete to super-admin only', function () use ($policy, $shared): void {
        expect($policy->viewAny(centralUserWith('Consultant')))->toBeTrue();
        expect($policy->view(centralUserWith('Consultant'), $shared))->toBeTrue();

        expect($policy->create(centralUserWith('super-admin')))->toBeTrue();
        expect($policy->delete(centralUserWith('super-admin')))->toBeTrue();
        expect($policy->create(centralUserWith('Consultant')))->toBeFalse();
        expect($policy->delete(centralUserWith('Consultant')))->toBeFalse();
    });
});

describe('Central\ViolationStatementPolicy', function (): void {
    $policy = new ViolationStatementPolicy;
    $vs = new ViolationStatement;

    it('allows super-admin and Consultant on viewAny/view and restricts create/update/delete to super-admin only', function () use ($policy, $vs): void {
        expect($policy->viewAny(centralUserWith('Consultant')))->toBeTrue();
        expect($policy->view(centralUserWith('Consultant'), $vs))->toBeTrue();

        $admin = centralUserWith('super-admin');
        $consultant = centralUserWith('Consultant');
        expect($policy->create($admin))->toBeTrue();
        expect($policy->update($admin, $vs))->toBeTrue();
        expect($policy->delete($admin, $vs))->toBeTrue();
        expect($policy->create($consultant))->toBeFalse();
        expect($policy->update($consultant, $vs))->toBeFalse();
        expect($policy->delete($consultant, $vs))->toBeFalse();
    });

    it('accepts a null violation statement on update/delete because those methods are also used pre-resolution', function () use ($policy): void {
        $admin = centralUserWith('super-admin');
        expect($policy->update($admin, null))->toBeTrue();
        expect($policy->delete($admin, null))->toBeTrue();
    });
});

describe('Central\ContractPolicy', function (): void {
    $policy = new ContractPolicy;

    it('allows viewAny/create for super-admin and Consultant only', function () use ($policy): void {
        foreach (['super-admin', 'Consultant'] as $role) {
            $u = centralUserWith($role);
            expect($policy->viewAny($u))->toBeTrue();
            expect($policy->create($u))->toBeTrue();
        }
        foreach (['Manager', 'Employee'] as $role) {
            $u = centralUserWith($role);
            expect($policy->viewAny($u))->toBeFalse();
            expect($policy->create($u))->toBeFalse();
        }
    });

    it('lets the contract owner view their own contract; super-admin can view any', function () use ($policy): void {
        $consultant = centralUserWith('Consultant');
        $otherConsultant = centralUserWith('Consultant');
        $admin = centralUserWith('super-admin');

        $contract = Contract::factory()->create(['user_id' => $consultant->id]);

        expect($policy->view($consultant, $contract))->toBeTrue();
        expect($policy->view($admin, $contract))->toBeTrue();
        expect($policy->view($otherConsultant, $contract))->toBeFalse();
    });

    it('locks update + sendForReview to owner or super-admin when no signature is present yet', function () use ($policy): void {
        $owner = centralUserWith('Consultant');
        $other = centralUserWith('Consultant');
        $admin = centralUserWith('super-admin');

        $contract = Contract::factory()->create([
            'user_id' => $owner->id,
            'armp_signature' => null,
            'dealer_signature' => null,
        ]);

        foreach (['update', 'delete', 'sendForReview'] as $method) {
            expect($policy->{$method}($owner, $contract))->toBeTrue();
            expect($policy->{$method}($admin, $contract))->toBeTrue();
            expect($policy->{$method}($other, $contract))->toBeFalse();
        }
    });

    it('blocks update once ARMP signs the contract', function () use ($policy): void {
        $owner = centralUserWith('Consultant');
        $contract = Contract::factory()->create([
            'user_id' => $owner->id,
            'armp_signature' => 'Jane Doe',
            'dealer_signature' => null,
        ]);

        expect($policy->update($owner, $contract))->toBeFalse();
        expect($policy->update(centralUserWith('super-admin'), $contract))->toBeFalse();
    });

    it('blocks delete and sendForReview once the dealer signs', function () use ($policy): void {
        $owner = centralUserWith('Consultant');
        $contract = Contract::factory()->create([
            'user_id' => $owner->id,
            'dealer_signature' => 'Sam Dealer',
        ]);

        expect($policy->delete($owner, $contract))->toBeFalse();
        expect($policy->sendForReview($owner, $contract))->toBeFalse();
    });

    it('allows generatePdf only after the ARMP signature is set', function () use ($policy): void {
        $owner = centralUserWith('Consultant');
        $unsigned = Contract::factory()->create(['user_id' => $owner->id, 'armp_signature' => null]);
        $signed = Contract::factory()->create(['user_id' => $owner->id, 'armp_signature' => 'Jane Doe']);

        expect($policy->generatePdf($owner, $unsigned))->toBeFalse();
        expect($policy->generatePdf($owner, $signed))->toBeTrue();
    });

    it('allows sendPdf and downloadPdf only after pdf_path is populated', function () use ($policy): void {
        $owner = centralUserWith('Consultant');
        $other = centralUserWith('Consultant');
        $admin = centralUserWith('super-admin');

        $missingPdf = Contract::factory()->create(['user_id' => $owner->id, 'pdf_path' => null]);
        $withPdf = Contract::factory()->create(['user_id' => $owner->id, 'pdf_path' => 'contracts/x.pdf']);

        foreach (['sendPdf', 'downloadPdf'] as $method) {
            expect($policy->{$method}($owner, $missingPdf))->toBeFalse();
            expect($policy->{$method}($owner, $withPdf))->toBeTrue();
            expect($policy->{$method}($admin, $withPdf))->toBeTrue();
            expect($policy->{$method}($other, $withPdf))->toBeFalse();
        }
    });
});
