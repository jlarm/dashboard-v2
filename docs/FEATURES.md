# Feature Coverage Checklist

Snapshot of every shipped feature and the test(s) that cover it. Use this to find gaps before a release.

**Legend**
- ✅ — dedicated test file or substantial coverage exists
- ⚠️ — touched indirectly (e.g. role-access test, smoke test) but no dedicated functionality test
- ❌ — no test found

Run tests scoped, never the full suite. Example:
```bash
php artisan test --compact tests/Feature/Tenant/Audits/Osha/CreateTest.php
```

Source inventory (as of this snapshot): 73 controllers, 83 domain modules, 18 policies, 38 console commands, 43 jobs, 23 notifications, 12 mailables, ~290 routes, 178 test files.

---

## 1. Authentication & Onboarding

### Central (super-admin / Consultant)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Login (form + submit) | `Http/Controllers/Auth/AuthenticatedSessionController` | `tests/Feature/Auth/AuthenticationTest.php` | ✅ |
| Logout | same | `tests/Feature/Auth/AuthenticationTest.php` | ✅ |
| Password reset request / email | `Auth/PasswordResetLinkController` | `tests/Feature/Auth/PasswordResetTest.php` | ✅ |
| Password reset confirm | `Auth/NewPasswordController` | `tests/Feature/Auth/PasswordResetTest.php` | ✅ |
| Password update (settings) | `Auth/PasswordController` | `tests/Feature/Auth/PasswordUpdateTest.php` | ✅ |
| Password confirmation gate | `Auth/ConfirmablePasswordController` | `tests/Feature/Auth/PasswordConfirmationTest.php` | ✅ |
| Email verification prompt + send | `Auth/EmailVerification*Controller`, `VerifyEmailController` | `tests/Feature/Auth/EmailVerificationTest.php` | ✅ |
| Registration | `RegistrationTest` | `tests/Feature/Auth/RegistrationTest.php` | ✅ |
| Profile edit/update/delete | `Settings/ProfileController` | `tests/Feature/ProfileTest.php` | ✅ |
| Cross-tenant password reset job | `Jobs/CrossTenantPasswordResetJob` | `tests/Feature/Auth/CrossTenantPasswordResetTest.php` | ✅ |
| Invite registration (token signup) | `Central/UserInviteRegistrationController` | `tests/Feature/Central/Invite/UserInviteRegistrationTest.php` | ✅ |

### Tenant (dealer-facing)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Login | `Tenant/Auth/AuthenticatedSessionController` | `tests/Feature/Tenant/Auth/AuthenticationTest.php` | ✅ |
| Password reset request | `Tenant/Auth/PasswordResetLinkController` | `tests/Feature/Tenant/Auth/PasswordResetTest.php` | ✅ |
| Password reset confirm | `Tenant/Auth/NewPasswordController` | `tests/Feature/Tenant/Auth/PasswordResetTest.php` | ✅ |
| Password update | `Tenant/Settings/PasswordController` | `tests/Feature/Tenant/Auth/PasswordUpdateTest.php` | ✅ |
| Password confirmation | `Dealer/Auth/ConfirmablePasswordController` | `tests/Feature/Tenant/Auth/PasswordConfirmationTest.php` | ✅ |
| Email verification | `Dealer/Auth/EmailVerification*Controller`, `VerifyEmailController` | `tests/Feature/Tenant/Auth/EmailVerificationTest.php` | ✅ |
| Cross-tenant password reset (job-side) | `Jobs/CrossTenantPasswordResetJob` | `tests/Feature/Tenant/Auth/CrossTenantPasswordResetJobTest.php` | ✅ |
| Profile edit/update | `Tenant/Settings/ProfileController` | `tests/Feature/Tenant/Settings/ProfileControllerTest.php` | ✅ |
| Invited employee registration | `Dealer/UserController@create/store` | `tests/Feature/Tenant/Employee/RegisterInvitedEmployeeTest.php`, `InviteRegistrationStoreAssignmentTest.php` | ✅ |
| Impersonation entry (Stancl) | `Dealer/ImpersonationController`, `UserImpersonation::makeResponse` | `tests/Feature/Tenant/Authorization/ImpersonationAccessTest.php` | ✅ |

---

## 2. Central App

### Dealerships
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| List dealerships (index) | `Central/DealershipController@index` | `tests/Feature/Central/Dealership/IndexTest.php` | ✅ |
| Create dealership (controller) | `Central/DealershipController@store` | `tests/Feature/Central/Dealership/CreateControllerTest.php` | ✅ |
| Create dealership (domain action) | `Domain/Central/Dealership/Actions/CreateDealership` | `tests/Feature/Central/Dealership/CreateDealershipActionTest.php` | ✅ |
| Authorization | `Policies/Central/DealershipPolicy` | `tests/Feature/Central/Authorization/CentralRouteAccessTest.php` | ✅ |

### Courses (taken by central users)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/CourseController@index` | `tests/Feature/Central/Course/IndexTest.php` | ✅ |
| Show / video player | `Central/CourseController@show` | `tests/Feature/Central/Course/ShowTest.php` | ✅ |
| Video progress tracking | `Central/VideoProgressController@store` | `tests/Feature/Central/Course/VideoProgressTest.php` | ✅ |
| Take quiz / submit | `Central/CourseController@quiz`, `CourseResultController@store` | `tests/Feature/Central/Course/QuizTest.php` | ✅ |

### Course Management (central admin: edit catalog)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index + import courses | `Central/CourseManagementController` | `tests/Feature/Central/CourseManagement/IndexImportTest.php` | ✅ |
| Edit quiz questions | same | `tests/Feature/Central/CourseManagement/EditQuizTest.php` | ✅ |
| Update slides | same | `tests/Feature/Central/CourseManagement/UpdateSlidesTest.php` | ✅ |
| Settings (roles, departments, replacements) | same | `tests/Feature/Central/CourseManagement/SettingsTest.php` | ✅ |

### Documents (central library)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/DocumentController@index` | `tests/Feature/Central/Document/IndexTest.php` | ✅ |
| Upload | `@store` | `tests/Feature/Central/Document/StoreTest.php` | ✅ |
| Download | `@download` | `tests/Feature/Central/Document/DownloadTest.php` | ✅ |
| Delete | `@destroy` | `tests/Feature/Central/Document/DestroyTest.php` | ✅ |

