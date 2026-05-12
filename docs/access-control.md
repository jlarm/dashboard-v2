# Role-Based Access Reference

Reference for which roles can access each page, action, and UI element. Use this when adding or modifying features to verify the correct gates are in place.

## Roles

In ascending privilege:

- `Employee`
- `Porter/Driver`
- `Manager`
- `Qualified Individual` (QI)
- `GSM`
- `GM`
- `CFO`
- `Owner`
- `Consultant`
- `super-admin` — bypasses every gate via `Gate::before` (see `AppServiceProvider`)

## Permission map

From `database/seeders/RoleAndPermissionSeeder.php`:

| Permission | Roles |
| --- | --- |
| `create-dealerships` | super-admin, Consultant |
| `create-stores` | super-admin, Consultant, Owner, CFO, GM, GSM, Qualified Individual |
| `delete-stores` | super-admin only |

> "Manager-only" below means the viewer has the Manager role but none of the higher-privilege roles.

---

## Employees Section

### Index — `/employees` (`Index.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager |
| Search / filter (Departments, Roles, compliance pills) | All viewers above |
| Manage filters (Departments + Roles dropdowns) | super-admin, Consultant *(via `create-stores`)* — actually any role with `create-stores`: super-admin, Consultant, Owner, CFO, GM, GSM, QI |
| Export CSV (selected or all) | All viewers above |
| Send Message | super-admin, Consultant, Owner, CFO, GM, GSM, QI *(Manager excluded)* |
| Email report (UI hidden, endpoint still gated) | super-admin, Consultant *(`create-dealerships`)* |
| Per-row click-through to employee | scoped — must pass `GetEmployees::isVisibleTo` (Manager limited to own department; viewers can't see themselves or Consultants) |

### Sub-navigation (`SubNavigation.vue`)

| Link | Roles |
| --- | --- |
| Employees | All viewers of the section |
| Import | super-admin only |
| Invite Employee | All viewers of the section |
| Open Invites | All viewers of the section |
| Deleted | super-admin, Consultant, Owner, CFO, GM, GSM, QI *(Manager hidden)* |

### Import (dialog from sub-nav)

| Action | Roles |
| --- | --- |
| Open dialog (button visible) | super-admin only |
| `POST /employees/import` (`ImportEmployeesRequest`) | super-admin only |

### Invite Employee — `/employees/invite` (`Invite.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager |
| Department select | All viewers — Manager-only sees a single, locked option (their own department) |
| Role select | All viewers — Manager-only sees only `Manager`, `Employee`, `Porter/Driver` |
| Store select / primary store | Scoped to viewer's accessible stores; Manager-only auto-defaults to their `current_store_id` |
| Qualified Individual checkbox | super-admin, Consultant, Owner, CFO, GM, GSM, QI *(Manager hidden + ignored server-side)* |
| Add previously completed courses | super-admin, Consultant *(others hidden + ignored server-side)* |
| `POST /employees/invite` (`InviteEmployeeRequest`) | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager — validation rules also enforce the scoped department/role/store lists |

### Open Invites — `/employees/open-invites` (`OpenInvites.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager — Manager scoped to their department via `GetOpenInvites::applyDepartmentScope` |
| Resend single (`open-invites.resend-one`) | Same as view — controller re-checks the invite is in the viewer's scoped query |
| Bulk resend (`open-invites.resend`) | Same as view — only invites passing the scoped query are resent |
| Delete invite (`open-invites.destroy`) | Same as view — controller re-checks scope |

### Deleted Employees — `/employees/deleted` (`Deleted.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI *(Manager 403)* |
| Restore employee (`employees.deleted.restore`) | Same as view |

### Show Employee — `/employees/{slug}` (`Show.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager — must pass `GetEmployees::isVisibleTo` (no self-view, no Consultants visible) |
| Edit (PATCH) | super-admin, Consultant, Owner, CFO, GM, GSM, QI *(viewer needs `create-stores`; target can't be self, super-admin, or Consultant)* |
| Delete | Same as Edit |
| Impersonate | super-admin, Consultant *(target can't be self or super-admin)* |

### Courses tab — `/employees/{slug}/courses` (`Courses.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager (visible to scope) |
| Record course result (`courses.record-result`) | Same as view (`RecordCourseResultRequest` policy check) |

### Manage Courses — `/employees/{slug}/manage-courses` (`ManageCourses.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Qualified Individual *(tightened at the route)* |
| Override course (`course-overrides.update`) | Same — super-admin, Consultant, QI |

### DOT Certificates — `/employees/{slug}/dot-certificates` (`DotCertificates.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant, Owner, CFO, GM, GSM, QI, Manager (visible to scope) |
| Generate certificate (`dot-certificates.generate`) | super-admin, Consultant *(`create-dealerships` via `UserPolicy::generateDotCertificate`)* |

### Invite Registration — `/invite_registration/{token}` (`Register.vue`)

| Element | Roles |
| --- | --- |
| View / submit registration | Public — anyone with a valid invitation token (no auth required) |

---

## Courses Section

The dealer-facing course pages (an employee's own training, not the admin-side view at `/employees/{slug}/courses`).

### Index — `/courses` (`Index.vue`)

| Element | Roles |
| --- | --- |
| View page | Any authenticated user |
| Course list contents | Scoped per viewer by `UserCourseService::getCourseIds` — role assignments (`course_role`) filtered by department, store state, `optional`, and `course_user` add/exclude overrides. Admin-only users (super-admin, Admin, Consultant, QI) see only manual overrides — nothing role-based. |
| Card click-through to `courses.show` | Visible when the course has questions and (for DOT modules 2–4) the preceding module is passed |
| "Generate DOT Certificate" button | Gated by `CanIssueDotCertificate` — viewer has a passing `CourseResults` row for the DOT shipping slug within `years_expires` and no existing `Certificate` |

### All Courses — `/courses/all` (`All.vue`)

| Element | Roles |
| --- | --- |
| View page | super-admin, Consultant *(route middleware `role:super-admin|Consultant`)* |
| Card click-through | Same gating as Index (must have questions) |

### Show — `/courses/{course:slug}` (`Show.vue`)

| Element | Roles |
| --- | --- |
| View page | Any authenticated user — `ResolveReplacementCourse` redirects to a state- or assignment-specific replacement when one applies to the viewer |
| Video / slides playback | Same as view |
| "Take Quiz" button | Visible only after `VideoProgress` exists for the course's video within `years_expires` (skipped entirely when the course has no video) |
| Mark video complete (`courses.video-complete`) | Any authenticated user — no-op when the course has no `video_id` |

### Quiz — `/courses/{course:slug}/quiz` (`Quiz.vue`)

| Element | Roles |
| --- | --- |
| View page | Any authenticated user — `ResolveReplacementCourse` runs the same replacement redirect as Show |
| Submit quiz (`courses.results.store`) | Any authenticated user — `SubmitQuizRequest` requires every question to be answered. Score ≥ 70% → `passed=true`; for the DOT shipping slug a passing result also queues `IssueDotCertificate` (gated by `CanIssueDotCertificate`). |

### DOT Certificate Generation — `POST /courses/dot-certificate`

| Element | Roles |
| --- | --- |
| Trigger (`courses.dot-certificate.issue`) | Any authenticated user — `DispatchDotCertificate` consults `CanIssueDotCertificate` and returns false with an error flash for ineligible viewers, so the queued job only runs for users who actually passed the DOT shipping course. |

---

## Where these gates live

- **Route group middleware** — `routes/tenant.php` (`role:...` middleware on each `Route::group`)
- **Form Request `authorize()`** — `app/Http/Requests/Tenant/User/*.php`
- **Controller `abort_unless` / `$this->authorize(...)`** — `app/Http/Controllers/Tenant/UserController.php`
- **Policies** — `app/Policies/Central/UserPolicy.php` (`update`, `delete`, `impersonate`, `generateDotCertificate`, etc.)
- **Inertia shared props** — `app/Http/Middleware/HandleInertiaRequests.php` exposes `auth.roles` so Vue components can hide UI based on role
- **UI props** — pages pass a `permissions` block (e.g. `Index.vue` and `Invite.vue`) so individual buttons/sections can be conditionally rendered
- **Scoped queries** — `app/Domain/Tenant/User/Queries/*.php` (`GetEmployees`, `GetOpenInvites`, etc.) automatically restrict results by department / store / current store when the viewer lacks `create-stores`

When a route allows multiple roles but only some can perform a given action, the gate is layered: route middleware is the floor, Form Request / policy is the ceiling, and scoped queries enforce per-record visibility.
