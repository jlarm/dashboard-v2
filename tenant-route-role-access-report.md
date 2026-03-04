# Tenant Route Role Access Report

Source: [`routes/tenant.php`](/Users/armp/Herd/dashboard/routes/tenant.php)

## Scope

- This report reflects **route-level access rules** defined in `routes/tenant.php`.
- All web routes are inside tenant middleware: `web`, tenancy initialization, `PreventAccessFromCentralDomains`, and `tenant.not-suspended`.
- Some routes also have **additional controller/component authorization** beyond route middleware. Example: `dealer.employees.show` has store-level visibility checks for non-`super-admin`/`Consultant`.

## Role Sets Used in Tenant Routes

- `super-admin`
- `Consultant`
- `Owner`
- `CFO`
- `GM`
- `GSM`
- `Qualified Individual`
- `Manager`

## Access Matrix (High-Level)

- `super-admin`: full role-gated access in tenant routes, including `global-settings`, audit create/edit flows, phishing create, ridgeback, and all manager/QA routes.
- `Consultant`: all consultant, manager, and QA role-gated routes (not `global-settings`).
- `Owner|CFO|GM|GSM|Qualified Individual`: QA and manager groups (manuals, settings/edit, phishing index/show, employees index/show/open-invites/create, scans, audits index/show/remediation, vendors, docs, fit-tests), but not consultant-only create/edit flows.
- `Manager`: manager group only (employees index/show/open-invites/create, scans, audits index/show/remediation, vendors, docs, fit-tests).
- Non-listed roles (e.g. `Employee`): only routes not gated by `role:*` middleware (auth/public/signed routes), subject to controller/policy checks.

## Complete Route Inventory by Effective Access

### 1) Public Tenant Routes (no `auth`, no `role`) ✅

- `GET /` (unnamed) ✅
- `GET /login` - `dealer.login` ✅
- `POST /login` (unnamed) ✅
- `GET /forgot-password` - `dealer.password.request` ✅
- `POST /forgot-password` - `dealer.password.email` ✅
- `GET /reset-password/{token}` - `dealer.password.reset` ✅
- `POST /reset-password` - `dealer.password.store` ✅
- `GET /invite_registration/{invite:invitation_token}` - `dealer.employees.create` (`missing(...)` handler) ✅
- `POST /employees/dealer/store` - `dealer.employees.store` ✅
- `GET /vendors/thankyou` - `dealer.vendors.thankyou` ✅
- `GET /videos/{videoId}` - `dealer.videos.show` ✅
- `POST /email/verification-notification` - `dealer.verification.send` (`throttle:6,1`) ✅
- `GET /verify-email/{id}/{hash}` - `dealer.verification.verify` (`signed`, `throttle:6,1`) ✅
- `GET /impersonate/{token}` - `dealer.impersonate.token` ✅

### 2) Public but Signed URL Required

- `GET /vendors/form` - `dealer.vendor.create` (`signed`) ✅
- `GET /form` - `dealer.vendor.form` (`signed`)
- `GET /email/settings` - `dealer.dealer.settings.form` (`signed`)  
  Note: declared twice in `tenant.php` with the same path/name.

### 3) Authenticated (any authenticated tenant user unless stricter checks in controller/component) ✅

