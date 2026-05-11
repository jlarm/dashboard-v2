<?php

declare(strict_types=1);

namespace App\Routing;

use App\Enums\ViolationAuditType;
use App\Http\Controllers\Tenant\Audit\ViolationAuditController;
use Illuminate\Support\Facades\Route;

/**
 * Registers the routes shared by every ViolationAudit type (OSHA, Body Shop,
 * Finance/GLBA). Each type pins its enum value via ->defaults('type', ...),
 * which the controller pulls back out to pick the right model class.
 */
class ViolationAuditRoutes
{
    public static function registerWrites(string $prefix, string $namePrefix, ViolationAuditType $type): void
    {
        Route::get("{$prefix}/create/{store}", [ViolationAuditController::class, 'create'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.create");
        Route::get("{$prefix}/{audit}/edit", [ViolationAuditController::class, 'edit'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.edit");
        Route::patch("{$prefix}/{audit}", [ViolationAuditController::class, 'update'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.update");
        Route::delete("{$prefix}/{audit}", [ViolationAuditController::class, 'destroy'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.destroy");
        Route::patch("{$prefix}/{audit}/grade", [ViolationAuditController::class, 'updateGrade'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.grade");
        Route::post("{$prefix}/{audit}/complete", [ViolationAuditController::class, 'complete'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.complete");
        Route::delete("{$prefix}/{audit}/complete", [ViolationAuditController::class, 'reopen'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.reopen");
        Route::post("{$prefix}/{audit}/violations", [ViolationAuditController::class, 'addViolation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.violations.store");
        Route::delete("{$prefix}/{audit}/violations/{violation}", [ViolationAuditController::class, 'deleteViolation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.violations.destroy");
        Route::delete("{$prefix}/{audit}/violations/{violation}/photos/{photoId}", [ViolationAuditController::class, 'deleteViolationPhoto'])
            ->defaults('type', $type)
            ->whereNumber('photoId')
            ->name("{$namePrefix}.violations.photos.destroy");
        Route::post("{$prefix}/{audit}/generate", [ViolationAuditController::class, 'generate'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.generate");
        Route::post("{$prefix}/{audit}/remediation/generate", [ViolationAuditController::class, 'generateRemediation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.remediation.generate");
        Route::get("{$prefix}/{audit}/violations/search", [ViolationAuditController::class, 'searchStatements'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.violations.search");
    }

    public static function registerReads(string $prefix, string $namePrefix, ViolationAuditType $type): void
    {
        Route::get($prefix, [ViolationAuditController::class, 'index'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.index");
        Route::get("{$prefix}/{audit}/remediation", [ViolationAuditController::class, 'remediation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.remediation");
        Route::patch("{$prefix}/{audit}/remediation", [ViolationAuditController::class, 'updateRemediation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.remediation.update");
        Route::get("{$prefix}/{audit}/download", [ViolationAuditController::class, 'download'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.download");
        Route::get("{$prefix}/{audit}/remediation/download", [ViolationAuditController::class, 'downloadRemediation'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.remediation.download");
        Route::get("{$prefix}/{audit}", [ViolationAuditController::class, 'show'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.show");
        Route::post("{$prefix}/{audit}/comments", [ViolationAuditController::class, 'storeComment'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.comments.store");
        Route::patch("{$prefix}/{audit}/comments/{comment}", [ViolationAuditController::class, 'updateComment'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.comments.update");
        Route::delete("{$prefix}/{audit}/comments/{comment}", [ViolationAuditController::class, 'destroyComment'])
            ->defaults('type', $type)
            ->name("{$namePrefix}.comments.destroy");
    }
}
