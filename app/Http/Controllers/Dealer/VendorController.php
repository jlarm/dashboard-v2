<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dealer;

use App\Domain\Tenant\Vendor\Actions\CreateVendor;
use App\Domain\Tenant\Vendor\Actions\DeleteVendor;
use App\Domain\Tenant\Vendor\Actions\DownloadVendorForm;
use App\Domain\Tenant\Vendor\Actions\SendVendorForm;
use App\Domain\Tenant\Vendor\Actions\SubmitVendorForm;
use App\Domain\Tenant\Vendor\Data\VendorFormData;
use App\Domain\Tenant\Vendor\Data\VendorListData;
use App\Domain\Tenant\Vendor\Data\VendorPublicFormData;
use App\Domain\Tenant\Vendor\Queries\GetVendorDetail;
use App\Domain\Tenant\Vendor\Queries\GetVendorIndexOptions;
use App\Domain\Tenant\Vendor\Queries\GetVendors;
use App\Domain\Tenant\Vendor\Support\RiskAssessmentQuestions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Vendor\SendVendorFormRequest;
use App\Http\Requests\Tenant\Vendor\StoreVendorRequest;
use App\Http\Requests\Tenant\Vendor\SubmitVendorFormRequest;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VendorController extends Controller
{
    public function index(Request $request, GetVendors $getVendors, GetVendorIndexOptions $getOptions): InertiaResponse
    {
        $this->authorize('viewAny', Vendor::class);

        $user = $request->user();
        $options = $getOptions->handle();

        return Inertia::render('tenant/vendor/Index', [
            'vendors' => array_map(
                static fn (VendorListData $data): array => $data->toArray(),
                $getVendors->handle($user),
            ),
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
        $createVendor->handle($request->toData());

        return back()->with('flash.success', 'Vendor created successfully.');
    }

    public function sendForm(SendVendorFormRequest $request, Vendor $vendor, SendVendorForm $sendVendorForm): RedirectResponse
    {
        $sendVendorForm->handle($vendor, $request->toData());

        return back()->with('flash.success', 'Form sent successfully.');
    }

    public function destroy(Vendor $vendor, DeleteVendor $deleteVendor): RedirectResponse
    {
        $this->authorize('delete', $vendor);

        $deleteVendor->handle($vendor);

        return to_route('dealer.vendor.index')->with('flash.success', 'Vendor deleted successfully.');
    }

    public function downloadForm(VendorForm $vendorForm, DownloadVendorForm $download): ?StreamedResponse
    {
        $this->authorize('view', $vendorForm->vendor);

        return $download->handle($vendorForm);
    }

    public function form(Request $request): InertiaResponse|RedirectResponse
    {
        $vendorForm = VendorForm::query()
            ->with(['vendor.store:id,name'])
            ->findOrFail((int) $request->input('vid'));

        if ($vendorForm->signature || $vendorForm->document_path) {
            return to_route('dealer.vendors.thankyou');
        }

        $storeName = $vendorForm->vendor->store?->name
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

        $submitVendorForm->handle($vendorForm, $request->toData());

        return to_route('dealer.vendors.thankyou');
    }

    public function thankyou(): InertiaResponse
    {
        return Inertia::render('tenant/vendor/Thankyou');
    }
}