### Shared Documents (cross-tenant)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/SharedDocumentController@index` | `tests/Feature/Central/SharedDocument/IndexTest.php` | ✅ |
| Upload | `@store` | `tests/Feature/Central/SharedDocument/StoreTest.php` | ✅ |
| Download | `@download` | `tests/Feature/Central/SharedDocument/DownloadTest.php` | ✅ |
| Delete | `@destroy` | `tests/Feature/Central/SharedDocument/DestroyTest.php` | ✅ |
| Tenant-side viewing | `Tenant/DealerDocController` | `tests/Feature/Tenant/Document/DealerDocControllerTest.php` | ✅ |

### SDS (central library)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/SdsController@index` | `tests/Feature/Central/Sds/IndexTest.php` | ✅ |
| Upload | `@store` | `tests/Feature/Central/Sds/StoreTest.php` | ✅ |
| Update | `@update` | `tests/Feature/Central/Sds/UpdateTest.php` | ✅ |
| Download | `@download` | `tests/Feature/Central/Sds/DownloadTest.php` | ✅ |
| Delete | `@destroy` | `tests/Feature/Central/Sds/DestroyTest.php` | ✅ |
| Bulk import command | `Console/Commands/ImportSdsCommand` | `tests/Feature/ImportSdsCommandTest.php` | ✅ |
| Missing-file audit command | `Console/Commands/CheckMissingSdsFiles` | `tests/Feature/CheckMissingSdsFilesTest.php` | ✅ |

### Users (central staff)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| List / manage central users | `Central/UserController` | `tests/Feature/Central/User/UserControllerTest.php` | ✅ |

### Invites (cross-tenant employee/user invites)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Send invite (controller) | `Central/InviteController` | `tests/Feature/Central/Invite/InviteControllerTest.php` | ✅ |
| Create invite (action) | `Domain/Central/User/Actions/CreateInvite` | `tests/Feature/Central/Invite/CreateInviteActionTest.php` | ✅ |
| UserInvite model | `Models/CentralUserInvite` | `tests/Feature/Central/Invite/UserInviteModelTest.php` | ✅ |
| Registration via invite token | `Central/UserInviteRegistrationController` | `tests/Feature/Central/Invite/UserInviteRegistrationTest.php` | ✅ |
| Reminder mailers (10/20 day) | `Mail/TenDay…`, `Mail/TwentyDay…`, `Console/Commands/RunInvitesCommand` | `tests/Feature/Tenant/Console/RunInvitesCommandTest.php` | ✅ |
| Notification dispatch | `Notifications/Central/UserInviteNotification` | `tests/Feature/Central/Invite/UserInviteNotificationTest.php` | ✅ |

### Violation Statements (audit content library)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index / search | `Central/ViolationStatementController@index` | `tests/Feature/Central/ViolationStatement/IndexTest.php` | ✅ |
| Create | `@store` | `tests/Feature/Central/ViolationStatement/StoreTest.php` | ✅ |
| Update | `@update` | `tests/Feature/Central/ViolationStatement/UpdateTest.php` | ✅ |
| Delete | `@destroy` | `tests/Feature/Central/ViolationStatement/DestroyTest.php` | ✅ |
| Bulk migrate command | `Console/Commands/MigrateViolationStatementsCommand` | `tests/Feature/Central/ViolationStatement/MigrateViolationStatementsCommandTest.php` | ✅ |
| Repair keywords command | `Console/Commands/RepairViolationStatementKeywordsCommand` | `tests/Feature/Central/ViolationStatement/RepairViolationStatementKeywordsCommandTest.php` | ✅ |

### Contracts (vendor/contractor agreements)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/ContractController@index` | `tests/Feature/Central/Contract/IndexTest.php` | ✅ |
| Create / store | `@create`, `@store` | `tests/Feature/Central/Contract/StoreTest.php` | ✅ |
| Edit | `@edit` | `tests/Feature/Central/Contract/EditTest.php` | ✅ |
| Update | `@update` | `tests/Feature/Central/Contract/UpdateTest.php` | ✅ |
| Delete | `@destroy` | `tests/Feature/Central/Contract/DestroyTest.php` | ✅ |
| Send for review | `ContractSendController` | `tests/Feature/Central/Contract/SendTest.php` | ✅ |
| Public review + sign | `ContractReviewController` | `tests/Feature/Central/Contract/ReviewTest.php` | ✅ |
| Generate PDF | `ContractPdfController`, `Jobs/Contracts/GeneratePdfJob` | `tests/Feature/Central/Contract/PdfTest.php` | ✅ |
| Upload PDF to Digital Ocean | `Jobs/Contracts/UploadToDigitalOceanJob` | `tests/Feature/Central/Contract/UploadToDigitalOceanJobTest.php` | ✅ |
| Notifications (sent / signed / pdf ready) | `Notifications/Contract*Notification` | `tests/Feature/Central/Contract/ContractNotificationsTest.php` | ✅ |

### Central Dashboard
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index | `Central/DashboardController@index` | `tests/Feature/Central/Dashboard/DashboardControllerTest.php` | ✅ |

### Impersonation (super-admin → tenant user)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Generate impersonation token | `Dealer/ImpersonationController` | `tests/Feature/Tenant/Authorization/ImpersonationAccessTest.php` | ✅ |
| Stop impersonation | tenant route + Stancl | same | ✅ |

---

## 3. Tenant App

