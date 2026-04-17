# Wire-Elements Pro → Flux Migration Inventory

Generated while upgrading dashboard to Laravel 13 + Livewire 4 + Flux UI.
`wire-elements/pro` has been removed from `composer.json`. These files currently rely on compatibility shims at `stubs/shims/WireElements/` — they boot but their modal/slide-over/confirmation behaviour is **no-op** until migrated to Flux.

Until a page is migrated, any button that fires a wire-elements modal or `askForConfirmation()` will **silently do nothing**. Safer than auto-confirming destructive actions, but don't ship to prod like this.

## Shim surface

| Symbol | Shim location | Runtime behaviour |
| --- | --- | --- |
| `WireElements\Pro\Components\Modal\Modal` | `stubs/shims/WireElements/Pro/Components/Modal/Modal.php` | Abstract class extending `Livewire\Component`. No modal chrome. |
| `WireElements\Pro\Components\SlideOver\SlideOver` | `stubs/shims/WireElements/Pro/Components/SlideOver/SlideOver.php` | Same idea, no flyout chrome. |
| `WireElements\Pro\Concerns\InteractsWithConfirmationModal` | `stubs/shims/WireElements/Pro/Concerns/InteractsWithConfirmationModal.php` | `askForConfirmation()` is a no-op — does **not** auto-run the callback. |
| `Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia` | `stubs/shims/Spatie/MediaLibraryPro/Http/Livewire/Concerns/WithMedia.php` | Empty trait; upload flows no-op. |
| `Spatie\MediaLibraryPro\Models\TemporaryUpload` | `stubs/shims/Spatie/MediaLibraryPro/Models/TemporaryUpload.php` | Empty Eloquent model so `config/media-library.php` loads. |

Delete `stubs/shims/` once **all** the files below have been migrated.

---

## 1. PHP components extending `WireElements\Pro\Components\Modal\Modal` (55)

These extend a wire-elements modal base class. Replace with a plain `Livewire\Component` and wrap the view in a `<flux:modal>` triggered by the parent page.

### Central (20)

- [ ] `app/Http/Livewire/Central/AuditStatements/BodyShop/Delete.php`
- [ ] `app/Http/Livewire/Central/AuditStatements/Glba/Delete.php`
- [ ] `app/Http/Livewire/Central/AuditStatements/Osha/Delete.php`
- [ ] `app/Http/Livewire/Central/Contracts/Delete.php`
- [ ] `app/Http/Livewire/Central/CourseManagement/Import.php`
- [ ] `app/Http/Livewire/Central/Dealership/Create.php`
- [ ] `app/Http/Livewire/Central/Dealership/Delete.php`
- [ ] `app/Http/Livewire/Central/Department/Delete.php`
- [ ] `app/Http/Livewire/Central/Docs/Delete.php`
- [ ] `app/Http/Livewire/Central/Employee/Delete.php`
- [ ] `app/Http/Livewire/Central/Event/Create.php`
- [ ] `app/Http/Livewire/Central/Permission/Delete.php`
- [ ] `app/Http/Livewire/Central/Role/Delete.php`
- [ ] `app/Http/Livewire/Central/Sds/Delete.php`
- [ ] `app/Http/Livewire/Central/SharedDocs/Delete.php`
- [ ] `app/Http/Livewire/Central/User/Delete.php`

### Dealer (25)

- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/Modal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Components/DeleteCommentConfirmationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Components/EditCommentModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/Modal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/ImageModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Individual/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/Modal.php`
- [ ] `app/Http/Livewire/Dealer/Course/Reset.php`
- [ ] `app/Http/Livewire/Dealer/Docs/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Employee/CustomMessageModal.php`
- [ ] `app/Http/Livewire/Dealer/Employee/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Employee/DeleteInvite.php`
- [ ] `app/Http/Livewire/Dealer/Employee/EditCourseTaken.php`
- [ ] `app/Http/Livewire/Dealer/Employee/Import.php`
- [ ] `app/Http/Livewire/Dealer/Employee/ManagerInvite.php`
- [ ] `app/Http/Livewire/Dealer/Employee/ResendInvite.php`
- [ ] `app/Http/Livewire/Dealer/Manual/Cms/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Manual/Isp/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Manual/Osha/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Manual/RedFlag/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Store/Create.php`
- [ ] `app/Http/Livewire/Dealer/Store/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Vendor/Create.php`
- [ ] `app/Http/Livewire/Dealer/Vendor/Delete.php`

### Tenant (8)

- [ ] `app/Http/Livewire/Tenant/Audit/DealJacket/Components/MarkCompleteModal.php`
- [ ] `app/Http/Livewire/Tenant/Audit/DealJacket/DealJacketDeleteModal.php`
- [ ] `app/Http/Livewire/Tenant/Audit/DealJacket/DealJacketGroupDeleteModal.php`
- [ ] `app/Http/Livewire/Tenant/Audit/DealJacket/GenerateReport.php`
- [ ] `app/Http/Livewire/Tenant/Audit/Fit/Delete.php`
- [ ] `app/Http/Livewire/Tenant/Employee/Components/EditCourseTakenModal.php`
- [ ] `app/Http/Livewire/Tenant/Location/CreateModal.php`
- [ ] `app/Http/Livewire/Tenant/Location/EditStoreModal.php`
- [ ] `app/Http/Livewire/Tenant/Sds/RequestForm.php`

---

## 2. PHP components extending `WireElements\Pro\Components\SlideOver\SlideOver` (6)

Replace with `<flux:modal variant="flyout">`.

- [ ] `app/Http/Livewire/Central/Dealership/ConsultantEdit.php`
- [ ] `app/Http/Livewire/Central/Dealership/Edit.php`
- [ ] `app/Http/Livewire/Central/Employee/Edit.php`
- [ ] `app/Http/Livewire/Dealer/Employee/Edit.php`
- [ ] `app/Http/Livewire/Dealer/Employee/Invite.php`
- [ ] `app/Http/Livewire/Dealer/Vendor/Edit.php`

---

## 3. PHP files using `InteractsWithConfirmationModal` trait (19)

Each file calls `$this->askForConfirmation(callback: ..., prompt: [...])`. Replace with a Flux confirmation modal + explicit wire:click on the confirm button.

- [ ] `app/Http/Livewire/Central/AuditStatements/BodyShop/Delete.php`
- [ ] `app/Http/Livewire/Central/AuditStatements/Glba/Delete.php`
- [ ] `app/Http/Livewire/Central/AuditStatements/Osha/Delete.php`
- [ ] `app/Http/Livewire/Central/Contracts/Delete.php`
- [ ] `app/Http/Livewire/Central/Contracts/IndexItem.php`
- [ ] `app/Http/Livewire/Central/Dealership/Delete.php`
- [ ] `app/Http/Livewire/Central/Sds/Delete.php`
- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/Edit.php`
- [ ] `app/Http/Livewire/Dealer/Audit/BodyShop/RemediationForm.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Components/DeleteCommentConfirmationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/Edit.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Finance/RemediationForm.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/CompleteRemediationModal.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/Edit.php`
- [ ] `app/Http/Livewire/Dealer/Audit/Osha/RemediationForm.php`
- [ ] `app/Http/Livewire/Dealer/Course/Reset.php`
- [ ] `app/Http/Livewire/Dealer/Settings/CourseResetManager.php`

---

## 4. Blade views coupled to wire-elements components

These are the companion views for the PHP components above. Rewriting the PHP class will almost always mean rewriting its view too. Grouped alongside the components.

### Dealer audit / vendor / store / manual / docs / employee / course views