- `GET /language/{locale}` (unnamed) (`auth`) ✅
- `GET /dashboard` - `dealer.dashboard` (`auth`)✅
- `GET /sds-sheets` - `dealer.sds.index` (`auth`)✅
- `GET /sds-sheets/{uuid}/view` - `dealer.sds.view` (`auth`)✅
- `GET /courses/` - `dealer.courses.index` (`auth`)✅
- `GET /courses/{course:slug}` - `dealer.courses.show` (`auth`)✅
- `POST /courses/{course:slug}` - `dealer.courses.results.store` (`auth`)✅
- `GET /courses/{course:slug}/edit` - `dealer.courses.edit` (`auth`)❌ (Should not exist)
- `GET /courses/{course:slug}/quiz` - `dealer.courses.quiz` (`auth`)✅
- `GET /videos` - `dealer.videos.index` (`auth`)❌ (Deleted)
- `GET /profile` - `dealer.profile.edit` (`auth`)✅
- `PATCH /profile` - `dealer.profile.update` (`auth`)✅
- `DELETE /profile` - `dealer.profile.destroy` (`auth`)✅
- `GET /verify-email` - `dealer.verification.notice` (`auth`)✅
- `GET /confirm-password` - `dealer.password.confirm` (`auth`)✅
- `POST /confirm-password` (unnamed) (`auth`)✅
- `PUT /password` - `dealer.password.update` (`auth`)✅
- `POST /logout` - `dealer.logout` (`auth`)✅
- `GET /employee/{user}/impersonate` - `dealer.employee.impersonate` (`auth`)✅
- `GET /stop-impersonation` - `dealer.stop.impersonation` (`auth`)✅

### 4) `role:super-admin` only ✅

- `GET /global-settings` - `dealer.settings.global`✅

### 5) `role:super-admin|Consultant` ️⚠️

- `GET /employees/create` - `dealer.employees.new`⚠️
- `GET /phishing/create` - `dealer.phishing.create`✅
- `GET /ridgeback` - `dealer.ridgeback.index` (`auth`, `single.store`)✅

#### 5a) Consultant Group: Audit Create/Edit Flows (`auth`, `single.store`)✅

- `GET /audits/osha/create/{store}` - `dealer.audit.osha.create`✅
- `GET /audits/osha/{oshaViolationAudit:uuid}/edit` - `dealer.audit.osha.edit`✅
- `GET /audits/body-shop/create/{store}` - `dealer.audit.body-shop.create`✅
- `GET /audits/body-shop/{bodyShopViolationAudit:uuid}/edit` - `dealer.audit.body-shop.edit`✅
- `GET /audits/finance/create/{store}` - `dealer.audit.finance.create` (`can:create-audits`)✅
- `GET /audits/finance/{glbaViolationAudit:uuid}/edit` - `dealer.audit.finance.edit`✅
- `GET /audits/deal-jackets-archived/create/{individualAudit:id?}` - `dealer.audit.individual.create`✅
- `GET /audits/deal-jackets-archived/{individualAudit:uuid}` - `dealer.audit.individual.show`✅
- `GET /audits/deal-jackets-archived/{individualAudit:uuid}/edit` - `dealer.audit.individual.edit`✅
- `GET /audits/deal-jackets/{dealJacketGroup:uuid}/create` - `dealer.audit.deal-jackets.create`✅
- `GET /audits/deal-jackets/{dealJacketGroup:uuid}/edit/{dealJacket:uuid}` - `dealer.audit.deal-jackets.edit`✅

### 6) `auth` + `can:delete-stores` permission

- `GET /logs` - `dealer.logs.index`✅
- `GET /logs/{activity:id}` - `dealer.logs.show`✅

Note: this exact group is duplicated in `tenant.php`. (Removed the duplicate routes)✅

### 7) `role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual` (QA group)✅

- `GET /employees/deleted` - `dealer.employee.deleted`✅
- `GET /settings` - `dealer.dealer.settings` (`auth`)✅
- `GET /edit` - `dealer.store.edit` (`auth`)✅
- `GET /phishing` - `dealer.phishing.index`✅
- `GET /phishing/{phishingCampaign}` - `dealer.phishing.show`✅

#### 7a) QA Manuals (`auth`, `single.store`)✅

- `GET /manuals/isp` - `dealer.manual.isp.index`✅
- `GET /manuals/isp/create` - `dealer.manual.isp.create`✅
- `GET /manuals/osha` - `dealer.manual.osha.index`✅
- `GET /manuals/osha/create` - `dealer.manual.osha.create`✅
- `GET /manuals/red-flag` - `dealer.manual.red-flag.index`✅
- `GET /manuals/red-flag/create` - `dealer.manual.red-flag.create`✅
- `GET /manuals/cms` - `dealer.manual.cms.index`✅
- `GET /manuals/cms/create` - `dealer.manual.cms.create`✅