### Dashboard / Compliance
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Dashboard view | `Tenant/DashboardController@show` | `tests/Feature/Tenant/DashboardTest.php`, `tests/Feature/Tenant/Compliance/DashboardControllerTest.php` | ✅ |
| Audit report PDF download | `@downloadAuditReport` | `tests/Feature/Tenant/Dashboard/DownloadAuditReportTest.php` | ✅ |
| Audit type report download | `@downloadAuditTypeReport` | `tests/Feature/Tenant/Dashboard/DownloadAuditTypeReportTest.php` | ✅ |
| Update consultant note | `@updateConsultantNote` | `tests/Feature/Tenant/Dashboard/UpdateConsultantNoteTest.php` | ✅ |
| Compliance score (overall) | `Domain/Tenant/Compliance/Queries/CalculateComplianceScore` | `tests/Feature/Tenant/Compliance/CalculateComplianceScoreTest.php` | ✅ |
| Audit pillar | `CalculateAuditPillar` | `tests/Feature/Tenant/Compliance/CalculateAuditPillarTest.php` | ✅ |
| Cyber pillar | `CalculateCyberPillar` | `tests/Feature/Tenant/Compliance/CalculateCyberPillarTest.php` | ✅ |
| Docs pillar | `CalculateDocsPillar` | `tests/Feature/Tenant/Compliance/CalculateDocsPillarTest.php` | ✅ |
| Training pillar | `CalculateTrainingPillar` | `tests/Feature/Tenant/Compliance/CalculateTrainingPillarTest.php` | ✅ |
| Vendor pillar | `CalculateVendorPillar` | `tests/Feature/Tenant/Compliance/CalculateVendorPillarTest.php` | ✅ |
| Expired training count | `CalculateExpiredTraining` | `tests/Feature/Tenant/Compliance/CalculateExpiredTrainingTest.php` | ✅ |
| Overdue remediations | `CalculateOverdueRemediations` | `tests/Feature/Tenant/Compliance/CalculateOverdueRemediationsTest.php` | ✅ |
| Violations overview | `CalculateViolationsOverview` | `tests/Feature/Tenant/Compliance/CalculateViolationsOverviewTest.php` | ✅ |
| Audit tracker | `GetAuditTracker` | `tests/Feature/Tenant/Compliance/GetAuditTrackerTest.php` | ✅ |
| Critical vulnerabilities | `GetCriticalVulnerabilities` | `tests/Feature/Tenant/Compliance/GetCriticalVulnerabilitiesTest.php` | ✅ |
| Location grades | `GetLocationGrades` | `tests/Feature/Tenant/Compliance/GetLocationGradesTest.php` | ✅ |
| Manuals summary | `GetManualsSummary` | `tests/Feature/Tenant/Compliance/GetManualsSummaryTest.php` | ✅ |
| Training completion by dept | `GetTrainingCompletionByDepartment` | `tests/Feature/Tenant/Compliance/GetTrainingCompletionByDepartmentTest.php` | ✅ |
| Training compliance snapshot | `GetTrainingComplianceSnapshot` | `tests/Feature/Tenant/Compliance/GetTrainingComplianceSnapshotTest.php` | ✅ |
| Snapshot scheduled command | `Console/Commands/SnapshotComplianceScoresCommand` | `tests/Feature/Tenant/Console/SnapshotComplianceScoresCommandTest.php` | ✅ |
| Department completion stats (Livewire) | `Http/Livewire/Dealer/Employee/DepartmentCompletionStats` | `tests/Feature/Tenant/DepartmentCompletionStatsTest.php` | ✅ |

### Stores / Locations / Switching
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| First-store enforcement | `Dealer/Store/CreateFirstStoreController` | `tests/Feature/Tenant/FirstStoreEnforcementTest.php`, `RequireTenantStoreMiddlewareTest.php` | ✅ |
| Switch current store | `Tenant/Store/SwitchStoreController` | `tests/Feature/Tenant/SwitchStoreControllerTest.php` | ✅ |
| Location CRUD | `Tenant/Store/LocationController` | `tests/Feature/Tenant/Location/LocationControllerTest.php` | ✅ |
| Store-scoped middleware | `StoreIdentifier`/`RequireTenantStore` middleware | `tests/Feature/Tenant/StoreIdentifierMiddlewareTest.php`, `StoreMiddlewareTest.php` | ✅ |
| Legacy store redirect | route-level | `tests/Feature/Tenant/LegacyStoreRedirectTest.php` | ✅ |
| Store-level access control | `Policies/StorePolicy` | `tests/Feature/Tenant/Authorization/StoreAccessControlTest.php` | ✅ |
| `SetCurrentStoreCommand` | `Console/Commands/SetCurrentStoreCommand` | `tests/Feature/Tenant/Console/SetCurrentStoreCommandTest.php` | ✅ |
| Sync single-store users | `Console/Commands/SyncSingleStoreUsersCommand` | `tests/Feature/Tenant/Console/SyncSingleStoreUsersCommandTest.php` | ✅ |

### Employees
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index (list + filter) | `Tenant/UserController@index` | `tests/Feature/Tenant/Employee/EmployeeIndexControllerTest.php` | ✅ |
| Show employee | `@show` | `tests/Feature/Tenant/Employee/EmployeeShowControllerTest.php` | ✅ |
| Invite employee | `Tenant/UserController@invite` + `InviteEmployeeRequest` | `tests/Feature/Tenant/Employee/InviteEmployeeControllerTest.php` | ✅ |
| Invite email content | `Mail/InviteMail` / `SendInviteMail` | `tests/Feature/Tenant/Employee/InviteMailTest.php` | ✅ |
| Open invites list | `Tenant/UserController@openInvites` | `tests/Feature/Tenant/Employee/OpenInvitesControllerTest.php` | ✅ |
| Deleted employees view | `Tenant/UserController@deleted` | `tests/Feature/Tenant/Employee/DeletedEmployeesControllerTest.php` | ✅ |
| Import employees (CSV) | `Tenant/UserController@import` + `Jobs/ImportEmployeesJob` | `tests/Feature/Tenant/Employee/ImportEmployeesControllerTest.php` | ✅ |
| Send custom message | `Tenant/UserController@sendCustomMessage` + `Jobs/SendCustomEmployeeMessageJob` | `tests/Feature/Tenant/Employee/SendCustomMessageControllerTest.php` | ✅ |
| Register invited employee (full flow) | `Dealer/UserController` | `tests/Feature/Tenant/Employee/RegisterInvitedEmployeeTest.php`, `InviteRegistrationStoreAssignmentTest.php` | ✅ |
| Export employees CSV | `Domain/Tenant/User/Actions/BuildEmployeesCsv` | `tests/Feature/Tenant/Employee/BuildEmployeesCsvTest.php` | ✅ |
| `EmployeesImportComplete` notification | `Notifications/EmployeesImportCompleteNotification` | `tests/Feature/Tenant/Employee/EmployeesImportCompleteNotificationTest.php` | ✅ |

