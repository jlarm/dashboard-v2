<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit;

use App\Domain\Tenant\FitTests\Actions\CreateFitTest;
use App\Domain\Tenant\FitTests\Actions\DeleteFitTest;
use App\Domain\Tenant\FitTests\Queries\GetFitTestEmployees;
use App\Domain\Tenant\FitTests\Queries\GetFitTests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Audit\Concerns\ResolvesAuditScope;
use App\Http\Requests\Tenant\Audit\StoreFitTestRequest;
use App\Models\FitTestDoc;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class FitTestController extends Controller
{
    use ResolvesAuditScope;

    public function index(Request $request, GetFitTests $getFitTests, GetFitTestEmployees $getFitTestEmployees): InertiaResponse
    {
        $store = $this->resolveCurrentStoreOrFail();

        $user = $request->user();
        $canManage = $user instanceof User && $user->can('create-dealerships');

        return Inertia::render('tenant/audit/FitTests', [
            'fitTests' => $getFitTests->handle($store),
            'employees' => $canManage ? $getFitTestEmployees->handle($store) : [],
            'formUrl' => global_asset('docs/fit-test-form.pdf'),
            'can' => [
                'manage' => $canManage,
            ],
        ]);
    }

    public function store(StoreFitTestRequest $request, CreateFitTest $createFitTest): RedirectResponse
    {
        $store = $this->resolveCurrentStoreOrFail();

        try {
            $createFitTest->handle($store, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('flash.error', 'We could not save the fit test. Please try again.');
        }

        return back()->with('flash.success', 'Fit test uploaded successfully.');
    }

    public function destroy(Request $request, FitTestDoc $fitTestDoc, DeleteFitTest $deleteFitTest): RedirectResponse
    {
        abort_unless($request->user()?->can('create-dealerships') ?? false, 403);

        $store = $this->resolveCurrentStoreOrFail();
        abort_unless((int) $fitTestDoc->store_id === $store->id, 404);

        try {
            $deleteFitTest->handle($fitTestDoc);
        } catch (Throwable $e) {
            report($e);

            return back()->with('flash.error', 'We could not delete the fit test. Please try again.');
        }

        return back()->with('flash.success', 'Fit test deleted successfully.');
    }

    public function download(FitTestDoc $fitTestDoc): StreamedResponse
    {
        $store = $this->resolveCurrentStoreOrFail();
        abort_unless((int) $fitTestDoc->store_id === $store->id, 404);

        $disk = Storage::disk('dealer-docs');
        $filePath = $fitTestDoc->file_path;

        abort_unless($filePath !== '' && $disk->exists($filePath), 404);

        return $disk->response($filePath, 'fit-test.pdf');
    }
}
