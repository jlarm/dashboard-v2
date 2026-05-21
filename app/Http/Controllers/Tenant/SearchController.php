<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Domain\Tenant\Search\Queries\GlobalSearch;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request, GlobalSearch $globalSearch): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        /** @var User $user */
        $user = $request->user();

        return response()->json([
            'groups' => $globalSearch->handle($user, (string) ($validated['q'] ?? '')),
        ]);
    }
}