### Audits — Violation Audits (OSHA / GLBA / BodyShop framework)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| OSHA index | `Tenant/Audit/ViolationAuditController` (Osha) | `tests/Feature/Tenant/Audits/Osha/IndexTest.php` | ✅ |
| OSHA show | same | `tests/Feature/Tenant/Audits/Osha/ShowTest.php` | ✅ |
| OSHA create | same | `tests/Feature/Tenant/Audits/Osha/CreateTest.php` | ✅ |
| OSHA edit | same | `tests/Feature/Tenant/Audits/Osha/EditOshaViolationAuditTest.php` | ✅ |
| OSHA violations attach | same | `tests/Feature/Tenant/Audits/Osha/ViolationsTest.php` | ✅ |
| OSHA grade update | same | `tests/Feature/Tenant/Audits/Osha/UpdateGradeTest.php` | ✅ |
| OSHA remediation form | same | `tests/Feature/Tenant/Audits/Osha/RemediationFormTest.php` | ✅ |
| OSHA destroy | same | `tests/Feature/Tenant/Audits/Osha/DestroyTest.php` | ✅ |
| OSHA PDF generate | `Jobs/Audit/GenerateOshaPdfJob` | `tests/Unit/Jobs/Audit/GenerateOshaPdfJobTest.php` | ✅ |
| OSHA PDF upload | `Jobs/Audit/UploadOshaPdfJob` | `tests/Feature/Tenant/Audits/Osha/UploadOshaPdfJobTest.php` | ✅ |
| OSHA remediation PDF | `Jobs/Audit/GenerateOshaRemediationPdfJob` | `tests/Feature/Tenant/Audits/RemediationPdfJobTest.php` | ✅ |
| GLBA edit/full flow | `ViolationAuditController` (Glba) | `tests/Feature/Tenant/Audits/Glba/EditGlbaViolationAuditTest.php` | ✅ |
| GLBA PDF generate | `Jobs/Audit/GenerateGlbaPdfJob` | `tests/Unit/Jobs/Audit/GenerateGlbaPdfJobTest.php` | ✅ |
| GLBA PDF upload | `Jobs/Audit/UploadGlbaPdfJob` | `tests/Feature/Tenant/Audits/Glba/UploadGlbaPdfJobTest.php` | ✅ |
| GLBA remediation PDF | `Jobs/Audit/GenerateGlbaRemediationPdfJob` | `tests/Feature/Tenant/Audits/RemediationPdfJobTest.php` | ✅ |
| BodyShop edit/full flow | `ViolationAuditController` (BodyShop) | `tests/Feature/Tenant/Audits/BodyShop/EditBodyShopViolationAuditTest.php` | ✅ |
| BodyShop PDF generate | `Jobs/Audit/GenerateBodyShopPdfJob` | `tests/Unit/Jobs/Audit/GenerateBodyShopPdfJobTest.php` | ✅ |
| BodyShop PDF upload | `Jobs/Audit/UploadBodyShopPdfJob` | `tests/Feature/Tenant/Audits/BodyShop/UploadBodyShopPdfJobTest.php` | ✅ |
| BodyShop remediation PDF | `Jobs/Audit/GenerateBodyShopRemediationPdfJob` | `tests/Feature/Tenant/Audits/RemediationPdfJobTest.php` | ✅ |
| Audit chart data | `Domain/Tenant/Audits/Queries/BuildAuditChartData` | `tests/Unit/Domain/Tenant/Audits/Queries/BuildAuditChartDataTest.php` | ✅ |
| Scoped store resolution | `ResolveAuditScopedStores` | `tests/Unit/Domain/Tenant/Audits/Queries/ResolveAuditScopedStoresTest.php` | ✅ |
| Individual audit DO upload | `Jobs/UploadIndividualAuditToDigitalOceanJob` | `tests/Feature/Tenant/Audits/UploadIndividualAuditToDigitalOceanJobTest.php` | ✅ |

### Audits — Individual / Fit Tests / Deal Jackets
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Individual audit CRUD | `Tenant/Audit/IndividualAuditController` | `tests/Feature/Tenant/Audit/IndividualAuditControllerTest.php` | ✅ |
| Individual audit PDF | `Jobs/GenerateIndividualAuditPdfJob` | `tests/Feature/Tenant/Audits/GenerateIndividualAuditPdfJobTest.php` | ✅ |
| Fit test CRUD | `Tenant/Audit/FitTestController` | `tests/Feature/Tenant/Audit/FitTestControllerTest.php` | ✅ |
| Deal jacket CRUD | `Tenant/Audit/DealJacketController` | `tests/Feature/Tenant/Audit/DealJacketControllerTest.php` | ✅ |
| Deal jacket report download | `Tenant/Audit/DealJacketReportDownloadController` | `tests/Feature/Tenant/Audit/DealJacketReportDownloadControllerTest.php` | ✅ |
| Deal jacket report job | `Jobs/Audit/GenerateDealJacketReportJob` | `tests/Feature/Tenant/Audit/GenerateDealJacketReportJobTest.php` | ✅ |
| Deal jacket cleanup command | `Console/Commands/CleanupOldDealJacketReportsCommand` | `tests/Feature/Tenant/Console/CleanupOldDealJacketReportsCommandTest.php` | ✅ |

### Manuals (CMS / ISP / OSHA / RedFlag)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| CMS manual CRUD + download | `Tenant/Manuals/CmsController` | `tests/Feature/Tenant/Manuals/Cms/CmsControllerTest.php` | ✅ |
| ISP manual CRUD + download | `Tenant/Manuals/IspController` | `tests/Feature/Tenant/Manuals/Isp/IspControllerTest.php` | ✅ |
| OSHA manual CRUD + download | `Tenant/Manuals/OshaController` | `tests/Feature/Tenant/Manuals/Osha/OshaControllerTest.php` | ✅ |
| RedFlag manual CRUD + download | `Tenant/Manuals/RedFlagController` | `tests/Feature/Tenant/Manuals/RedFlag/RedFlagControllerTest.php` | ✅ |
| Generate manual PDF jobs | `Jobs/Manuals/Generate*ManualJob` (Cms/Isp/Osha/RedFlag) | `tests/Feature/Tenant/Manuals/GenerateManualJobTest.php` | ✅ |
| Upload manual to DO jobs | `Jobs/Manuals/Upload*ToDigitalOceanJob` (Cms/Isp/Osha/RedFlag) | `tests/Feature/Tenant/Manuals/UploadManualJobTest.php` | ✅ |
| Manual access policies | `ManualAccessTest` | `tests/Feature/Tenant/Authorization/ManualAccessTest.php` | ✅ |