### 8) `role:super-admin|Consultant|Owner|CFO|GM|GSM|Qualified Individual|Manager` (Manager group)

#### 8a) Employees ⚠️

- `GET /employees/` - `dealer.employees.index`✅
- `GET /employees/create` - `dealer.employees.new` (also declared in consultant group)⚠️ 
- `GET /employees/open-invites` - `dealer.employees.open-invites`✅
- `GET /employees/{user:slug}` - `dealer.employees.show`  ✅
  Additional runtime rule: non-`super-admin`/`Consultant` can only view employees in their own stores.

#### 8b) Scans (`single.store` required) ✅

- `GET /scans` - `dealer.scan.index` (`single.store`)✅
- `GET /scans/settings` - `dealer.scan.settings` (`single.store`)✅
- `GET /scans/report/{type}` - `dealer.scan.report` (`single.store`)✅
- `GET /scans-archive` - `dealer.scan.archive` (`auth`, `single.store`)✅

#### 8c) Audits (`auth`, `single.store`) ✅

- `GET /audits/osha` - `dealer.audit.osha.index`✅
- `GET /audits/osha/{oshaViolationAudit:uuid}/remediation` - `dealer.audit.osha.remediation`✅
- `GET /audits/osha/{oshaViolationAudit:uuid}` - `dealer.audit.osha.show`✅
- `GET /audits/body-shop` - `dealer.audit.body-shop.index`✅
- `GET /audits/body-shop/{bodyShopViolationAudit:uuid}/remediation` - `dealer.audit.body-shop.remediation`✅
- `GET /audits/body-shop/{bodyShopViolationAudit:uuid}` - `dealer.audit.body-shop.show`✅
- `GET /audits/finance` - `dealer.audit.finance.index`✅
- `GET /audits/finance/{glbaViolationAudit:uuid}/remediation` - `dealer.audit.finance.remediation`✅
- `GET /audits/finance/{glbaViolationAudit:uuid}` - `dealer.audit.finance.show`✅
- `GET /audits/deal-jackets-archived` - `dealer.audit.individual.index`✅
- `GET /audits/deal-jackets` - `dealer.audit.deal-jackets.index`✅
- `GET /audits/deal-jackets/{dealJacketGroup:uuid}` - `dealer.audit.deal-jackets.show`✅
- `GET /audits/deal-jackets/{dealJacketGroup:uuid}/{dealJacket:uuid}` - `dealer.audit.deal-jackets.single`✅
- `GET /audits/deal-jacket-reports/{fileName}/download` - `dealer.audit.deal-jacket-reports.download`✅

#### 8d) Vendors / Documents / Fit Tests

- `GET /vendors` - `dealer.vendor.index` (`auth`)✅
- `GET /documents/` - `dealer.doc.index` (`auth`)✅
- `GET /fit-tests` - `dealer.fit-tests.index`✅

### 9) Local Environment Only (no role middleware)

These only exist when `config('app.env') === 'local'`:

- `GET /osha-audit-pdf` (unnamed)
- `GET /deal-jacket-audit-pdf` (unnamed)
- `GET /deal-jacket-report-pdf` (unnamed)
- `GET /glba-audit-pdf` (unnamed)
- `GET /body-shop-audit-pdf` (unnamed)
- `GET /dot-cert` (unnamed)

### 10) API Route Group (non-web)

Middleware: `api`, tenancy initialization, prevent access from central domains.

- `POST /webhooks/gophish/` - `webhooks.gophish`  
  No role middleware is applied in `tenant.php`.

## Notable Observations

- `logs` routes are declared twice with identical definitions. ✅
- `email/settings` (`dealer.dealer.settings.form`) is declared twice with identical definitions.
- Several sensitive paths are protected by `signed` instead of `auth` (intentional for invite/webhook/external callbacks, but role access is not applicable there).
