<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\ViolationStatements\Actions\CreateViolationStatement;
use App\Domain\Central\ViolationStatements\Actions\DeleteViolationStatement;
use App\Domain\Central\ViolationStatements\Actions\UpdateViolationStatement;
use App\Domain\Central\ViolationStatements\Data\ViolationStatementData;
use App\Domain\Central\ViolationStatements\Queries\SearchViolationStatements;
use App\Enums\ViolationStatementCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\ViolationStatement\StoreViolationStatementRequest;
use App\Http\Requests\Central\ViolationStatement\UpdateViolationStatementRequest;
use App\Http\Resources\Central\ViolationStatementResource;
use App\Models\User;
use App\Models\ViolationStatement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

class ViolationStatementController extends Controller
{
    public function index(
        Request $request,
        SearchViolationStatements $searchViolationStatements,
    ): Response {
        $this->authorize('viewAny', ViolationStatement::class);

        /** @var User $user */
        $user = $request->user();

        $search = $request->string('search')->toString() ?: null;
        $category = ViolationStatementCategory::tryFrom($request->string('category')->toString());

        return Inertia::render('central/violation-statements/Index', [
            'statements' => ViolationStatementResource::collection(
                $searchViolationStatements->handle($search, $category)
            ),
            'filters' => [
                'search' => $search,
                'category' => $category?->value,
            ],
            'categories' => $this->categoryOptions(),
            'can' => [
                'create' => $user->can('create', ViolationStatement::class),
                'update' => $user->can('update', ViolationStatement::class),
                'delete' => $user->can('delete', ViolationStatement::class),
            ],
        ]);
    }

    public function store(
        StoreViolationStatementRequest $request,
        CreateViolationStatement $action,
    ): RedirectResponse {
        $this->authorize('create', ViolationStatement::class);

        $action->handle($this->violationStatementData($request));

        return to_route('violation-statements.index')
            ->with('flash.success', 'Violation statement created.');
    }

    public function update(
        UpdateViolationStatementRequest $request,
        ViolationStatement $violationStatement,
        UpdateViolationStatement $action,
    ): RedirectResponse {
        $this->authorize('update', $violationStatement);

        $action->handle(
            $violationStatement,
            $this->violationStatementData($request),
            (bool) $request->validated('remove_image', false),
        );

        return back()->with('flash.success', 'Violation statement updated.');
    }

    public function destroy(
        ViolationStatement $violationStatement,
        DeleteViolationStatement $action,
    ): RedirectResponse {
        $this->authorize('delete', $violationStatement);

        $action->handle($violationStatement);

        return to_route('violation-statements.index')
            ->with('flash.success', 'Violation statement deleted.');
    }

    private function violationStatementData(FormRequest $request): ViolationStatementData
    {
        /** @var array{statement: string, weight: int, categories: list<string>, keywords?: list<string>|null} $validated */
        $validated = $request->validated();

        $image = $request->file('image');

        return new ViolationStatementData(
            statement: $validated['statement'],
            weight: (int) $validated['weight'],
            categories: array_map(
                ViolationStatementCategory::from(...),
                $validated['categories'],
            ),
            keywords: $validated['keywords'] ?? null,
            image: $image instanceof UploadedFile ? $image : null,
        );
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    private function categoryOptions(): array
    {
        return array_map(
            fn (ViolationStatementCategory $category): array => [
                'value' => $category->value,
                'label' => $category->label(),
            ],
            ViolationStatementCategory::cases(),
        );
    }
}