### Courses (tenant-facing — assignment & completion)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Course index | `Tenant/CourseController@index` | `tests/Feature/Tenant/Course/IndexTest.php` | ✅ |
| Course index item (visibility) | same | `tests/Feature/Tenant/Course/IndexItemTest.php` | ✅ |
| Show / video player | `@show` | `tests/Feature/Tenant/Course/ShowEmbedTest.php`, `CourseShowRedirectTest.php` | ✅ |
| Mark video complete | `@markVideoComplete` | `tests/Feature/Tenant/Course/MarkVideoCompleteTest.php` | ✅ |
| Submit quiz | `@submitQuiz` | `tests/Feature/Tenant/Course/SubmitQuizTest.php` | ✅ |
| Course assignment to user | `Domain/Tenant/Course/Actions/AssignCourse` | `tests/Feature/Tenant/Course/CourseAssignmentTest.php` | ✅ |
| Reminder commands (expiring/expired) | `Console/Commands/CourseExpiringEmailCommand`, `CourseReminderCommand`, `CourseYearsExpireCommand`, `EmployeeCourseReminderCommand`, `RemediationReminderCommand` | `tests/Feature/Tenant/Course/CourseReminderCommandsTest.php`, `CourseYearsExpireCommandTest.php`, `tests/Feature/Tenant/Console/RemediationReminderCommandTest.php` | ✅ |
| Issue DOT certificate | `Jobs/IssueDotCertificate`, `CourseController@issueDotCertificate` | `tests/Feature/Tenant/Course/IssueDotCertificateJobTest.php` | ✅ |
| DOT cert ready notification | `Notifications/DotCertificateReadyNotification` | `tests/Feature/Tenant/Course/CourseNotificationsTest.php` | ✅ |
| Course-expired notifications | `Notifications/CourseExpired*`, `ExpiredCourseNotification`, `IncompleteCoursesNotification` | `tests/Feature/Tenant/Course/CourseNotificationsTest.php` | ✅ |
| New course notification command | `Console/Commands/NewCourseNotificationCommand`, `SendCourseNotificationToTenantCommand` | `tests/Feature/Tenant/SendCourseNotificationToTenantCommandTest.php`, `tests/Feature/Tenant/Console/NewCourseNotificationCommandTest.php` | ✅ |
| Backfill IL harassment results | `Console/Commands/BackfillIllinoisHarassmentCourseResultsCommand` | `tests/Feature/BackfillIllinoisHarassmentCourseResultsCommandTest.php` | ✅ |
| Sync IL harassment roles | `Console/Commands/SyncIllinoisHarassmentRolesCommand` | `tests/Feature/SyncIllinoisHarassmentRolesCommandTest.php` | ✅ |
| Sync CA harassment replacement | `Console/Commands/SyncCaliforniaHarassmentReplacementCommand` | `tests/Feature/SyncCaliforniaHarassmentReplacementCommandTest.php` | ✅ |
| Reconcile tenant courses | `Console/Commands/ReconcileTenantCoursesCommand` | `tests/Feature/ReconcileTenantCoursesCommandTest.php` | ✅ |
| Revert course reset | `Console/Commands/RevertCourseResetCommand` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| Send course reset notifications | `Jobs/SendCoursesResetNotifications` | `tests/Feature/Tenant/Course/SendCoursesResetNotificationsJobTest.php` | ✅ |
| Course reset (mail + flow) | `Mail/CourseResetNotificationMail`, `CourseNotificationMail` | `tests/Feature/Tenant/Course/CourseMailablesTest.php` | ✅ |
| Update optional courses | `Console/Commands/UpdateOptionalCourses` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| Add video to course | `Console/Commands/AddVideoToCourseCommand` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| Enable vimeo seek | `Console/Commands/EnableVimeoSeek` | `tests/Feature/Tenant/Course/ComplexCourseCommandsTest.php` | ✅ |
| Verify course videos | `Console/Commands/VerifyCourseVideos` | — | ⚠️ (broken: queries DealerCourse outside tenancy context) |
| Audit finance manager courses | `Console/Commands/AuditFinanceManagerCoursesCommand` | `tests/Feature/Tenant/Course/ComplexCourseCommandsTest.php` | ✅ |
| Dealer course show (slug-based) | `Dealer/CourseController` | `tests/Feature/Tenant/Dealer/Course/ShowTest.php` | ✅ |

### Scans (Cyrisma integration)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Scans dashboard | `Tenant/ScansController` | `tests/Feature/Tenant/Scans/ScansControllerTest.php`, `ScanDashboardQueryTest.php` | ✅ |
| Settings (Cyrisma config) | same | `tests/Feature/Tenant/Scans/SettingsTest.php` | ✅ |
| Vulnerabilities list | same | `tests/Feature/Tenant/Scans/CyrismaVulnerabilitiesTest.php` | ✅ |
| External IP exposure | `Domain/Tenant/Scans/Queries/GetExternalIpExposure` | `tests/Feature/Tenant/Scans/ExternalIpExposureQueryTest.php` | ✅ |
| Open ports list | `Domain/Tenant/Scans/Queries/GetOpenPortsList` | `tests/Feature/Tenant/Scans/OpenPortsListQueryTest.php` | ✅ |
| Scan archive | `Tenant/ScanArchiveController` | `tests/Feature/Tenant/Scans/ScanArchiveControllerTest.php` | ✅ |
| Download report | `Tenant/CyrismaReportController` | `tests/Feature/Tenant/Scans/DownloadReportTest.php` | ✅ |
| Cyrisma policy | `Policies/CyrismaPolicy` | `tests/Feature/Tenant/Authorization/CyrismaPolicyTest.php` | ✅ |
| Cyrisma controller | `Tenant/CyrismaController` | `tests/Feature/Tenant/Scans/SettingsTest.php` | ✅ (settings + update) |
| Generate Cyrisma report job | `Jobs/Scans/GenerateCyrismaReportJob` | `tests/Feature/Tenant/Scans/GenerateCyrismaReportJobTest.php` | ⚠️ (middleware + failed() covered; handle() PDF path requires real Cyrisma data) |
| Scan report ready/failed notifications | `Notifications/Scans/ScanReportReady…`, `ScanReportFailed…` | `tests/Feature/Tenant/Scans/ScanReportNotificationsTest.php` | ✅ |

### Vendors
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Vendor index (dealer) | `Dealer/VendorController` | `tests/Feature/Tenant/Dealer/Vendor/VendorControllerTest.php`, `tests/Feature/Tenant/Vendor/IndexItemTest.php` | ✅ |
| Public vendor form | `Dealer/VendorController@form`, `@submit` | `tests/Feature/Tenant/Vendor/PublicVendorFormTest.php` | ✅ |
| Vendor form submit (action) | `Domain/Tenant/Vendor/Actions/SubmitVendorForm` | `tests/Feature/Tenant/Vendor/SubmitVendorFormActionTest.php` | ✅ |
| Send vendor email job | `Jobs/SendVendorEmailJob` | `tests/Feature/Tenant/Jobs/SendVendorEmailJobTest.php` | ✅ |
| Incomplete vendor reminder | `Jobs/IncompleteVendorNotificationJob` | `tests/Feature/Tenant/Jobs/IncompleteVendorNotificationJobTest.php` | ✅ |
| Vendor email log | tenant log surface | `tests/Feature/Tenant/VendorEmailLogTest.php` | ✅ |
| Send vendor notification command | `Console/Commands/SendVendorNotificationCommand` | `tests/Feature/Tenant/Vendor/SendVendorNotificationCommandTest.php` | ✅ |
| ~~Download vendor PDF~~ (orphan, deleted) | ~~`Jobs/DownloadVendorPdfJob`~~ | — | n/a |
| Vendor form notification | `Notifications/VendorFormNotification`, `VendorSignedNotification` | `tests/Feature/Tenant/Vendor/VendorNotificationsTest.php` | ✅ |

