<?php

declare(strict_types=1);

use App\Enums\ViolationAuditType;
use App\Enums\ViolationStatementCategory;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;

it('exposes the URL slug for each audit type', function (ViolationAuditType $type, string $slug): void {
    expect($type->slug())->toBe($slug);
})->with([
    [ViolationAuditType::Osha, 'osha'],
    [ViolationAuditType::BodyShop, 'body-shop'],
    [ViolationAuditType::Glba, 'finance'],
]);

it('maps to the violation audit model class', function (ViolationAuditType $type, string $modelClass): void {
    expect($type->modelClass())->toBe($modelClass);
})->with([
    [ViolationAuditType::Osha, OshaViolationAudit::class],
    [ViolationAuditType::BodyShop, BodyShopViolationAudit::class],
    [ViolationAuditType::Glba, GlbaViolationAudit::class],
]);

it('maps to the legacy audit model class', function (ViolationAuditType $type, string $legacyClass): void {
    expect($type->legacyModelClass())->toBe($legacyClass);
})->with([
    [ViolationAuditType::Osha, OshaAudit::class],
    [ViolationAuditType::BodyShop, BodyShopAudit::class],
    [ViolationAuditType::Glba, FinanceAudit::class],
]);

it('exposes a human label for each audit type', function (ViolationAuditType $type, string $label): void {
    expect($type->label())->toBe($label);
})->with([
    [ViolationAuditType::Osha, 'OSHA'],
    [ViolationAuditType::BodyShop, 'Body Shop'],
    [ViolationAuditType::Glba, 'GLBA'],
]);

it('maps to the matching violation statement category', function (ViolationAuditType $type, ViolationStatementCategory $category): void {
    expect($type->violationStatementCategory())->toBe($category);
})->with([
    [ViolationAuditType::Osha, ViolationStatementCategory::Osha],
    [ViolationAuditType::BodyShop, ViolationStatementCategory::BodyShop],
    [ViolationAuditType::Glba, ViolationStatementCategory::Glba],
]);

it('round-trips a slug through fromSlug', function (string $slug, ViolationAuditType $expected): void {
    expect(ViolationAuditType::fromSlug($slug))->toBe($expected);
})->with([
    ['osha', ViolationAuditType::Osha],
    ['body-shop', ViolationAuditType::BodyShop],
    ['finance', ViolationAuditType::Glba],
]);

it('rejects unknown slugs', function (): void {
    ViolationAuditType::fromSlug('unknown');
})->throws(ValueError::class);

it('points each type at a model implementing the ViolationAudit contract', function (ViolationAuditType $type): void {
    expect(is_subclass_of($type->modelClass(), ViolationAudit::class))->toBeTrue();
})->with([
    ViolationAuditType::Osha,
    ViolationAuditType::BodyShop,
    ViolationAuditType::Glba,
]);
