<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Domain\Tenant\Vendor\Actions\CreateVendor;
use App\Domain\Tenant\Vendor\Actions\DeleteVendor;
use App\Domain\Tenant\Vendor\Actions\DownloadVendorForm;
use App\Domain\Tenant\Vendor\Actions\SendVendorForm;
use App\Domain\Tenant\Vendor\Actions\SubmitVendorForm;
use App\Domain\Tenant\Vendor\Data\VendorFormData;
use App\Domain\Tenant\Vendor\Data\VendorPublicFormData;
use App\Domain\Tenant\Vendor\Queries\GetVendorDetail;
use App\Domain\Tenant\Vendor\Queries\GetVendorIndexOptions;
use App\Domain\Tenant\Vendor\Queries\GetVendors;
use App\Domain\Tenant\Vendor\Support\RiskAssessmentQuestions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Vendor\IndexVendorsRequest;
use App\Http\Requests\Tenant\Vendor\SendVendorFormRequest;
use App\Http\Requests\Tenant\Vendor\StoreVendorRequest;
use App\Http\Requests\Tenant\Vendor\SubmitVendorFormRequest;
use App\Http\Resources\Tenant\VendorResource;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class VendorController extends Controller
{
    public function index(IndexVendorsRequest $request, GetVendors $getVendors, GetVendorIndexOptions $getOptions): InertiaResponse
    {
        $user = $request->user();
        $options = $getOptions->handle();
        $paginator = $getVendors->handle($user, $request->search(), $request->page());

        return Inertia::render('tenant/vendor/Index', [
            'vendors' => VendorResource::collection($paginator),
            'filters' => ['search' => $request->search()],
            'stores' => $options['stores'],
            'multipleStoresExist' => $options['multipleStoresExist'],
            'hasQualifiedIndividual' => $options['hasQualifiedIndividual'],
            'can' => [
                'create' => $user?->can('create', Vendor::class) ?? false,
            ],
        ]);
    }

    public function show(Request $request, Vendor $vendor, GetVendorDetail $getDetail): InertiaResponse
    {
        $this->authorize('view', $vendor);

        $payload = $getDetail->handle($vendor);
        $user = $request->user();

        return Inertia::render('tenant/vendor/Show', [
            'vendor' => $payload['detail']->toArray(),
            'forms' => array_map(
                static fn (VendorFormData $form): array => $form->toArray(),
                $payload['forms'],
            ),
            'multipleStoresExist' => Store::query()->count() > 1,
            'can' => [
                'update' => $user?->can('update', $vendor) ?? false,
                'delete' => $user?->can('delete', $vendor) ?? false,
            ],
        ]);
    }

    public function store(StoreVendorRequest $request, CreateVendor $createVendor): RedirectResponse
    {
        try {
            $createVendor->handle($request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'We could not create the vendor. Please try again.');
        }

        return back()->with('success', 'Vendor created successfully.');
    }

    public function sendForm(SendVendorFormRequest $request, Vendor $vendor, SendVendorForm $sendVendorForm): RedirectResponse
    {
        try {
            $sendVendorForm->handle($vendor, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'We could not send the vendor form. Please try again.');
        }

        return back()->with('success', 'Form sent successfully.');
    }

    public function destroy(Vendor $vendor, DeleteVendor $deleteVendor): RedirectResponse
    {
        $this->authorize('delete', $vendor);

        try {
            $deleteVendor->handle($vendor);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'We could not delete the vendor. Please try again.');
        }

        return to_route('dealer.vendor.index')->with('success', 'Vendor deleted successfully.');
    }

    public function downloadForm(VendorForm $vendorForm, DownloadVendorForm $download): StreamedResponse
    {
        $this->authorize('view', $vendorForm->vendor);

        try {
            $response = $download->handle($vendorForm);
        } catch (Throwable $e) {
            report($e);
            abort(500, 'We could not generate the vendor form download.');
        }

        abort_if($response === null, 404);

        return $response;
    }

    public function form(Request $request): InertiaResponse|RedirectResponse
    {
        $vendorForm = VendorForm::query()
            ->with(['vendor.store:id,name'])
            ->findOrFail((int) $request->input('vid'));

        if ($vendorForm->signature || $vendorForm->document_path) {
            return to_route('dealer.vendors.thankyou');
        }

        $storeName = $vendorForm->vendor->store->name
            ?? Store::query()->orderBy('id')->value('name')
            ?? '';

        return Inertia::render('tenant/vendor/PublicForm', [
            'vendorForm' => VendorPublicFormData::fromModel($vendorForm)->toArray(),
            'storeName' => $storeName,
            'questions' => RiskAssessmentQuestions::all(),
            'submitUrl' => $request->fullUrl(),
        ]);
    }

    public function submit(SubmitVendorFormRequest $request, SubmitVendorForm $submitVendorForm): RedirectResponse
    {
        $vendorForm = VendorForm::query()->findOrFail((int) $request->input('vid'));

        if ($vendorForm->signature || $vendorForm->document_path) {
            return to_route('dealer.vendors.thankyou');
        }

        try {
            $submitVendorForm->handle($vendorForm, $request->toData());
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'We could not save your submission. Please try again.');
        }

        return to_route('dealer.vendors.thankyou');
    }

    public function thankyou(): InertiaResponse
    {
        return Inertia::render('tenant/vendor/Thankyou');
    }
}