### SDS (tenant-facing)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Index / search | `Tenant/SdsController@index` | `tests/Feature/Tenant/Sds/SdsControllerTest.php` | ✅ |
| View record | `@view` | `tests/Feature/Tenant/Sds/SdsControllerTest.php` | ✅ |
| Request SDS sheet | `@storeRequest`, `Mail/Tenant/SdsRequestMail` | `tests/Feature/Tenant/Sds/SdsControllerTest.php`, `tests/Feature/Tenant/Sds/SdsRequestMailTest.php` | ✅ |

### Notifications & Logs
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Notification index | `Tenant/NotificationsController` | `tests/Feature/Tenant/Notifications/NotificationsControllerTest.php` | ✅ |
| Mark single read / mark all / delete | same | same | ✅ |
| Activity log index | `Tenant/LogController` | `tests/Feature/Tenant/LogsIndexTest.php`, `Log/SensitiveFieldRedactionTest.php` | ✅ |
| Sensitive field redaction | `Domain/Tenant/Log/*` | `tests/Feature/Tenant/Log/SensitiveFieldRedactionTest.php` | ✅ |

### Settings (tenant)
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Settings landing | route + Inertia | `tests/Feature/Tenant/SettingsOverviewTest.php` | ✅ |
| Global settings | `Tenant/Settings/GlobalSettingsController` | `tests/Feature/Tenant/Dealer/Settings/GlobalSettingsControllerTest.php` | ✅ |
| Store settings sections | `Tenant/Settings/StoreSettingsController` | `tests/Feature/Tenant/Dealer/Store/SettingsSectionsTest.php` | ✅ |
| Compliance form (signed link, settings) | `Tenant/Settings/ComplianceFormController` | `tests/Feature/Tenant/Settings/ComplianceFormControllerTest.php` | ✅ |
| Automated reports | `Tenant/Settings/AutomatedReportsController` | `tests/Feature/Tenant/Dealer/Settings/AutomatedReportsControllerTest.php` | ✅ |
| Profile (settings) | `Tenant/Settings/ProfileController` | `tests/Feature/Tenant/Settings/ProfileControllerTest.php` | ✅ |
| Toggle store notifications | `GlobalSettingsController@toggleStoreNotifications` | `tests/Feature/Tenant/Dealer/Settings/GlobalSettingsControllerTest.php` | ✅ |

### Search & Misc
| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Global search | `Tenant/SearchController` | `tests/Feature/Tenant/SearchControllerTest.php` | ✅ |
| Mail-from header config | `config/mail.php` | `tests/Feature/Tenant/Mail/MailFromConfigTest.php` | ✅ |
| Department completion stats (Livewire) | `Http/Livewire/Dealer/Employee/DepartmentCompletionStats` | `tests/Feature/Tenant/DepartmentCompletionStatsTest.php` | ✅ |

---

## 4. APIs & Webhooks

| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| API auth (Sanctum token) | `API/AuthController` | `tests/Feature/API/AuthControllerTest.php` | ✅ |
| ~~Dealer list endpoint~~ (orphan, deleted) | ~~`API/DealerListController`~~ | — | n/a |
| Mailgun webhook | `API/MailgunWebhookController` | `tests/Feature/MailgunWebhookTest.php` | ✅ |

---

## 5. Background Jobs (catalog)

| Job | Tests | Status |
| --- | --- | --- |
| `Audit/Generate*PdfJob` (Osha/Glba/BodyShop) | `tests/Unit/Jobs/Audit/Generate*PdfJobTest.php` | ✅ |
| `Audit/Upload*PdfJob` (Osha/Glba/BodyShop) | tenant audit feature tests | ✅ |
| `Audit/Generate*RemediationPdfJob` (Osha/Glba/BodyShop) | `tests/Feature/Tenant/Audits/RemediationPdfJobTest.php` | ✅ |
| `Audit/GenerateDealJacketReportJob` | `tests/Feature/Tenant/Audit/GenerateDealJacketReportJobTest.php` | ✅ |
| `Contracts/GeneratePdfJob` | `tests/Feature/Central/Contract/PdfTest.php` | ✅ |
| `Contracts/UploadToDigitalOceanJob` | `tests/Feature/Central/Contract/UploadToDigitalOceanJobTest.php` | ✅ |
| `CreateFrameworkDirectoriesForTenantJob` | `tests/Feature/Tenant/Jobs/CreateFrameworkDirectoriesForTenantJobTest.php` | ✅ |
| `CrossTenantPasswordResetJob` | `tests/Feature/Auth/CrossTenantPasswordResetTest.php`, `tests/Feature/Tenant/Auth/CrossTenantPasswordResetJobTest.php` | ✅ |
| ~~`DownloadVendorPdfJob`~~ | — | deleted (orphan, empty handle) |
| `GenerateIndividualAuditPdfJob` | `tests/Feature/Tenant/Audits/GenerateIndividualAuditPdfJobTest.php` | ✅ |
| `ImportEmployeesJob` | `tests/Feature/Tenant/Employee/ImportEmployeesControllerTest.php` | ✅ |
| `IncompleteVendorNotificationJob` | `tests/Feature/Tenant/Jobs/IncompleteVendorNotificationJobTest.php` | ✅ |
| `IssueDotCertificate` | `tests/Feature/Tenant/Course/IssueDotCertificateJobTest.php` | ✅ |
| `Manuals/Generate*ManualJob` | `tests/Feature/Tenant/Manuals/GenerateManualJobTest.php` | ✅ |
| `Manuals/Upload*ToDigitalOceanJob` | `tests/Feature/Tenant/Manuals/UploadManualJobTest.php` | ✅ |
| ~~`RemediationReminderEmailJob`~~ | — | deleted (orphan, only dispatched `InitialRemediationReminderNotification` which was also unused) |
| `Scans/GenerateCyrismaReportJob` | `tests/Feature/Tenant/Scans/GenerateCyrismaReportJobTest.php` | ⚠️ |
| `SendComplianceSummaryJob` | `tests/Feature/Tenant/Jobs/SendComplianceSummaryJobTest.php` | ✅ |
| `SendCoursesResetNotifications` | `tests/Feature/Tenant/Course/SendCoursesResetNotificationsJobTest.php` | ✅ |
| `SendCustomEmployeeMessageJob` | `tests/Feature/Tenant/Employee/SendCustomMessageControllerTest.php`, `tests/Feature/Tenant/Jobs/SendCustomEmployeeMessageJobTest.php` | ✅ |
| `SendQueueEmailJob` | `tests/Feature/Tenant/Jobs/SendQueueEmailJobTest.php` | ✅ |
| `SendVendorEmailJob` | `tests/Feature/Tenant/Jobs/SendVendorEmailJobTest.php` | ✅ |
| `TestRedisJob` | — | n/a (debug-only) |
| `UploadIndividualAuditToDigitalOceanJob` | `tests/Feature/Tenant/Audits/UploadIndividualAuditToDigitalOceanJobTest.php` | ✅ |

