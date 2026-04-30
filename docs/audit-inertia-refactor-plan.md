# Audit Module Unification: Inertia + Vue 3 Migration Plan

Branch: `shift-172092` · Project root: `/Users/armp/Herd/dashboard`

## Decisions locked in (from review)

1. **Legacy Q1..Qn `Create.php` (678-line OSHA monolith and BodyShop/Finance equivalents):** dead code — delete in Phase 5 with the rest of the old Livewire trio.
2. **Drift between trio:** take Osha behaviour as canonical for all three (cascade-delete audit comments, expose download endpoint, keep verbose `Log::info`/`Log::error` upload telemetry, real legacy-violation chart counts).
3. **Rename `GenerateAuditPdfJob` / `UploadAuditToDigitalOceanJob`** (Finance-only) → `GenerateGlbaAuditPdfJob` / `UploadGlbaAuditToDigitalOceanJob`. Rename happens in Phase 4.
4. **Keep model name `GlbaViolationAudit`** (regulatory framework name) while URL stays `audits/finance`. The enum reconciles via `slug() = 'finance'` and `modelClass() = GlbaViolationAudit::class`.
5. **`remediation.update` (PATCH) stays in the broader role group** (super-admin / Consultant / Owner / CFO / GM / GSM / Qualified Individual), matching the current `RemediationForm::editRemediations` reachability.
6. **Multi-image uploads collapse into a single field.** Anywhere the current Livewire form exposes three separate image upload inputs (e.g. violation photos, remediation photos), the new Vue form replaces them with a single multi-file upload that accepts up to 3 images. Validation, MediaLibrary collection, and storage stay identical — only the UI input and form binding change. Applies to both violation file attachments on `Edit` and remediation photos on `RemediationForm`.
7. **Charts use shadcn-vue chart components.** The Index chart (currently a Livewire/Chart.js or similar render of `BuildAuditChartData` output) is rebuilt with shadcn-vue's chart components (`<Chart>`, `<ChartContainer>`, `<ChartTooltip>`, etc., backed by Recharts/Vue-Chartjs per the shadcn-vue docs). Install via the shadcn-vue CLI into `resources/js/components/ui/chart/` if not already present. The `AuditChart.vue` component listed in section 2.7 wraps a shadcn-vue chart and consumes `ViolationAuditChartData` props directly. No new chart data shape — just a different renderer.
8. **Image uploads are mobile-first and HEIC-tolerant.** Real-world usage: a tech photographs violations or remediations on an iPhone/Android in the field, often on flaky cell signal, and iPhones default to HEIC. The upload pipeline must be efficient and resilient:
   - **Client-side resize + re-encode before upload.** Use `<input type="file" accept="image/*,.heic,.heif" multiple capture="environment">` paired with a small JS helper (e.g. `browser-image-compression` or a hand-rolled `<canvas>` step) that downscales to a sane long-edge (~2000px), re-encodes to JPEG quality ~0.82, and strips EXIF apart from orientation. Cuts a 5–8 MB phone photo down to ~300–600 KB before bytes leave the device.
   - **HEIC/HEIF conversion in the browser.** When the picked file is HEIC, run it through `heic2any` (or equivalent) to JPEG client-side before the resize step. Server-side HEIC conversion is a fallback only — converting HEIC server-side requires `imagick` with the `heic` delegate (DigitalOcean App Platform images don't always include it) and burns CPU per upload. Doing it in the browser keeps the API stateless and the server cheap.
   - **Concurrent multi-file upload with progress.** `useForm({ images: [] }).post(..., { forceFormData: true, onProgress })` for a single batched request; show a per-file progress strip in the Vue component so the user knows uploads aren't stalled on slow LTE.
   - **Validation accepts HEIC and modern formats.** Form Request rules: `images.*` → `file|mimes:jpg,jpeg,png,webp,heic,heif|max:10240` (10 MB ceiling — generous because the client-side resize should leave us well under). Server still does a final validation in case JS is bypassed.
   - **Server-side processing in the Action, not the request cycle.** `addMedia()` calls happen synchronously today; consider dispatching a queued conversion (Spatie MediaLibrary's `responsive_images` / `OptimizesImages` conversions) so the user gets a fast 200 and the heavy `imagick` work runs on the queue. Acceptable to keep synchronous in Phase 2 if it's already that way; flag as a Phase 6 polish item if not.
   - **Test coverage**: upload an HEIC fixture, an oversized JPEG, and a multi-file batch to assert all three produce normalised attachments via `Storage::fake('armpaudits')`.

---

## 1. Current state

### Three parallel modules — confirmed near-duplicates

Each of `app/Http/Livewire/Dealer/Audit/{Osha,BodyShop,Finance}/` contains the same 17 Livewire classes. They are token-for-token copies with **only model/view/route names swapped**, except where one module has accumulated extra logging/exception-handling that drifted (Osha `Edit.php` has more verbose logging; BodyShop and Finance share the older terser version).

- **`Index.php`**: identical chart-data/listing logic. Body Shop and Finance even chart `'violations' => 0` for legacy audits because the legacy `BodyShopAudit`/`FinanceAudit` rows lack a relationship — Osha is the only one that pulls real legacy `violations` counts. Per decision #2, Osha behaviour wins.
- **`Single.php`**: identical except model/property name. Rating math (`count <= 10 → 75`, etc.) is identical across all three.
- **`RemediationForm.php`**: identical except model/property/view path. Already shares `App\Http\Livewire\Dealer\Audit\Traits\UpdateRemediations`.
- **`Edit.php`**: ~95% identical. Each pulls a different `HasXxxViolationStatements` trait (Osha/BodyShop/Glba) at `app/Traits/`. Osha `Edit` has extra `Log::info`/`Log::error` upload telemetry and a richer `catch` block.
- **`Create.php`** — legacy Q1..Qn monoliths writing to legacy `*Audit` tables. **Dead code.** Delete in Phase 5.
- **`Generate.php`**: dispatches a chained PDF generate + DO upload job. Naming is inconsistent (Finance uses generic-named jobs; renamed in Phase 4).
- **`Delete.php`** / **`Download.php`** / **`OldAuditIndex.php`**: hit legacy `*Audit` (non-violation) models on the `do-audits` disk. Osha `Delete` cascades comments; Osha `Download` exposes a `download()` action — both behaviours adopted as canonical.
- **`*ViolationAudit` models** (Osha/BodyShop/Glba): same shape — `uuid`, `user_id`, `store_id`, `pdf_path`, `remediation_pdf_path`, `date`, `grade`, `grade_updated_*`, `completed_date`, `reminder_logs`, plus identical `violations()` / `reminders()` / `auditComments()` morph relations. Three distinct Eloquent classes, three distinct tables, no shared base today.
- **Three controllers** (`OshaCreateController`, `BodyShopCreateController`, `FinanceCreateController`): byte-for-byte identical except for model class and `dealer.audit.{slug}.edit` redirect target.

### Routes today (`routes/tenant.php`)

Two **separate** prefix groups, both `audits/`, named `audit.*`, both with `single.store`, split by role:

- **Lines 179–206** (`role:super-admin|Consultant`): `osha.create`, `osha.edit`, `body-shop.create`, `body-shop.edit`, `finance.create`, `finance.edit`. `finance.create` adds `can:create-audits`.
- **Lines 333–348** (`role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual`): `osha.{index,remediation,show}`, `body-shop.{index,remediation,show}`, `finance.{index,remediation,show}`.

### Tests today

- `tests/Feature/Tenant/Audits/Osha/EditOshaViolationAuditTest.php`
- `tests/Feature/Tenant/Audits/Osha/RemediationFormTest.php`
- `tests/Feature/Tenant/Audits/Osha/UploadOshaPdfJobTest.php`
- `tests/Feature/Tenant/Audits/BodyShop/BodyShopViolationModalTest.php`
- `tests/Feature/Tenant/Audits/BodyShop/UploadBodyShopPdfJobTest.php`
- `tests/Feature/Tenant/Audits/Glba/UploadGlbaPdfJobTest.php`
- `tests/Unit/Jobs/Audit/{GenerateOsha,GenerateBodyShop,GenerateGlba}PdfJobTest.php`
- `tests/Feature/Tenant/Manuals/Osha/OshaControllerTest.php` — the reference pattern.

OSHA has the deepest coverage; BodyShop/Glba have only PDF-job tests. Glba has no Edit/Remediation/Modal tests at all.

### Reference: Manuals pattern (commit 72b48dd0)

```
app/Domain/Tenant/Manuals/{Osha,Isp,Cms,RedFlag}/
    Actions/    (CreateOshaManual, DeleteOshaManual, …)
    Data/       (OshaFormDefaultsData, OshaManualFormData, OshaManualListItemData)
    Queries/    (BuildOshaFormDefaults, ListOshaManuals)
app/Domain/Tenant/Manuals/Queries/ResolveManualStores.php
app/Http/Controllers/Tenant/Manuals/{Osha,Isp,Cms,RedFlag}Controller.php
app/Http/Controllers/Tenant/Manuals/Concerns/ResolvesManualStore.php
app/Http/Requests/Tenant/Manuals/Osha/StoreOshaManualRequest.php
resources/js/pages/tenant/manuals/{osha,isp,cms,red-flag}/{Index,Create}.vue
resources/js/components/manuals/...
```

Each controller injects Action and Query classes; FormRequest exposes `toData()` returning a typed Data object; Inertia render takes plain arrays from `Data::toArray()`. Mirror this exactly.

---

## 2. Proposed architecture

**Single set of controllers parameterised by audit type, backed by a shared `ViolationAuditType` enum that resolves the per-type model + slug + display name + question schema.** Three tables stay (DB unification is a separate beast, not asked for); behaviour unifies in code.

### The unification

1. **`App\Enums\ViolationAuditType`** (`OSHA`, `BODY_SHOP`, `GLBA`) with methods:
   - `slug(): string` — `'osha' | 'body-shop' | 'finance'` (preserves URL compat per decision #4)
   - `modelClass(): class-string<ViolationAudit>` — Osha/BodyShop/GlbaViolationAudit
   - `legacyModelClass(): class-string` — Osha/BodyShop/FinanceAudit (read-only archive use only)
   - `label(): string` — "OSHA" / "Body Shop" / "GLBA / Finance"
   - `pdfDisk(): string` and `pdfPath(string $tenantId, string $file): string`
   - `generatePdfJob(LegacyAudit): Job`, `uploadPdfJob(LegacyAudit): Job` — encapsulates the per-type job dispatching
   - `violationStatementCategory(): string`
   - `fromSlug(string): self` for route binding

2. **`App\Models\Dealer\Audit\Contracts\ViolationAudit`** interface declaring the shared shape: `uuid`, `date`, `grade`, `violations()`, `auditComments()`, `reminders()`, `store()`, `user()`, scopes for `forStores($ids)`. Each of the three models implements it. No DB change.

3. **`App\Domain\Tenant\Audits\` layer**:

   ```
   app/Domain/Tenant/Audits/
       Actions/
           CreateViolationAudit.php          // replaces 3 *CreateController
           UpdateViolationAudit.php          // replaces 3 Edit::edit()
           DeleteViolationAudit.php          // canonicalises Osha cascade-delete-comments
           AddViolationFromStatement.php     // replaces 3 violationSelected()
           DeleteViolationPhoto.php
           DeleteViolation.php
           UpdateRemediations.php            // promote the existing trait
           DispatchAuditPdfGeneration.php    // wraps Bus::chain(); resolves jobs via enum
           DispatchRemediationPdfGeneration.php
           SignAuditDownloadUrl.php          // shared do-audits path resolution
       Data/
           ViolationAuditListItemData.php
           ViolationAuditDetailData.php
           ViolationAuditChartData.php
           ViolationData.php
           RemediationData.php
           ViolationAuditFormData.php
       Queries/
           ListViolationAudits.php
           ListLegacyAudits.php              // read-only archive listing
           BuildAuditChartData.php           // canonicalises Osha behaviour
           ResolveAuditScopedStores.php      // mirrors ResolvesManualStore
           LoadViolationAuditWithRelations.php
       Strategies/
           OshaViolationStrategy.php         // ports HasOshaViolationStatements
           BodyShopViolationStrategy.php
           GlbaViolationStrategy.php
   ```

4. **Single Inertia controller** at `app/Http/Controllers/Tenant/Audit/ViolationAuditController.php`:

   ```
   index(type, …queries)        → Inertia::render('tenant/audits/Index', …)
   show(type, audit, …queries)  → Inertia::render('tenant/audits/Show', …)
   create(type, store, action)  → redirect to edit with new audit
   edit(type, audit, …queries)  → Inertia::render('tenant/audits/Edit', …)
   update(type, audit, request) → PATCH for Edit submit
   destroy(type, audit, action)
   remediation(type, audit, …)  → Inertia::render('tenant/audits/Remediation', …)
   updateRemediation(type, audit, request)
   addViolation(type, audit, request)
   deleteViolation(type, audit, violation)
   download(type, audit)        → signed URL redirect
   generate(type, legacyAudit)  → dispatch chain
   ```

   Type bound via custom route param resolver that maps `osha`/`body-shop`/`finance` → `ViolationAuditType` enum. The `*ViolationAudit:uuid` route-model bind continues to use the per-type model selected from the enum.

5. **Form Requests** mirror Manuals:
   - `App\Http\Requests\Tenant\Audits\UpdateViolationAuditRequest`
   - `App\Http\Requests\Tenant\Audits\UpdateRemediationsRequest`
   - `App\Http\Requests\Tenant\Audits\AddViolationRequest`

   Each exposes `toData(): SomeData`.

6. **What stays per-type**:
   - The three Eloquent models and their tables.
   - The three strategies (porting `Has{X}ViolationStatements` traits).
   - PDF generation jobs (renamed in Phase 4 per decision #3).

7. **Vue side**:

   ```
   resources/js/pages/tenant/audits/
       Index.vue              // accepts type prop
       Show.vue
       Edit.vue
       Remediation.vue
       components/
           AuditChart.vue
           ViolationCard.vue
           ViolationList.vue
           RemediationItem.vue
           AddViolationModal.vue
           AuditCommentList.vue
           DownloadButton.vue
           GenerateReportButton.vue
           GenerateRemediationButton.vue
           CompleteRemediationModal.vue
   resources/js/components/audits/
       useAuditType.ts
       audit-types.ts
   ```

   Each page receives `{ type: 'osha' | 'body-shop' | 'finance', audit: {...}, … }`. Per-type copy/labels in `audit-types.ts`.

8. **Wayfinder regeneration**. After routes change, run `php artisan wayfinder:generate`; Vue forms switch to typed actions.

---

## 3. New file layout

```
app/Enums/ViolationAuditType.php                                                NEW
app/Models/Dealer/Audit/Contracts/ViolationAudit.php                            NEW (interface)
    OshaViolationAudit / BodyShopViolationAudit / GlbaViolationAudit              IMPLEMENTS interface

app/Domain/Tenant/Audits/
    Actions/ (10 classes)                                                       NEW
    Data/ (5 classes)                                                           NEW
    Queries/ (5 classes)                                                        NEW
    Strategies/{Osha,BodyShop,Glba}ViolationStrategy.php                        NEW

app/Http/Controllers/Tenant/Audit/ViolationAuditController.php                  NEW
app/Http/Controllers/Tenant/Audit/Concerns/ResolvesAuditScope.php               NEW

app/Http/Requests/Tenant/Audits/{UpdateViolationAudit,UpdateRemediations,AddViolation}Request.php   NEW

app/Jobs/Audit/GenerateGlbaAuditPdfJob.php                                      NEW (renamed)
app/Jobs/Audit/UploadGlbaAuditToDigitalOceanJob.php                             NEW (renamed)

resources/js/pages/tenant/audits/{Index,Show,Edit,Remediation}.vue              NEW
resources/js/pages/tenant/audits/components/*.vue                               NEW
resources/js/components/audits/audit-types.ts                                   NEW
resources/js/components/audits/useAuditType.ts                                  NEW

routes/tenant.php                                                               EDIT

# Deleted in Phase 5:
app/Http/Livewire/Dealer/Audit/{Osha,BodyShop,Finance}/                         DELETE
app/Http/Livewire/Dealer/Audit/Traits/UpdateRemediations.php                    DELETE
app/Http/Controllers/Dealer/Audit/{Osha,BodyShop,Finance}CreateController.php   DELETE
app/Jobs/Audit/GenerateAuditPdfJob.php (legacy Finance-only)                    DELETE after rename
app/Jobs/Audit/UploadAuditToDigitalOceanJob.php (legacy Finance-only)           DELETE after rename
resources/views/livewire/dealer/audit/{osha,body-shop,finance}/                 DELETE
app/Traits/Has{Osha,BodyShop,Glba}ViolationStatements.php                       DELETE after port
# Legacy Q1..Qn Create.php classes (dead per decision #1):
#   verify with grep that no route or component references them, then DELETE
```

`AuditCommentForm` / `EditCommentModal` / `DeleteCommentConfirmationModal` under `app/Http/Livewire/Dealer/Audit/Components/` are also used by Deal Jackets and Individual Audits (out of scope). Port the comment box as a Vue component, **keep** the Livewire originals until Deal Jackets is converted in a follow-up.

---

## 4. Route changes

**Slugs preserved** (`osha`, `body-shop`, `finance`) — production URLs, bookmarks. Internally, controller resolves type from slug via route binding.

| Old route name & path | New route name & path | Notes |
|---|---|---|
| `dealer.audit.osha.index` GET `audits/osha` | same | → `ViolationAuditController@index` |
| `dealer.audit.osha.show` GET `audits/osha/{uuid}` | same | → `ViolationAuditController@show` |
| `dealer.audit.osha.edit` GET `audits/osha/{uuid}/edit` | same | → `ViolationAuditController@edit` |
| `dealer.audit.osha.create` GET `audits/osha/create/{store}` | same | → `ViolationAuditController@create` |
| `dealer.audit.osha.remediation` GET `audits/osha/{uuid}/remediation` | same | → `ViolationAuditController@remediation` |
| (Livewire `submit()`) | `dealer.audit.osha.update` PATCH `audits/osha/{uuid}` | NEW |
| (Livewire `editRemediations()`) | `dealer.audit.osha.remediation.update` PATCH `audits/osha/{uuid}/remediation` | NEW; broader-role group per decision #5 |
| (Livewire `delete()`) | `dealer.audit.osha.destroy` DELETE `audits/osha/{uuid}` | NEW |
| (Livewire `download()`) | `dealer.audit.osha.download` GET `audits/osha/{uuid}/download` | NEW (signed URL) |
| (Livewire `generatePdf()`) | `dealer.audit.osha.generate` POST `audits/osha/legacy/{oshaAudit}/generate` | NEW |
| (Livewire `violationSelected`) | `dealer.audit.osha.violations.store` POST `audits/osha/{uuid}/violations` | NEW |
| (Livewire `deleteViolation`) | `dealer.audit.osha.violations.destroy` DELETE `audits/osha/{uuid}/violations/{violation}` | NEW |

…repeated identically for `body-shop` and `finance`. Implementation:

```php
foreach (['osha', 'body-shop', 'finance'] as $slug) {
    Route::prefix("audits/{$slug}")->name("audit.{$slug}.")->group(...);
}
```

**Middleware split preserved**:
- `super-admin|Consultant` → `create`, `edit`, `update`, `violations.*`, `destroy`.
- `super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual` → `index`, `show`, `remediation`, `remediation.update` (decision #5), `download`, `generate`.
- `finance.create` keeps `can:create-audits` policy gate.

---

## 5. Migration sequence

Each phase is an independently-mergeable PR.

### Phase 1 — Shared abstractions, no behaviour change
- `App\Enums\ViolationAuditType`
- `App\Models\Dealer\Audit\Contracts\ViolationAudit` interface; three models `implements` it.
- `App\Domain\Tenant\Audits\Queries\ResolveAuditScopedStores`
- `App\Domain\Tenant\Audits\Queries\BuildAuditChartData` (Osha-canonical chart logic)
- `App\Domain\Tenant\Audits\Strategies\{Osha,BodyShop,Glba}ViolationStrategy`
- Unit tests for enum, chart builder, strategies.

**Run**: `php artisan test tests/Unit/Enums tests/Unit/Domain/Tenant/Audits`

### Phase 2 — OSHA pilot
Build new flow alongside old. Add:
- `ViolationAuditController` (only OSHA slug wired).
- New Vue pages under `resources/js/pages/tenant/audits/`.
- All Domain Actions / Data / Queries.
- New Form Requests.
- Wayfinder regen.
- New Pest feature tests (see test plan).

Old Livewire OSHA classes remain on disk but unreachable. BodyShop/Finance unchanged.

**Run**: `php artisan test tests/Feature/Tenant/Audits/Osha tests/Unit/Domain/Tenant/Audits`

### Phase 3 — BodyShop conversion
Flip BodyShop slug to new controller. Port BodyShop tests; add the missing Edit/Remediation/Modal coverage.

**Run**: `php artisan test tests/Feature/Tenant/Audits/BodyShop`

### Phase 4 — Finance/GLBA conversion + job rename
Same as Phase 3. Rename `GenerateAuditPdfJob` → `GenerateGlbaAuditPdfJob` and `UploadAuditToDigitalOceanJob` → `UploadGlbaAuditToDigitalOceanJob` (decision #3). Add missing Edit/Remediation/Modal tests Glba lacks.

**Run**: `php artisan test tests/Feature/Tenant/Audits/Glba tests/Unit/Jobs/Audit`

### Phase 5 — Delete old Livewire trio + cleanup
Remove:
- `app/Http/Livewire/Dealer/Audit/{Osha,BodyShop,Finance}/`
- The three `*CreateController`s
- The three Blade view directories
- `Has{X}ViolationStatements` traits (now in `Strategies/`)
- `Traits/UpdateRemediations.php`
- Legacy Q1..Qn `Create.php` classes (decision #1) — verify with `grep -r` first
- Old generic-named PDF jobs (replaced in Phase 4)

Final Wayfinder regen.

**Run**: `php artisan test tests/Feature/Tenant/Audits tests/Unit/Domain/Tenant/Audits tests/Unit/Jobs/Audit`

### Phase 6 (follow-up, out of scope)
Deal Jackets / Individual conversion — they share `Components/AuditCommentForm`. Phase 5 leaves `Components/` alone.

---

## 6. Risks (non-blocking — recorded for execution)

1. **`single.store` middleware** — every audit route is gated on it. New controllers must remain inside that middleware group via `Concerns\ResolvesAuditScope` (mirroring `ResolvesManualStore`). Risk if forgotten: `null` store leaks across tenants.
2. **`OldAuditIndex` / archived audits** — these read legacy `*Audit` rows for read-only display + download. Must remain functional during and after migration. Treat legacy models as read-only fixtures; their Vue page is just a list + signed-URL download.
3. **Comments side-feature** — `AuditComment` is morph-attached to violation audits. Vue Edit page must include a comment thread. Port to a Vue component without deleting the Livewire originals (Deal Jackets still uses them).
4. **Spatie MediaLibrary uploads** — violation files use `addMedia(...)->toMediaCollection('violation_files_'.$id, 'armpaudits')`. In Inertia, file uploads via `useForm().post()` with `forceFormData`. Add an integration test that uploads a fixture image and asserts media attachment. Same for remediation photos. Per decision #6, the form sends a single `images: File[]` array (max 3) instead of `image_1`, `image_2`, `image_3`; the Action iterates and calls `addMedia()` once per file. `UpdateViolationAuditRequest` / `UpdateRemediationsRequest` validate with `images` → `array|max:3`, `images.*` → `file|mimes:jpg,jpeg,png,webp,heic,heif|max:10240`. Per decision #8, the Vue file picker resizes and converts HEIC client-side before upload — consider this part of the upload component, not the page.
5. **`WireElements\Pro\Concerns\InteractsWithConfirmationModal`** — used by Edit/RemediationForm for "Are you sure?" prompts. Replace with a Vue confirm-modal component (check `resources/js/components/ui/` first).
6. **Filament Notifications** — `Filament\Notifications\Notification::make()->...->send()` is used everywhere. In Inertia, redirect with `->with('success', '...')` and read in a Vue toast layer (Manuals already established this pattern).
7. **`refreshAudits` Livewire event** — emitted from Delete to bump Index. Replace with `router.reload({ only: ['audits'] })` or rely on full-page Inertia redirect after destroy.
8. **DigitalOcean PDF paths** — `tenant('id').'/{slug}/{pdf_path}'`. Centralise via `ViolationAuditType::pdfPath()` so existing files keep resolving. Don't change disk layout.

---

## 7. Test plan

### Existing tests to migrate / extend

| Existing | Action |
|---|---|
| `tests/Feature/Tenant/Audits/Osha/EditOshaViolationAuditTest.php` | Convert from `Livewire::test` to `actingAs(...)->patch(...)` against `audit.osha.update`. Keep all assertions. |
| `tests/Feature/Tenant/Audits/Osha/RemediationFormTest.php` | Convert to PATCH against `audit.osha.remediation.update`. |
| `tests/Feature/Tenant/Audits/Osha/UploadOshaPdfJobTest.php` | Unchanged. |
| `tests/Feature/Tenant/Audits/BodyShop/BodyShopViolationModalTest.php` | Convert to controller test on `audit.body-shop.violations.store`. |
| `tests/Feature/Tenant/Audits/BodyShop/UploadBodyShopPdfJobTest.php` | Unchanged. |
| `tests/Feature/Tenant/Audits/Glba/UploadGlbaPdfJobTest.php` | Update job class name reference (Phase 4 rename). |
| `tests/Unit/Jobs/Audit/Generate{Osha,BodyShop,Glba}PdfJobTest.php` | Glba test updates job class name. |

### New Pest feature tests (mirror `tests/Feature/Tenant/Manuals/Osha/OshaControllerTest.php`)

For each of `osha`, `body-shop`, `finance`:

- `tests/Feature/Tenant/Audits/{Type}/IndexTest.php` — Inertia component name, audits prop scoped to current tenant's stores, chart data shape, role middleware (broader role passes, employee fails).
- `tests/Feature/Tenant/Audits/{Type}/ShowTest.php` — violations, rating math, Inertia props.
- `tests/Feature/Tenant/Audits/{Type}/CreateTest.php` — new audit row, redirect to edit, super-admin/Consultant role gate, `can:create-audits` for finance.
- `tests/Feature/Tenant/Audits/{Type}/UpdateTest.php` — Edit submit: date update, violation comment/severity/risk persistence, file upload via `Storage::fake('armpaudits')`, validation errors return Inertia errors.
- `tests/Feature/Tenant/Audits/{Type}/RemediationUpdateTest.php` — create/update/delete remediation, photo upload, photo removal.
- `tests/Feature/Tenant/Audits/{Type}/DestroyTest.php` — soft-delete, cascade to audit comments (Osha-canonical, decision #2), redirect with flash.
- `tests/Feature/Tenant/Audits/{Type}/DownloadTest.php` — signed URL redirect; missing PDF returns 404.
- `tests/Feature/Tenant/Audits/{Type}/GenerateTest.php` — `Bus::fake()`; assert chain dispatch.
- `tests/Feature/Tenant/Audits/{Type}/ViolationsTest.php` — add violation from statement; delete violation; delete violation photo.

### Shared unit tests

- `tests/Unit/Enums/ViolationAuditTypeTest.php`
- `tests/Unit/Domain/Tenant/Audits/Queries/BuildAuditChartDataTest.php`
- `tests/Unit/Domain/Tenant/Audits/Queries/ResolveAuditScopedStoresTest.php`
- `tests/Unit/Domain/Tenant/Audits/Strategies/{Osha,BodyShop,Glba}ViolationStrategyTest.php`

### Test-running guidance

Always scope `php artisan test`:
- Phase 1: `php artisan test tests/Unit/Enums tests/Unit/Domain/Tenant/Audits`
- Phase 2: `php artisan test tests/Feature/Tenant/Audits/Osha tests/Unit/Domain/Tenant/Audits`
- Phases 3/4: `php artisan test tests/Feature/Tenant/Audits/{BodyShop,Glba}`
- Phase 5: `php artisan test tests/Feature/Tenant/Audits tests/Unit/Domain/Tenant/Audits tests/Unit/Jobs/Audit`

Never run the full suite from this branch.

---

## Critical files for implementation

- `/Users/armp/Herd/dashboard/routes/tenant.php`
- `/Users/armp/Herd/dashboard/app/Http/Controllers/Tenant/Manuals/OshaController.php` *(reference pattern to mirror)*
- `/Users/armp/Herd/dashboard/app/Http/Livewire/Dealer/Audit/Osha/Edit.php` *(richest behaviour; canonical source)*
- `/Users/armp/Herd/dashboard/app/Http/Livewire/Dealer/Audit/Traits/UpdateRemediations.php` *(promote to Domain Action)*
- `/Users/armp/Herd/dashboard/app/Models/Dealer/Audit/OshaViolationAudit.php` *(model shape)*

---

## 8. Execution checklist — push between phases

Each phase ends with: tests green → commit → push → merge → only then start the next phase. No phase-stacking.

### Phase 1 — Shared abstractions (no behaviour change)
- Add `ViolationAuditType` enum, `ViolationAudit` interface (three models implement).
- Add `ResolveAuditScopedStores`, `BuildAuditChartData`, three `*ViolationStrategy` classes.
- Add unit tests.
- **Run**: `php artisan test tests/Unit/Enums tests/Unit/Domain/Tenant/Audits`
- **Push & merge before Phase 2.**

### Phase 2 — OSHA pilot (Inertia + Vue)
- Add `ViolationAuditController` (OSHA slug only).
- Add Domain Actions/Data/Queries, Form Requests, `ImageUploadField.vue` (HEIC + resize), shadcn-vue `AuditChart.vue`.
- Add Vue pages `tenant/audits/{Index,Show,Edit,Remediation}.vue`.
- Convert OSHA tests; add new feature tests for the OSHA controller surface.
- Run Wayfinder regen.
- **Run**: `php artisan test tests/Feature/Tenant/Audits/Osha tests/Unit/Domain/Tenant/Audits`
- **Push & merge before Phase 3.**

### Phase 3 — BodyShop conversion
- Wire BodyShop slug to `ViolationAuditController`.
- Convert BodyShop tests; add missing Edit/Remediation/Modal coverage.
- **Run**: `php artisan test tests/Feature/Tenant/Audits/BodyShop`
- **Push & merge before Phase 4.**

### Phase 4 — Finance/GLBA conversion + job rename
- Wire Finance slug to `ViolationAuditController`.
- Rename `GenerateAuditPdfJob` → `GenerateGlbaAuditPdfJob`, `UploadAuditToDigitalOceanJob` → `UploadGlbaAuditToDigitalOceanJob` (decision #3); update enum + tests.
- Add missing Glba Edit/Remediation/Modal tests.
- **Run**: `php artisan test tests/Feature/Tenant/Audits/Glba tests/Unit/Jobs/Audit`
- **Push & merge before Phase 5.**

### Phase 5 — Delete old Livewire trio + cleanup
- Delete `app/Http/Livewire/Dealer/Audit/{Osha,BodyShop,Finance}/`, `*CreateController`s, Blade view dirs, `Has{X}ViolationStatements` traits, `Traits/UpdateRemediations.php`, dead Q1..Qn `Create.php` classes (verify with `grep -r` first), old generic-named PDF jobs.
- Final Wayfinder regen.
- **Run**: `php artisan test tests/Feature/Tenant/Audits tests/Unit/Domain/Tenant/Audits tests/Unit/Jobs/Audit`
- **Push & merge — refactor done.**

### Phase 6 — Follow-up (separate work)
- Deal Jackets / Individual conversion (shares `Components/AuditCommentForm`).
- Optional: queued MediaLibrary conversions if not done in Phase 2.
- Not part of this plan; track separately.