- [ ] `resources/views/livewire/dealer/audit/body-shop/complete-remediation-modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/body-shop/delete.blade.php`
- [ ] `resources/views/livewire/dealer/audit/body-shop/index.blade.php`
- [ ] `resources/views/livewire/dealer/audit/body-shop/modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/components/edit-comment-modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/finance/complete-remediation-modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/finance/delete.blade.php`
- [ ] `resources/views/livewire/dealer/audit/finance/index.blade.php`
- [ ] `resources/views/livewire/dealer/audit/finance/modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/image-modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/individual/delete.blade.php`
- [ ] `resources/views/livewire/dealer/audit/osha/complete-remediation-modal.blade.php`
- [ ] `resources/views/livewire/dealer/audit/osha/delete.blade.php`
- [ ] `resources/views/livewire/dealer/audit/osha/index.blade.php`
- [ ] `resources/views/livewire/dealer/audit/osha/modal.blade.php`
- [ ] `resources/views/livewire/dealer/docs/delete.blade.php`
- [ ] `resources/views/livewire/dealer/employee/custom-message-modal.blade.php`
- [ ] `resources/views/livewire/dealer/employee/delete-invite.blade.php`
- [ ] `resources/views/livewire/dealer/employee/delete.blade.php`
- [ ] `resources/views/livewire/dealer/employee/edit-course-taken.blade.php`
- [ ] `resources/views/livewire/dealer/employee/edit.blade.php`
- [ ] `resources/views/livewire/dealer/employee/import.blade.php`
- [ ] `resources/views/livewire/dealer/employee/invite.blade.php`
- [ ] `resources/views/livewire/dealer/employee/manager-invite.blade.php`
- [ ] `resources/views/livewire/dealer/employee/resend-invite.blade.php`
- [ ] `resources/views/livewire/dealer/manual/cms/delete.blade.php`
- [ ] `resources/views/livewire/dealer/manual/isp/delete.blade.php`
- [ ] `resources/views/livewire/dealer/manual/osha/delete.blade.php`
- [ ] `resources/views/livewire/dealer/manual/red-flag/delete.blade.php`
- [ ] `resources/views/livewire/dealer/store/create.blade.php`
- [ ] `resources/views/livewire/dealer/store/delete.blade.php`
- [ ] `resources/views/livewire/dealer/vendor/create.blade.php`
- [ ] `resources/views/livewire/dealer/vendor/delete.blade.php`
- [ ] `resources/views/livewire/dealer/vendor/edit.blade.php`

### Central views

- [ ] `resources/views/livewire/central/course-management/import.blade.php`
- [ ] `resources/views/livewire/central/dealership/consultant-edit.blade.php`
- [ ] `resources/views/livewire/central/dealership/create.blade.php`
- [ ] `resources/views/livewire/central/dealership/edit.blade.php`
- [ ] `resources/views/livewire/central/department/delete.blade.php`
- [ ] `resources/views/livewire/central/docs/delete.blade.php`
- [ ] `resources/views/livewire/central/employee/delete.blade.php`
- [ ] `resources/views/livewire/central/employee/edit.blade.php`
- [ ] `resources/views/livewire/central/employee/restore.blade.php`
- [ ] `resources/views/livewire/central/event/create.blade.php`
- [ ] `resources/views/livewire/central/permission/delete.blade.php`
- [ ] `resources/views/livewire/central/role/delete.blade.php`
- [ ] `resources/views/livewire/central/shared-docs/delete.blade.php`
- [ ] `resources/views/livewire/central/user/delete.blade.php`

### Tenant views

- [ ] `resources/views/livewire/tenant/audit/deal-jacket/components/mark-complete-modal.blade.php`
- [ ] `resources/views/livewire/tenant/audit/deal-jacket/deal-jacket-delete-modal.blade.php`
- [ ] `resources/views/livewire/tenant/audit/deal-jacket/deal-jacket-group-delete-modal.blade.php`
- [ ] `resources/views/livewire/tenant/audit/deal-jacket/generate-report.blade.php`
- [ ] `resources/views/livewire/tenant/audit/fit/delete.blade.php`
- [ ] `resources/views/livewire/tenant/employee/components/edit-course-taken-modal.blade.php`
- [ ] `resources/views/livewire/tenant/location/create-modal.blade.php`
- [ ] `resources/views/livewire/tenant/location/edit-store-modal.blade.php`
- [ ] `resources/views/livewire/tenant/sds/request-form.blade.php`

---

## 5. Vendor publish artifacts to delete

These were published by the wire-elements package and are now orphaned. Delete when convenient:

- [ ] `resources/views/vendor/wire-elements-pro/` (whole directory — spotlight/modal/insert overrides)

---

## 6. Front-end entry points

- [ ] `resources/js/bootstrap.js` — search for `Spotlight`, `@wire-elements`, `livewire:load` (→ `livewire:init`)
- [ ] `resources/css/app.css` — remove `@import` lines for wire-elements / media-library-pro CSS
- [ ] `package.json` — drop any `@wire-elements/*` npm packages

---

## Suggested migration order

1. Simple delete confirmation modals (no MediaLibrary coupling) — ~20 files across Central and Dealer. One at a time, wire up a `<flux:modal variant="confirmation">` per page.
2. Create / Edit slide-over forms (6 files) — convert to `<flux:modal variant="flyout">`.
3. Audit remediation / edit / CompleteRemediationModal chains — these also touch `WithMedia` upload flows, so pair the Flux file-upload migration with them.
4. Last: delete `stubs/shims/` directory and the classmap entry in `composer.json`.
