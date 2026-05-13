<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\BuildComplianceSummary;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;

describe('SendComplianceSummaryJob vendor stats', function (): void {

    beforeEach(function (): void {
        $this->service = resolve(BuildComplianceSummary::class);
        $this->store = Store::query()->first();
    });

    it('counts vendors assigned to the store', function (): void {
        Vendor::query()->create(['name' => 'Store Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => $this->store->id]);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['total'])->toBeGreaterThanOrEqual(1);
    });

    it('includes all-stores vendors (store_id null) in the count', function (): void {
        $before = $this->service->collectStoreData($this->store)['vendorStats']['total'];

        Vendor::query()->create(['name' => 'Global Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);

        $after = $this->service->collectStoreData($this->store)['vendorStats']['total'];

        expect($after)->toBe($before + 1);
    });

    it('does not count vendors belonging to a different store', function (): void {
        $otherStore = Store::query()->create(['name' => 'Other Store', 'slug' => 'other-store']);

        $before = $this->service->collectStoreData($this->store)['vendorStats']['total'];

        Vendor::query()->create(['name' => 'Other Store Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => $otherStore->id]);

        $after = $this->service->collectStoreData($this->store)['vendorStats']['total'];

        expect($after)->toBe($before);
    });

    it('counts a vendor as completed when its latest form has a signature', function (): void {
        $vendor = Vendor::query()->create(['name' => 'Signed Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        VendorForm::query()->create(['vendor_id' => $vendor->id, 'name' => 'Form', 'email' => 'v@example.com', 'signature' => 'base64sig==']);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['completed'])->toBeGreaterThanOrEqual(1);
    });

    it('counts a vendor as completed when its latest form has a document_path', function (): void {
        $vendor = Vendor::query()->create(['name' => 'Doc Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        VendorForm::query()->create(['vendor_id' => $vendor->id, 'name' => 'Form', 'email' => 'v@example.com', 'document_path' => '/path/to/doc.pdf']);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['completed'])->toBeGreaterThanOrEqual(1);
    });

    it('does not count a vendor as completed when its latest form has no signature or document_path', function (): void {
        Vendor::query()->delete();

        $vendor = Vendor::query()->create(['name' => 'Unsigned Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        VendorForm::query()->create(['vendor_id' => $vendor->id, 'name' => 'Form', 'email' => 'v@example.com']);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['total'])->toBe(1);
        expect($data['vendorStats']['completed'])->toBe(0);
    });

    it('does not count a vendor with no forms as completed', function (): void {
        Vendor::query()->delete();

        Vendor::query()->create(['name' => 'No Form Vendor', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['completed'])->toBe(0);
    });

    it('calculates the vendor percentage correctly', function (): void {
        Vendor::query()->delete();

        $v1 = Vendor::query()->create(['name' => 'Vendor One', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        VendorForm::query()->create(['vendor_id' => $v1->id, 'name' => 'Form', 'email' => 'v1@example.com', 'signature' => 'sig']);

        Vendor::query()->create(['name' => 'Vendor Two', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        Vendor::query()->create(['name' => 'Vendor Three', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);
        Vendor::query()->create(['name' => 'Vendor Four', 'contact_name' => 'Contact', 'contact_email' => 'c@example.com', 'store_id' => null]);

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['total'])->toBe(4);
        expect($data['vendorStats']['completed'])->toBe(1);
        expect($data['vendorStats']['percentage'])->toBe(25);
    });

    it('returns N/A grade when there are no vendors', function (): void {
        Vendor::query()->delete();

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['grade'])->toBe('N/A');
    });

    it('derives the correct letter grade from the vendor percentage', function (int $completed, int $total, string $expectedGrade): void {
        Vendor::query()->delete();

        for ($i = 0; $i < $total; $i++) {
            $vendor = Vendor::query()->create(['name' => "Vendor {$i}", 'contact_name' => 'Contact', 'contact_email' => "v{$i}@example.com", 'store_id' => null]);
            if ($i < $completed) {
                VendorForm::query()->create(['vendor_id' => $vendor->id, 'name' => 'Form', 'email' => "v{$i}@example.com", 'signature' => 'sig']);
            }
        }

        $data = $this->service->collectStoreData($this->store);

        expect($data['vendorStats']['grade'])->toBe($expectedGrade);
    })->with([
        '90%+ → A' => [9, 10, 'A'],
        '80-89% → B' => [8, 10, 'B'],
        '70-79% → C' => [7, 10, 'C'],
        '60-69% → D' => [6, 10, 'D'],
        '<60% → F' => [5, 10, 'F'],
    ]);

});