---

## 6. Console Commands (catalog)

| Command | Tests | Status |
| --- | --- | --- |
| `AddVideoToCourseCommand` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| `AuditFinanceManagerCoursesCommand` | `tests/Feature/Tenant/Course/ComplexCourseCommandsTest.php` | ✅ |
| `BackfillIllinoisHarassmentCourseResultsCommand` | `tests/Feature/BackfillIllinoisHarassmentCourseResultsCommandTest.php` | ✅ |
| `BackupCleanupCommand` | `tests/Feature/Tenant/Console/BackupCommandsTest.php` | ✅ |
| `BackupCommand` | `tests/Feature/Tenant/Console/BackupCommandsTest.php` | ✅ |
| `BackupSelfCheckCommand` | `tests/Feature/Tenant/Console/BackupCommandsTest.php` | ✅ |
| `CheckMissingSdsFiles` | `tests/Feature/CheckMissingSdsFilesTest.php` | ✅ |
| `CheckMultiStateUsersCommand` | `tests/Feature/CheckMultiStateUsersCommandTest.php` | ✅ |
| `CleanupOldDealJacketReportsCommand` | `tests/Feature/Tenant/Console/CleanupOldDealJacketReportsCommandTest.php` | ✅ |
| `ClearLivewireTempFiles` | `tests/Feature/Tenant/Console/MaintenanceCommandsTest.php` | ✅ |
| `CourseExpiringEmailCommand` | `tests/Feature/Tenant/Course/CourseReminderCommandsTest.php` | ✅ |
| `CourseReminderCommand` | same | ✅ |
| `CourseYearsExpireCommand` | `tests/Feature/Tenant/Course/CourseYearsExpireCommandTest.php` | ✅ |
| `DeleteTemporaryUploadsCommand` | — | ⚠️ (broken: spatie/media-library-pro v3 removed `TemporaryUpload::old()` scope) |
| `EmployeeCourseReminderCommand` | `tests/Feature/Tenant/Course/CourseReminderCommandsTest.php` | ✅ |
| `EnableVimeoSeek` | `tests/Feature/Tenant/Course/ComplexCourseCommandsTest.php` | ✅ |
| `ImportSdsCommand` | `tests/Feature/ImportSdsCommandTest.php` | ✅ |
| `MigrateSharedDocumentsToCentralDocsCommand` | — | ⚠️ (one-off bulk migration script, not run on schedule) |
| `MigrateViolationStatementsCommand` | `tests/Feature/Central/ViolationStatement/MigrateViolationStatementsCommandTest.php` | ✅ |
| `NewCourseNotificationCommand` | `tests/Feature/Tenant/Console/NewCourseNotificationCommandTest.php` | ✅ |
| `ReconcileTenantCoursesCommand` | `tests/Feature/ReconcileTenantCoursesCommandTest.php` | ✅ |
| `RemediationReminderCommand` | `tests/Feature/Tenant/Console/RemediationReminderCommandTest.php` | ⚠️ (no-op branches covered; due-audit happy path requires fixture-heavy reminder_logs JSON) |
| `RepairViolationStatementKeywordsCommand` | `tests/Feature/Central/ViolationStatement/RepairViolationStatementKeywordsCommandTest.php` | ✅ |
| `ReportTenantSizeCommand` | — | ⚠️ (diagnostic-only; prints `information_schema.TABLES` size per tenant DB) |
| `RevertCourseResetCommand` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| `RunInvitesCommand` | `tests/Feature/Tenant/Console/RunInvitesCommandTest.php` | ✅ |
| `SendComplianceSummaryCommand` | `tests/Feature/Tenant/Console/SendComplianceSummaryCommandTest.php` | ✅ |
| `SendCourseNotificationToTenantCommand` | `tests/Feature/Tenant/SendCourseNotificationToTenantCommandTest.php` | ✅ |
| `SendVendorNotificationCommand` | `tests/Feature/Tenant/Vendor/SendVendorNotificationCommandTest.php` | ✅ |
| `SetCurrentStoreCommand` | `tests/Feature/Tenant/Console/SetCurrentStoreCommandTest.php` | ✅ |
| `SnapshotComplianceScoresCommand` | `tests/Feature/Tenant/Console/SnapshotComplianceScoresCommandTest.php` | ✅ |
| `SyncCaliforniaHarassmentReplacementCommand` | `tests/Feature/SyncCaliforniaHarassmentReplacementCommandTest.php` | ✅ |
| `SyncIllinoisHarassmentRolesCommand` | `tests/Feature/SyncIllinoisHarassmentRolesCommandTest.php` | ✅ |
| `SyncSingleStoreUsersCommand` | `tests/Feature/Tenant/Console/SyncSingleStoreUsersCommandTest.php` | ✅ |
| `UpdateCompletedAtFieldForAudits` | — | ⚠️ (one-off backfill that sets completed_date = updated_at on uploaded but unmarked violation audits) |
| `UpdateOptionalCourses` | `tests/Feature/Tenant/Course/CourseMaintenanceCommandsTest.php` | ✅ |
| `VerifyCourseVideos` | — | ⚠️ (broken: queries DealerCourse outside tenancy context) |

---

## 7. Authorization Matrix (Roles × Routes)

Roles (ascending): `Employee`, `Porter/Driver`, `Manager`, `Qualified Individual`, `GSM`, `GM`, `CFO`, `Owner`, `Consultant`, `super-admin`. See `docs/access-control.md` for the canonical permission map.

### Per-role access tests
| Role | Coverage test | Status |
| --- | --- | --- |
| Guest (unauthenticated) | `tests/Feature/Tenant/Authorization/GuestAccessTest.php` | ✅ |
| Employee | `tests/Feature/Tenant/Authorization/EmployeeAccessTest.php` | ✅ |
| Manager | `tests/Feature/Tenant/Authorization/ManagerAccessTest.php` | ✅ |
| Qualified Individual (QI) | `tests/Feature/Tenant/Authorization/QIAccessTest.php` | ✅ |
| Owner / CFO / GM / GSM | `tests/Feature/Tenant/Authorization/OwnerCfoGmGsmAccessTest.php` | ✅ |
| Consultant | `tests/Feature/Tenant/Authorization/ConsultantAccessTest.php` | ✅ |
| Admin (tenant admin role) | `tests/Feature/Tenant/Authorization/AdminAccessTest.php` | ✅ |
| super-admin (tenant context) | `tests/Feature/Tenant/Authorization/SuperAdminAccessTest.php` | ✅ |
| Impersonation gates | `tests/Feature/Tenant/Authorization/ImpersonationAccessTest.php` | ✅ |
| Central side routes (super-admin / Consultant gating) | `tests/Feature/Central/Authorization/CentralRouteAccessTest.php` | ✅ |
| Store-level scoping | `tests/Feature/Tenant/Authorization/StoreAccessControlTest.php` | ✅ |
| Manual-access scoping | `tests/Feature/Tenant/Authorization/ManualAccessTest.php` | ✅ |
| Cyrisma policy | `tests/Feature/Tenant/Authorization/CyrismaPolicyTest.php` | ✅ |
| Tenant route coverage (sanity) | `tests/Feature/Tenant/TenantRouteCoverageTest.php` | ✅ |
| Tenant general access | `tests/Feature/Tenant/TenantAccessTest.php` | ✅ |

### Per-policy method coverage
| Policy | Tests | Status |
| --- | --- | --- |
| `Central/ContractPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/DealershipPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/DocumentPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/InvitePolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/SdsPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/SharedDocumentPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `Central/UserPolicy` | `tests/Feature/Central/Authorization/CentralUserPolicyTest.php` | ✅ |
| `Central/ViolationStatementPolicy` | `tests/Feature/Central/Authorization/CentralPoliciesTest.php` | ✅ |
| `CoursePolicy` | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |
| `CourseResultsPolicy` | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |
| `CyrismaPolicy` | `CyrismaPolicyTest` | ✅ |
| `DealerDocPolicy` | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |
| `DealJacketGroupPolicy` | `tests/Feature/Tenant/Authorization/DealJacketPolicyTest.php` | ✅ |
| `DealJacketPolicy` | `tests/Feature/Tenant/Authorization/DealJacketPolicyTest.php` | ✅ |
| `GlobalSettingPolicy` | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |
| `SharedDocumentPolicy` (tenant) | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |
| `StorePolicy` | `StoreAccessControlTest` | ✅ |
| `VendorPolicy` | `tests/Feature/Tenant/Authorization/TenantPoliciesTest.php` | ✅ |

> Per-method policy unit tests live in `tests/Feature/{Central,Tenant}/Authorization/`. Integration tests in the route handlers still exercise the policies end-to-end.

---

## 8. Multi-Tenancy Infrastructure

| Feature | Source | Tests | Status |
| --- | --- | --- | --- |
| Tenant data isolation (DB per tenant) | Stancl tenancy | `tests/Feature/Tenant/TenantIsolationTest.php` | ✅ |
| `InitializeTenancyByDomain` middleware | route stack | `tests/Feature/Tenant/TenantAccessTest.php`, `tests/Feature/Tenant/Middleware/TenancyRoutingMiddlewareTest.php` | ✅ |
| `PreventAccessFromCentralDomains` middleware | route stack | `tests/Feature/Tenant/Middleware/TenancyRoutingMiddlewareTest.php` | ✅ |
| `EnsureTenantIsNotSuspended` middleware | `Http/Middleware/EnsureTenantIsNotSuspended` | `tests/Feature/Tenant/Middleware/EnsureTenantIsNotSuspendedTest.php` | ✅ |
| Queue Redis routing (DB 3, no prefix) | `config/database.php` (`redis.queue` connection) | `tests/Feature/QueueRedisRoutingTest.php` | ✅ |
| Telescope disabled in prod | `Providers/TelescopeServiceProvider` | `tests/Unit/TelescopeDisabledTest.php` | ✅ |
| Framework dirs created for new tenant | `Jobs/CreateFrameworkDirectoriesForTenantJob` | `tests/Feature/Tenant/Jobs/CreateFrameworkDirectoriesForTenantJobTest.php` | ✅ |
| Backups (configure/cleanup/self-check) | `Console/Commands/Backup*` | `tests/Feature/Tenant/Console/BackupCommandsTest.php` | ✅ |

---

## Top Gaps (priority order)

Every ❌ row is resolved, every policy has a dedicated (role × method) unit test, and both tenancy router middlewares are now isolated-tested. Only two genuine ⚠️ rows remain:

1. **`GenerateCyrismaReportJob::handle()`** — the PDF/FPDI render path would need a real Cyrisma API response + browsershot output; the WithoutOverlapping middleware and `failed()` notification path are already covered.
2. **`RemediationReminderCommand` due-audit happy path** — the JSON_LENGTH/JSON_UNQUOTE SQL window plus the OshaViolation + reminder-preference fixtures needed to trigger a real reminder is heavier than the no-op branches that are already tested.

Outside the table are the won't-fix-without-upgrade rows: `DeleteTemporaryUploadsCommand` (broken upstream API), `VerifyCourseVideos` (queries `DealerCourse` outside tenancy context), and three one-off admin scripts (`MigrateSharedDocumentsToCentralDocsCommand`, `ReportTenantSizeCommand`, `UpdateCompletedAtFieldForAudits`).

---

## How to verify a row

Pick the test file from the table and run it scoped:

```bash
php artisan test --compact tests/Feature/Tenant/Audits/Osha/CreateTest.php
```

For groups of related tests:

```bash
php artisan test --compact tests/Feature/Tenant/Compliance
```

Per the project's memory rules, do **not** run `php artisan test` without a path filter — the full suite is too slow and the shared `dashboard_testing` MySQL DB makes parallel runs unsafe.
