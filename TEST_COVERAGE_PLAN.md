# Test Coverage Plan

> **Multi-Tenant Laravel 10 Application** (stancl/tenancy v3)
> Generated: 2026-02-10
>
> Legend: ~~Strikethrough~~ = test exists | Plain = test needed

---

## 1. Authentication (Central)

- ~~`tests/Feature/Auth/AuthenticationTest.php` - Login/logout flows~~
- ~~`tests/Feature/Auth/EmailVerificationTest.php` - Email verification~~
- ~~`tests/Feature/Auth/PasswordConfirmationTest.php` - Password confirmation~~
- ~~`tests/Feature/Auth/PasswordResetTest.php` - Password reset~~
- ~~`tests/Feature/Auth/PasswordUpdateTest.php` - Password update~~
- ~~`tests/Feature/Auth/RegistrationTest.php` - User registration~~

## 2. Authentication (Tenant / Dealer)

- ~~`tests/Feature/Tenant/Auth/AuthenticationTest.php` - Dealer login/logout via tenant domain~~
- ~~`tests/Feature/Tenant/Auth/PasswordResetTest.php` - Dealer password reset~~
- ~~`tests/Feature/Tenant/Auth/PasswordConfirmationTest.php` - Dealer password confirmation~~
- ~~`tests/Feature/Tenant/Auth/EmailVerificationTest.php` - Dealer email verification~~
- ~~`tests/Feature/Tenant/Auth/PasswordUpdateTest.php` - Dealer password update~~

## 3. Profile

- ~~`tests/Feature/ProfileTest.php` - Central profile CRUD~~
- `tests/Feature/Tenant/ProfileTest.php` - Dealer profile edit, update, and delete within tenant context

---

## 4. Multi-Tenancy & Isolation

- ~~`tests/Feature/Tenant/TenantIsolationTest.php` - Data isolation between tenants~~
- `tests/Feature/Tenant/TenantCreationTest.php` - Creating a new tenant provisions database, domains, directories
- `tests/Feature/Tenant/TenantDeletionTest.php` - Deleting a tenant cleans up resources
- `tests/Feature/Tenant/DomainRoutingTest.php` - Requests to tenant domain resolve correctly
- `tests/Feature/Tenant/CentralDomainTest.php` - Central domain routes are not accessible on tenant domains
- `tests/Feature/Tenant/ImpersonationTest.php` - Admin impersonation into tenant, stop-impersonation returns to central
- `tests/Feature/Tenant/TenantAwareUrlGeneratorTest.php` - URLs generated within tenant context include correct domain

---

## 5. Models (Unit Tests)

### 5a. Central Models

- `tests/Unit/Models/UserTest.php` - Relationships (contracts, dealerships, stores, department, invites, certificates, phishingCampaigns, timelines, fitTests, videoProgress, remediationReminderPreferences, courseOverrides), scopes (WithoutSuperAdminsAndConsultants, UserStore, CurrentUserIsManager, UsersNotCompletedCourses), soft deletes, slug generation
- `tests/Unit/Models/CourseTest.php` - Relationships (users, roles, results, departments), JSON casts (slides, questions)
- `tests/Unit/Models/CourseResultsTest.php` - Relationships (course, user), passed boolean
- `tests/Unit/Models/DepartmentTest.php` - Relationships (users, courses), unique slug
- `tests/Unit/Models/RoleTest.php` - Relationships (courses), Spatie role behavior
- `tests/Unit/Models/ContractTest.php` - Relationships (user, status), MoneyCast, soft deletes, JSON casts (services, additional_locations)
- `tests/Unit/Models/ContractStatusTest.php` - Relationship (contract)
- `tests/Unit/Models/DealershipTest.php` - Extends BaseTenant, relationships (domains, roles, users)
- `tests/Unit/Models/CourseUserTest.php` - Composite key, pivot attributes

### 5b. Tenant Models

- `tests/Unit/Models/Dealer/StoreTest.php` - Relationships, scopes, settings
- `tests/Unit/Models/Dealer/InviteTest.php` - Invite lifecycle, expiry
- `tests/Unit/Models/Dealer/VendorTest.php` - Relationships, form completion tracking
- `tests/Unit/Models/Dealer/VendorFormTest.php` - Form data, status
- `tests/Unit/Models/Dealer/PhishingCampaignTest.php` - Campaign data, relationships
- `tests/Unit/Models/Dealer/TimelineTest.php` - Polymorphic relationships
- `tests/Unit/Models/Dealer/GlobalSettingTest.php` - Settings retrieval
- `tests/Unit/Models/Dealer/DealerInfoTest.php` - Store information
- `tests/Unit/Models/Dealer/CyrismaTest.php` - Scan data model
- `tests/Unit/Models/Dealer/RidgebackTest.php` - Ridgeback scan model
- `tests/Unit/Models/Dealer/ScanReportTest.php` - Report relationships
- `tests/Unit/Models/Dealer/ScanSettingTest.php` - Setting model
- `tests/Unit/Models/Dealer/CourseTest.php` - Tenant course relationships
- `tests/Unit/Models/Dealer/CourseResultsTest.php` - Tenant results
- `tests/Unit/Models/Dealer/DepartmentTest.php` - Tenant department

### 5c. Audit Models

- `tests/Unit/Models/Dealer/Audit/BodyShopAuditTest.php` - Relationships, JSON casts
- `tests/Unit/Models/Dealer/Audit/BodyShopViolationAuditTest.php` - Violation data, relationships
- `tests/Unit/Models/Dealer/Audit/DealJacketTest.php` - Relationships, data structure
- `tests/Unit/Models/Dealer/Audit/DealJacketGroupTest.php` - Group relationships, stats
- `tests/Unit/Models/Dealer/Audit/FinanceAuditTest.php` - Finance audit data
- `tests/Unit/Models/Dealer/Audit/GlbaViolationAuditTest.php` - GLBA data, relationships
- `tests/Unit/Models/Dealer/Audit/IndividualAuditTest.php` - Individual audit data
- `tests/Unit/Models/Dealer/Audit/OshaAuditTest.php` - OSHA audit data
- `tests/Unit/Models/Dealer/Audit/OshaViolationAuditTest.php` - OSHA violation data

### 5d. Manual Models

- `tests/Unit/Models/Dealer/Manual/GlbTest.php` - GLB manual model
- `tests/Unit/Models/Dealer/Manual/IspTest.php` - ISP manual model
- `tests/Unit/Models/Dealer/Manual/OshaTest.php` - OSHA manual model
- `tests/Unit/Models/Dealer/Manual/RedFlagTest.php` - Red Flag manual model

### 5e. Shared / Question Models

- `tests/Unit/Models/BodyShopQuestionsTest.php` - Question model
- `tests/Unit/Models/DealJacketQuestionTest.php` - Question with categories JSON, weight
- `tests/Unit/Models/FinanceQuestionsTest.php` - Question model
- `tests/Unit/Models/IndividualQuestionsTest.php` - Question model
- `tests/Unit/Models/OshaQuestionsTest.php` - Question model
- `tests/Unit/Models/BodyShopViolationStatementTest.php` - Statement with keywords JSON, weight
- `tests/Unit/Models/GlbaViolationStatementsTest.php` - Statement model
- `tests/Unit/Models/OshaViolationStatementsTest.php` - Statement model
- `tests/Unit/Models/ViolationTest.php` - General violation model (audit_type, keywords)
- `tests/Unit/Models/CertificateTest.php` - Certificate relationship to user
- `tests/Unit/Models/DocumentTest.php` - Document model
- `tests/Unit/Models/SharedDocumentTest.php` - Shared document model
- `tests/Unit/Models/DealerDocTest.php` - Dealer document model
- `tests/Unit/Models/EventTest.php` - Event model
- `tests/Unit/Models/FitTestDocTest.php` - Fit test document, user relationship
- `tests/Unit/Models/RemediationTest.php` - Remediation tracking model
- `tests/Unit/Models/RemediationReminderPreferenceTest.php` - User preferences
- `tests/Unit/Models/RemediationRemindersTest.php` - Reminder records
- `tests/Unit/Models/RemediationSettingTest.php` - Remediation config
- `tests/Unit/Models/SdsTest.php` - SDS model, UUID, keywords JSON
- `tests/Unit/Models/VideoProgressTest.php` - Video progress, user relationship
- `tests/Unit/Models/AuditCommentTest.php` - Polymorphic comment
- `tests/Unit/Models/VendorEmailLogIndexTest.php` - Email log index, tenant_id

### 5f. Settings Models

- `tests/Unit/Models/Dealer/Settings/EmployeeListTest.php` - Employee list settings
- `tests/Unit/Models/Dealer/StoreSettingsTest.php` - Store settings model

---

## 6. Enums (Unit Tests)

- `tests/Unit/Enums/AuditTest.php` - Audit enum values
- `tests/Unit/Enums/AuditTypesTest.php` - Audit type definitions
- `tests/Unit/Enums/ContractStatusTest.php` - Contract status values
- `tests/Unit/Enums/CourseUserTypeTest.php` - Course user type values
- `tests/Unit/Enums/DealJacketQuestionsTest.php` - Deal jacket question types
- `tests/Unit/Enums/DealerRolesTest.php` - Dealer role definitions
- `tests/Unit/Enums/DepartmentsTest.php` - Department values
- `tests/Unit/Enums/FrequencyTest.php` - Frequency options
- `tests/Unit/Enums/ServiceTest.php` - Service types
- `tests/Unit/Enums/StateTest.php` - US state values and labels

---

## 7. Casts (Unit Tests)

- `tests/Unit/Casts/MoneyCastTest.php` - get/set conversion for MoneyCast

---

## 8. Policies (Feature Tests)

- `tests/Feature/Policies/CourseResultsPolicyTest.php` - Authorization for course results (view, create, update, delete by role)
- `tests/Feature/Policies/DealJacketGroupPolicyTest.php` - Authorization for deal jacket groups
- `tests/Feature/Policies/DealJacketPolicyTest.php` - Authorization for deal jackets
- `tests/Feature/Policies/SharedDocumentPolicyTest.php` - Authorization for shared documents

---

## 9. Form Requests (Unit / Feature Tests)

- `tests/Feature/Requests/LoginRequestTest.php` - Login validation rules
- `tests/Feature/Requests/CreateDealerUserRequestTest.php` - Dealer user creation validation
- `tests/Feature/Requests/CreateUserRequestTest.php` - User creation validation
- `tests/Feature/Requests/StoreUserRequestTest.php` - Store user validation
- `tests/Feature/Requests/StoreUserInviteRequestTest.php` - Invite validation
- `tests/Feature/Requests/ProfileUpdateRequestTest.php` - Profile update validation
- `tests/Feature/Requests/DealershipCreateRequestTest.php` - Dealership creation validation
- `tests/Feature/Requests/Dealer/StoreUserRequestTest.php` - Dealer store user validation
- `tests/Feature/Requests/Dealer/Vendor/QuestionnaireRequestTest.php` - Vendor questionnaire validation
- `tests/Feature/Requests/VendorFormRequestTest.php` - Vendor form validation

---

## 10. Middleware (Feature Tests)

- ~~`tests/Feature/StoreMiddlewareTest.php` - Store middleware~~
- `tests/Feature/Middleware/SecurityHeadersMiddlewareTest.php` - Security headers applied to all responses
- `tests/Feature/Middleware/ImpersonationMiddlewareTest.php` - Impersonation state management in session
- `tests/Feature/Middleware/LocalizationMiddlewareTest.php` - Locale is set from route/session
- `tests/Feature/Middleware/CheckStoreStatusMiddlewareTest.php` - Inactive stores redirect/block
- `tests/Feature/Middleware/SingleStoreMiddlewareTest.php` - Single store context enforced
- `tests/Feature/Middleware/StoreAccessMiddlewareTest.php` - Users can only access their assigned stores
- `tests/Feature/Middleware/StoreIdentifierMiddlewareTest.php` - Store identifier resolved from request

---

## 11. Services (Unit / Feature Tests)

- `tests/Unit/Services/UserCourseServiceTest.php` - Course assignment logic, caching, role/department based assignment, overrides, California rules
- `tests/Unit/Services/ReminderServiceTest.php` - Reminder scheduling, frequency, preferences
- `tests/Unit/Services/CyrismaServiceTest.php` - Cyrisma API calls (mock HTTP)
- `tests/Unit/Services/GoPhishServiceTest.php` - GoPhish API integration (mock HTTP)
- `tests/Unit/Services/VimeoServiceTest.php` - Vimeo API integration (mock HTTP)

---

## 12. Traits (Unit Tests)

- `tests/Unit/Traits/BodyShopGenerateRatingTest.php` - Rating algorithm for body shop audits
- `tests/Unit/Traits/DealJacketGenerateRatingTest.php` - Rating algorithm for deal jackets
- `tests/Unit/Traits/GlbaGenerateRatingTest.php` - Rating algorithm for GLBA audits
- `tests/Unit/Traits/OshaGenerateRatingTest.php` - Rating algorithm for OSHA audits
- `tests/Unit/Traits/HasGradeTest.php` - Grading logic (letter grades from percentages)
- `tests/Unit/Traits/HasCourseStatusTest.php` - Course completion status logic
- `tests/Unit/Traits/EmployeeCoursesTest.php` - Employee course assignment logic
- `tests/Unit/Traits/HasAuditStatsTest.php` - Audit statistics calculations

---

## 13. Observers (Feature Tests)

- `tests/Feature/Observers/CourseResultsObserverTest.php` - Side effects on course result create/update
- `tests/Feature/Observers/DealJacketGroupObserverTest.php` - Side effects on group create/update/delete
- `tests/Feature/Observers/DealJacketObserverTest.php` - Side effects on deal jacket events
- `tests/Feature/Observers/UserObserverTest.php` - Side effects on user create/update/delete (slug generation, course assignment, etc.)

---

## 14. Notifications (Unit Tests)

- `tests/Unit/Notifications/ContractNotificationTest.php` - Contract notification content and channels
- `tests/Unit/Notifications/ContractPdfNotificationTest.php` - PDF attachment
- `tests/Unit/Notifications/ContractSignedNotificationTest.php` - Signed notification
- `tests/Unit/Notifications/CourseExpiredNotificationTest.php` - Expired course notification
- `tests/Unit/Notifications/CourseExpiringSoonNotificationTest.php` - Expiring soon notification
- `tests/Unit/Notifications/DealerUserInviteNotificationTest.php` - Dealer invite email
- `tests/Unit/Notifications/ExpiredCourseNotificationTest.php` - Expired course content
- `tests/Unit/Notifications/IncompleteCoursesNotificationTest.php` - Incomplete courses email
- `tests/Unit/Notifications/InitialRemediationReminderNotificationTest.php` - Initial remediation
- `tests/Unit/Notifications/NewCourseNotificationTest.php` - New course available
- `tests/Unit/Notifications/NewDealershipNotificationTest.php` - New dealership created
- `tests/Unit/Notifications/RemediationReminderNotificationTest.php` - Remediation reminder
- `tests/Unit/Notifications/SendContractPdfNotificationTest.php` - Send contract PDF
- `tests/Unit/Notifications/UserInviteNotificationTest.php` - User invite email
- `tests/Unit/Notifications/VendorFormNotificationTest.php` - Vendor form submission
- `tests/Unit/Notifications/VendorSignedNotificationTest.php` - Vendor signed notification

---

## 15. Mail (Feature Tests)

- `tests/Feature/Mail/ComplianceFormMailTest.php` - Compliance form email content and attachments
- `tests/Feature/Mail/CourseNotificationMailTest.php` - Course notification email
- `tests/Feature/Mail/CourseResetNotificationMailTest.php` - Course reset email
- `tests/Feature/Mail/InviteMailTest.php` - Invite email
- `tests/Feature/Mail/RedSentryErrorNotificationTest.php` - Error notification email
- `tests/Feature/Mail/RemediationReminderMailTest.php` - Remediation reminder email
- `tests/Feature/Mail/SendInviteMailTest.php` - Send invite email
- `tests/Feature/Mail/TenDayOpenInviteReminderMailTest.php` - 10-day reminder
- `tests/Feature/Mail/TwentyDayOpenInviteReminderMailTest.php` - 20-day reminder

---

## 16. Jobs (Unit / Feature Tests)

### 16a. Audit PDF Jobs

- ~~`tests/Unit/Jobs/Audit/GenerateBodyShopPdfJobTest.php` - Body shop PDF generation~~
- ~~`tests/Unit/Jobs/Audit/GenerateGlbaPdfJobTest.php` - GLBA PDF generation~~
- ~~`tests/Unit/Jobs/Audit/GenerateOshaPdfJobTest.php` - OSHA PDF generation~~
- `tests/Unit/Jobs/Audit/GenerateBodyShopRemediationPdfJobTest.php` - Body shop remediation PDF
- `tests/Unit/Jobs/Audit/GenerateGlbaRemediationPdfJobTest.php` - GLBA remediation PDF
- `tests/Unit/Jobs/Audit/GenerateOshaRemediationPdfJobTest.php` - OSHA remediation PDF
- `tests/Unit/Jobs/Audit/GenerateDealJacketReportJobTest.php` - Deal jacket report generation
- `tests/Unit/Jobs/Audit/UploadBodyShopPdfJobTest.php` - Upload body shop to storage
- `tests/Unit/Jobs/Audit/UploadGlbaPdfJobTest.php` - Upload GLBA to storage
- `tests/Unit/Jobs/Audit/UploadOshaPdfJobTest.php` - Upload OSHA to storage

### 16b. Audit Upload Jobs

- `tests/Unit/Jobs/UploadAuditImagesJobTest.php` - Upload audit images
- `tests/Unit/Jobs/UploadAuditToDigitalOceanJobTest.php` - Upload to DO spaces
- `tests/Unit/Jobs/UploadBodyShopAuditToDigitalOceanJobTest.php` - Body shop upload
- `tests/Unit/Jobs/UploadFinanceAuditImagesJobTest.php` - Finance audit images
- `tests/Unit/Jobs/UploadIndividualAuditToDigitalOceanJobTest.php` - Individual audit upload
- `tests/Unit/Jobs/UploadOshaAuditToDigitalOceanJobTest.php` - OSHA upload
- `tests/Unit/Jobs/GenerateAuditPdfJobTest.php` - Generic audit PDF
- `tests/Unit/Jobs/GenerateBodyShopAuditPdfJobTest.php` - Body shop PDF
- `tests/Unit/Jobs/GenerateIndividualAuditPdfJobTest.php` - Individual audit PDF
- `tests/Unit/Jobs/GenerateOshaAuditJobTest.php` - OSHA audit PDF

### 16c. Manual Jobs

- `tests/Unit/Jobs/Manuals/GenerateCmsManualJobTest.php` - CMS manual PDF generation
- `tests/Unit/Jobs/Manuals/GenerateIspManualJobTest.php` - ISP manual PDF
- `tests/Unit/Jobs/Manuals/GenerateOshaManualJobTest.php` - OSHA manual PDF
- `tests/Unit/Jobs/Manuals/GenerateRedFlagManualJobTest.php` - Red Flag manual PDF
- `tests/Unit/Jobs/Manuals/UploadCmsToDigitalOceanJobTest.php` - CMS upload
- `tests/Unit/Jobs/Manuals/UploadIspToDigitalOceanJobTest.php` - ISP upload
- `tests/Unit/Jobs/Manuals/UploadOshaToDigitalOceanJobTest.php` - OSHA upload
- `tests/Unit/Jobs/Manuals/UploadRedFlagToDigitalOceanJobTest.php` - Red Flag upload

### 16d. Contract Jobs

- `tests/Unit/Jobs/Contracts/GeneratePdfJobTest.php` - Contract PDF generation
- `tests/Unit/Jobs/Contracts/UploadToDigitalOceanJobTest.php` - Contract upload

### 16e. Other Jobs

- `tests/Unit/Jobs/ComplianceInfoDownloadJobTest.php` - Compliance download
- `tests/Unit/Jobs/CreateFrameworkDirectoriesForTenantJobTest.php` - Tenant directory provisioning
- `tests/Unit/Jobs/DownloadVendorPdfJobTest.php` - Vendor PDF download
- `tests/Unit/Jobs/ImportEmployeesJobTest.php` - Employee CSV import, validation, error handling
- `tests/Unit/Jobs/IncompleteVendorNotificationJobTest.php` - Incomplete vendor email
- `tests/Unit/Jobs/RedSentryReportGenerationJobTest.php` - RedSentry report
- `tests/Unit/Jobs/RemediationReminderEmailJobTest.php` - Remediation reminder dispatch
- `tests/Unit/Jobs/SendCoursesResetNotificationsTest.php` - Course reset notifications
- `tests/Unit/Jobs/SendQueueEmailJobTest.php` - Generic queued email
- `tests/Unit/Jobs/SendVendorEmailJobTest.php` - Vendor email dispatch

---

## 17. Console Commands (Feature Tests)

- `tests/Feature/Commands/CourseExpiringEmailCommandTest.php` - Sends expiring course emails
- `tests/Feature/Commands/CourseReminderCommandTest.php` - Sends course reminders
- `tests/Feature/Commands/CourseYearsExpireCommandTest.php` - Expires courses past threshold
- `tests/Feature/Commands/EmployeeCourseReminderCommandTest.php` - Employee-specific reminders
- `tests/Feature/Commands/NewCourseNotificationCommandTest.php` - New course notification dispatch
- `tests/Feature/Commands/RemediationReminderCommandTest.php` - Remediation reminders
- ~~`tests/Feature/Tenant/SendCourseNotificationToTenantCommandTest.php` - Course notifications to tenant~~
- `tests/Feature/Commands/RunInvitesCommandTest.php` - Processes pending invitations
- `tests/Feature/Commands/SendVendorNotificationCommandTest.php` - Vendor notification dispatch
- `tests/Feature/Commands/DeleteTemporaryUploadsCommandTest.php` - Cleans temp files
- `tests/Feature/Commands/ClearLivewireTempFilesCommandTest.php` - Clears Livewire temp
- `tests/Feature/Commands/ImportSdsCommandTest.php` - SDS import
- `tests/Feature/Commands/RevertCourseResetCommandTest.php` - Course reset revert
- `tests/Feature/Commands/CleanupOldDealJacketReportsCommandTest.php` - Old report cleanup
- `tests/Feature/Commands/CreateUpdateGoPhishUserGroupsCommandTest.php` - GoPhish sync
- `tests/Feature/Commands/CreateUpdateGoPhishDepartmentUserGroupsCommandTest.php` - GoPhish dept sync
- `tests/Feature/Commands/ReportTenantSizeCommandTest.php` - Tenant size reporting
- `tests/Feature/Commands/BackupCommandTest.php` - Backup creation
- `tests/Feature/Commands/BackupCleanupCommandTest.php` - Backup cleanup

---

## 18. Livewire Components (Feature Tests)

### 18a. Central Livewire Components

- `tests/Feature/Central/Livewire/Dashboard/IndexTest.php` - Central dashboard render, stats
- `tests/Feature/Central/Livewire/Contracts/IndexTest.php` - Contract listing, search, pagination
- `tests/Feature/Central/Livewire/Contracts/ActivityTest.php` - Contract activity log
- `tests/Feature/Central/Livewire/Contracts/CreateTest.php` - Contract creation form
- `tests/Feature/Central/Livewire/Contracts/EditTest.php` - Contract editing
- `tests/Feature/Central/Livewire/CourseManagement/IndexTest.php` - Course management listing
- `tests/Feature/Central/Livewire/CourseManagement/EditTest.php` - Course editing
- `tests/Feature/Central/Livewire/CourseManagement/QuizTest.php` - Quiz management
- `tests/Feature/Central/Livewire/Courses/IndexTest.php` - Central courses listing
- `tests/Feature/Central/Livewire/Courses/ShowTest.php` - Course detail view
- `tests/Feature/Central/Livewire/Courses/QuizTest.php` - Quiz taking
- `tests/Feature/Central/Livewire/Employees/IndexTest.php` - Employee listing
- `tests/Feature/Central/Livewire/Employees/DeletedTest.php` - Deleted employees
- `tests/Feature/Central/Livewire/Dealerships/IndexTest.php` - Dealership listing
- `tests/Feature/Central/Livewire/Dealerships/CreateTest.php` - Dealership creation
- `tests/Feature/Central/Livewire/Docs/IndexTest.php` - Documents listing
- `tests/Feature/Central/Livewire/Docs/CreateTest.php` - Document creation
- `tests/Feature/Central/Livewire/Sds/IndexTest.php` - SDS listing and search
- `tests/Feature/Central/Livewire/Sds/CreateTest.php` - SDS creation
- `tests/Feature/Central/Livewire/Sds/EditTest.php` - SDS editing
- `tests/Feature/Central/Livewire/SharedDocs/IndexTest.php` - Shared docs listing
- `tests/Feature/Central/Livewire/Logs/IndexTest.php` - Central logs

### 18b. Central Audit Statement Components

- ~~`tests/Feature/Central/AuditStatements/BodyShopViolationStatementsTest.php` - Body shop violations~~
- ~~`tests/Feature/Central/AuditStatements/GlbaViolationStatementsTest.php` - GLBA violations~~
- ~~`tests/Feature/Central/AuditStatements/OshaViolationStatementsTest.php` - OSHA violations~~

### 18c. Tenant / Dealer Dashboard

- ~~`tests/Feature/Tenant/DashboardTest.php` - Tenant dashboard~~
- `tests/Feature/Tenant/Livewire/Home/DealJacketChartTest.php` - Dashboard deal jacket chart
- `tests/Feature/Tenant/Livewire/Home/StoreListItemTest.php` - Store list on dashboard

### 18d. Dealer Course Components

- ~~`tests/Feature/Tenant/Course/IndexTest.php` - Course index~~
- ~~`tests/Feature/Tenant/Course/IndexItemTest.php` - Course index items~~
- ~~`tests/Feature/Tenant/Course/CourseAssignmentTest.php` - Course assignment~~
- ~~`tests/Feature/Tenant/Course/CourseReminderCommandsTest.php` - Course reminder commands~~
- ~~`tests/Feature/Tenant/Course/ResetTest.php` - Course resets~~
- `tests/Feature/Tenant/Livewire/Course/AllTest.php` - All courses view
- `tests/Feature/Tenant/Livewire/Course/QuizTest.php` - Dealer quiz taking, submission, pass/fail
- `tests/Feature/Tenant/Livewire/Course/EditTest.php` - Course editing (dealer admin)

### 18e. Dealer Employee Components

- `tests/Feature/Tenant/Livewire/Employee/IndexTest.php` - Employee listing, search, filter
- `tests/Feature/Tenant/Livewire/Employee/ShowTest.php` - Employee detail view
- `tests/Feature/Tenant/Livewire/Employee/DetailsTest.php` - Employee details component
- `tests/Feature/Tenant/Livewire/Employee/CreateTest.php` - Employee creation
- `tests/Feature/Tenant/Livewire/Employee/DeletedIndexItemTest.php` - Deleted employee restore
- `tests/Feature/Tenant/Livewire/Employee/CertIndexTest.php` - Certificate listing
- ~~`tests/Feature/Tenant/Dealer/Employee/InviteModalsTest.php` - Invite modals~~
- `tests/Feature/Tenant/Livewire/Employee/OpenInvitesTest.php` - Open invite listing
- ~~`tests/Feature/Tenant/Employee/CourseResultsTest.php` - Course results~~

### 18f. Dealer Audit Components - Body Shop

- `tests/Feature/Tenant/Livewire/Audit/BodyShop/IndexTest.php` - Body shop audit listing
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/CreateTest.php` - Body shop audit creation
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/ShowTest.php` - Body shop audit detail
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/EditTest.php` - Body shop audit editing
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/RemediationTest.php` - Body shop remediation view
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/CompleteRemediationModalTest.php` - Complete remediation
- `tests/Feature/Tenant/Livewire/Audit/BodyShop/GenerateRemediationButtonTest.php` - Generate remediation PDF

### 18g. Dealer Audit Components - Finance / GLBA

- `tests/Feature/Tenant/Livewire/Audit/Finance/IndexTest.php` - Finance audit listing
- `tests/Feature/Tenant/Livewire/Audit/Finance/CreateTest.php` - Finance audit creation
- `tests/Feature/Tenant/Livewire/Audit/Finance/ShowTest.php` - Finance audit detail
- `tests/Feature/Tenant/Livewire/Audit/Finance/EditTest.php` - Finance audit editing
- `tests/Feature/Tenant/Livewire/Audit/Finance/RemediationTest.php` - Finance remediation
- `tests/Feature/Tenant/Livewire/Audit/Finance/CompleteRemediationModalTest.php` - Complete remediation
- `tests/Feature/Tenant/Livewire/Audit/Finance/GenerateRemediationButtonTest.php` - Generate remediation PDF

### 18h. Dealer Audit Components - OSHA

- `tests/Feature/Tenant/Livewire/Audit/Osha/IndexTest.php` - OSHA audit listing
- `tests/Feature/Tenant/Livewire/Audit/Osha/CreateTest.php` - OSHA audit creation
- `tests/Feature/Tenant/Livewire/Audit/Osha/ShowTest.php` - OSHA audit detail
- `tests/Feature/Tenant/Livewire/Audit/Osha/EditTest.php` - OSHA audit editing
- `tests/Feature/Tenant/Livewire/Audit/Osha/RemediationTest.php` - OSHA remediation view
- `tests/Feature/Tenant/Livewire/Audit/Osha/CompleteRemediationModalTest.php` - Complete remediation
- `tests/Feature/Tenant/Livewire/Audit/Osha/GenerateRemediationButtonTest.php` - Generate remediation PDF

### 18i. Dealer Audit Components - Deal Jacket

- ~~`tests/Feature/Tenant/Audits/DealJacket/GenerateDealJacketReportTest.php` - Report generation~~
- ~~`tests/Feature/Tenant/Audits/DealJacket/GroupIndexTest.php` - Group listing~~
- ~~`tests/Feature/Tenant/Audits/DealJacket/GroupShowTest.php` - Group detail~~
- ~~`tests/Feature/Tenant/Audits/DealJacket/IndividualDealJacketTest.php` - Individual jacket~~
- `tests/Feature/Tenant/Livewire/Audit/DealJacket/CreateTest.php` - Deal jacket creation
- `tests/Feature/Tenant/Livewire/Audit/DealJacket/EditTest.php` - Deal jacket editing
- `tests/Feature/Tenant/Livewire/Audit/DealJacket/CommonIssuesChartTest.php` - Chart data
- `tests/Feature/Tenant/Livewire/Audit/DealJacket/PassRateTrendChartTest.php` - Trend data
- `tests/Feature/Tenant/Livewire/Audit/DealJacket/TotalsProgressBarTest.php` - Progress bar

### 18j. Dealer Audit Components - Individual (Archived)

- `tests/Feature/Tenant/Livewire/Audit/Individual/IndexTest.php` - Individual audit listing
- `tests/Feature/Tenant/Livewire/Audit/Individual/CreateTest.php` - Individual audit creation
- `tests/Feature/Tenant/Livewire/Audit/Individual/ShowTest.php` - Individual audit detail
- `tests/Feature/Tenant/Livewire/Audit/Individual/EditTest.php` - Individual audit editing
- `tests/Feature/Tenant/Livewire/Audit/Individual/DeleteTest.php` - Individual audit deletion

### 18k. Dealer Vendor Components

- ~~`tests/Feature/Tenant/Dealer/Vendor/NewFormTest.php` - Vendor form~~
- ~~`tests/Feature/Tenant/Dealer/Vendor/DownloadTest.php` - Vendor download~~
- `tests/Feature/Tenant/Livewire/Vendor/IndexTest.php` - Vendor listing
- `tests/Feature/Tenant/Livewire/Vendor/FormTest.php` - Vendor questionnaire form

### 18l. Dealer Manual Components

- `tests/Feature/Tenant/Livewire/Manual/Cms/IndexTest.php` - CMS manual listing
- `tests/Feature/Tenant/Livewire/Manual/Cms/CreateTest.php` - CMS manual creation
- `tests/Feature/Tenant/Livewire/Manual/Isp/IndexTest.php` - ISP manual listing
- `tests/Feature/Tenant/Livewire/Manual/Isp/CreateTest.php` - ISP manual creation
- `tests/Feature/Tenant/Livewire/Manual/Osha/IndexTest.php` - OSHA manual listing
- `tests/Feature/Tenant/Livewire/Manual/Osha/CreateTest.php` - OSHA manual creation
- `tests/Feature/Tenant/Livewire/Manual/RedFlag/IndexTest.php` - Red Flag manual listing
- `tests/Feature/Tenant/Livewire/Manual/RedFlag/CreateTest.php` - Red Flag manual creation

### 18m. Dealer Phishing Components

- `tests/Feature/Tenant/Livewire/Phish/IndexTest.php` - Phishing campaign listing
- `tests/Feature/Tenant/Livewire/Phish/CreateTest.php` - Campaign creation
- `tests/Feature/Tenant/Livewire/Phish/ShowTest.php` - Campaign detail/results

### 18n. Dealer Scan Components

- ~~`tests/Feature/Tenant/Scans/IndexTest.php` - Scan index~~
- ~~`tests/Feature/Tenant/Scans/Components/OpenPortsTest.php` - Open ports~~
- `tests/Feature/Tenant/Livewire/Scan/CyrismaIndexTest.php` - Cyrisma scan listing
- `tests/Feature/Tenant/Livewire/Scan/CyrismaSettingsTest.php` - Cyrisma settings
- `tests/Feature/Tenant/Livewire/Scan/RidgebackIndexTest.php` - Ridgeback scan listing

### 18o. Dealer Document Components

- `tests/Feature/Tenant/Livewire/Docs/IndexTest.php` - Tenant document listing
- `tests/Feature/Tenant/Livewire/Sds/IndexTest.php` - Tenant SDS listing

### 18p. Dealer Settings Components

- `tests/Feature/Tenant/Livewire/Settings/GlobalSettingsTest.php` - Global settings management
- `tests/Feature/Tenant/Livewire/Settings/StoreSettingsTest.php` - Store settings management
- `tests/Feature/Tenant/Livewire/Settings/EmailSettingsTest.php` - Email configuration

### 18q. Dealer Store Components

- ~~`tests/Feature/Tenant/StoreSwitcherTest.php` - Store switcher~~
- `tests/Feature/Tenant/Livewire/Store/HomeTest.php` - Store home page
- `tests/Feature/Tenant/Livewire/Store/EditTest.php` - Store editing
- `tests/Feature/Tenant/Livewire/Store/SettingsTest.php` - Store settings page
- `tests/Feature/Tenant/Livewire/Navigation/ManagerStoresTest.php` - Manager store nav
- `tests/Feature/Tenant/Livewire/Navigation/StoreSwitcherTest.php` - Store switching component
- `tests/Feature/Tenant/Livewire/Layout/CurrentStoreNameTest.php` - Current store display

### 18r. Dealer Fit Test Components

- `tests/Feature/Tenant/Livewire/FitTest/IndexTest.php` - Fit test listing
- `tests/Feature/Tenant/Livewire/FitTest/DeleteTest.php` - Fit test deletion

### 18s. Global Video Components

- `tests/Feature/Tenant/Livewire/Video/IndexTest.php` - Video listing
- `tests/Feature/Tenant/Livewire/Video/ShowTest.php` - Video detail/player

### 18t. Dealer Log Components

- ~~`tests/Feature/Tenant/LogIndexComponentTest.php` - Log index component~~
- ~~`tests/Feature/Tenant/LogsIndexTest.php` - Logs index page~~
- `tests/Feature/Tenant/Livewire/Log/ShowTest.php` - Log detail view

---

## 19. Controllers (Feature Tests)

### 19a. Central Controllers

- `tests/Feature/Central/Controllers/Course/ShowControllerTest.php` - Course show endpoint
- `tests/Feature/Central/Controllers/Course/CourseResultsControllerTest.php` - Course results
- `tests/Feature/Central/Controllers/Course/QuizControllerTest.php` - Quiz submission
- `tests/Feature/Central/Controllers/DealerDocs/IndexControllerTest.php` - Dealer docs listing
- `tests/Feature/Central/Controllers/DealerDocs/CreateControllerTest.php` - Create dealer doc
- `tests/Feature/Central/Controllers/DealerDocs/EditControllerTest.php` - Edit dealer doc
- `tests/Feature/Central/Controllers/Dealership/CreateControllerTest.php` - Create dealership
- `tests/Feature/Central/Controllers/Employee/CreateControllerTest.php` - Create employee
- `tests/Feature/Central/Controllers/Employee/ShowControllerTest.php` - Show employee
- `tests/Feature/Central/Controllers/Employee/RegisterControllerTest.php` - Employee registration
- `tests/Feature/Central/Controllers/Employee/StoreControllerTest.php` - Store employee
- `tests/Feature/Central/Controllers/Employee/StoreRegistrationControllerTest.php` - Registration storage

### 19b. Tenant / Dealer Controllers

- `tests/Feature/Tenant/Controllers/CourseControllerTest.php` - Course show, edit
- `tests/Feature/Tenant/Controllers/CourseResultsControllerTest.php` - Course results store
- `tests/Feature/Tenant/Controllers/EmployeeIndexControllerTest.php` - Employee index
- `tests/Feature/Tenant/Controllers/ImpersonationControllerTest.php` - Start/stop impersonation
- `tests/Feature/Tenant/Controllers/ProfileControllerTest.php` - Dealer profile CRUD
- `tests/Feature/Tenant/Controllers/StoreControllerTest.php` - Store management
- `tests/Feature/Tenant/Controllers/UserControllerTest.php` - User management
- `tests/Feature/Tenant/Controllers/VendorControllerTest.php` - Vendor management
- `tests/Feature/Tenant/Controllers/Store/SettingsControllerTest.php` - Store settings
- `tests/Feature/Tenant/Controllers/Store/EmployeeControllerTest.php` - Store employees
- `tests/Feature/Tenant/Controllers/Store/StoreVendorControllerTest.php` - Store vendors

### 19c. Audit Controllers

- `tests/Feature/Tenant/Controllers/Audit/DealJacketControllerTest.php` - Deal jacket CRUD
- `tests/Feature/Tenant/Controllers/Audit/DealJacketGroupControllerTest.php` - Group management
- `tests/Feature/Tenant/Controllers/Audit/DealJacketReportDownloadTest.php` - Report downloads
- `tests/Feature/Tenant/Controllers/Audit/BodyShopCreateControllerTest.php` - Body shop creation
- `tests/Feature/Tenant/Controllers/Audit/FinanceControllerTest.php` - Finance audit CRUD
- `tests/Feature/Tenant/Controllers/Audit/FinanceCreateControllerTest.php` - Finance creation
- `tests/Feature/Tenant/Controllers/Audit/IndividualControllerTest.php` - Individual audit
- `tests/Feature/Tenant/Controllers/Audit/IndividualCreateControllerTest.php` - Individual creation
- `tests/Feature/Tenant/Controllers/Audit/OshaCreateControllerTest.php` - OSHA creation

### 19d. Manual Controllers

- `tests/Feature/Tenant/Controllers/Manual/IspControllerTest.php` - ISP manual
- `tests/Feature/Tenant/Controllers/Manual/OshaControllerTest.php` - OSHA manual
- `tests/Feature/Tenant/Controllers/Manual/RedFlagControllerTest.php` - Red Flag manual

### 19e. Other Controllers

- `tests/Feature/Tenant/Controllers/CyrismaControllerTest.php` - Cyrisma settings
- `tests/Feature/Tenant/Controllers/CyrismaReportControllerTest.php` - Cyrisma reports
- `tests/Feature/Tenant/Controllers/SdsControllerTest.php` - SDS view
- `tests/Feature/Central/Controllers/TenantLookupControllerTest.php` - Tenant lookup (dealer-login)

---

## 20. API Endpoints (Feature Tests)

- ~~`tests/Feature/MailgunWebhookTest.php` - Mailgun webhook processing~~
- `tests/Feature/API/AuthControllerTest.php` - API authentication (Sanctum)
- `tests/Feature/API/DealerListControllerTest.php` - Dealer list API endpoint
- `tests/Feature/Webhooks/GoPhishWebhookTest.php` - GoPhish webhook processing

---

## 21. Repositories (Unit Tests)

- `tests/Unit/Repositories/CentralUserInviteRepositoryTest.php` - Invite creation, validation
- `tests/Unit/Repositories/CentralUserInviteRegisterRepositoryTest.php` - Registration from invite

---

## 22. Listener (Unit Tests)

- `tests/Unit/Listeners/LogSentMessageTest.php` - Logs sent email messages

---

## 23. Role-Based Access Control (Feature Tests)

- ~~`tests/Feature/Tenant/Authorization/SuperAdminAccessTest.php` - Super admin can access all tenant routes~~
- ~~`tests/Feature/Tenant/Authorization/ConsultantAccessTest.php` - Consultant access restrictions~~
- ~~`tests/Feature/Tenant/Authorization/AdminAccessTest.php` - Admin (dealer admin) access within tenant~~
- ~~`tests/Feature/Tenant/Authorization/ManagerAccessTest.php` - Manager access (store-scoped)~~
- ~~`tests/Feature/Tenant/Authorization/QIAccessTest.php` - QI (Qualified Individual) access~~
- ~~`tests/Feature/Tenant/Authorization/EmployeeAccessTest.php` - Employee access (most restricted)~~
- ~~`tests/Feature/Tenant/Authorization/GuestAccessTest.php` - Unauthenticated user redirects and public routes~~
- ~~`tests/Feature/Tenant/Authorization/StoreAccessControlTest.php` - Store assignment scoping for all roles~~
- ~~`tests/Feature/Central/Authorization/CentralRouteAccessTest.php` - Central route access by all roles~~

---

## 24. Multi-Store Context (Feature Tests)

- `tests/Feature/Tenant/MultiStore/StoreContextTest.php` - Store context resolves correctly, data scoped to store
- ~~`tests/Feature/Tenant/MultiStore/StoreAccessTest.php` - Users cannot access stores they aren't assigned to (covered by StoreAccessControlTest)~~
- `tests/Feature/Tenant/MultiStore/SingleStoreViewTest.php` - Single store sub-routes render within store context
- ~~`tests/Feature/Tenant/DepartmentCompletionStatsTest.php` - Department completion stats~~

---

## 25. Vendor Email Logging (Feature Tests)

- ~~`tests/Feature/Tenant/VendorEmailLogTest.php` - Vendor email logging~~

---

## 26. Factories (Verification - tests that factories produce valid models)

- `tests/Unit/Factories/UserFactoryTest.php` - User factory creates valid users with states
- `tests/Unit/Factories/CourseFactoryTest.php` - Course factory
- `tests/Unit/Factories/ContractFactoryTest.php` - Contract factory
- `tests/Unit/Factories/SdsFactoryTest.php` - SDS factory
- `tests/Unit/Factories/SharedDocumentFactoryTest.php` - Shared document factory
- `tests/Unit/Factories/DealJacketFactoryTest.php` - Deal jacket factory
- `tests/Unit/Factories/DealJacketGroupFactoryTest.php` - Deal jacket group factory
- `tests/Unit/Factories/OshaQuestionsFactoryTest.php` - OSHA questions factory

---

## Summary

| Category | Existing | Needed | Total |
|---|---|---|---|
| Auth (Central) | 6 | 0 | 6 |
| Auth (Tenant) | 5 | 0 | 5 |
| Profile | 1 | 1 | 2 |
| Multi-Tenancy | 1 | 6 | 7 |
| Models (Unit) | 0 | 56 | 56 |
| Enums (Unit) | 0 | 10 | 10 |
| Casts (Unit) | 0 | 1 | 1 |
| Policies | 0 | 4 | 4 |
| Form Requests | 0 | 10 | 10 |
| Middleware | 1 | 7 | 8 |
| Services | 0 | 5 | 5 |
| Traits | 0 | 8 | 8 |
| Observers | 0 | 4 | 4 |
| Notifications | 0 | 16 | 16 |
| Mail | 0 | 9 | 9 |
| Jobs | 3 | 37 | 40 |
| Console Commands | 1 | 18 | 19 |
| Livewire Components | 17 | 89 | 106 |
| Controllers | 0 | 35 | 35 |
| API Endpoints | 1 | 3 | 4 |
| Repositories | 0 | 2 | 2 |
| Listeners | 0 | 1 | 1 |
| RBAC | 9 | 0 | 9 |
| Multi-Store | 2 | 2 | 4 |
| Vendor Email Log | 1 | 0 | 1 |
| Factories | 0 | 8 | 8 |
| **TOTAL** | **48** | **332** | **380** |

### Priority Order for Implementation

1. ~~**RBAC / Authorization** - Critical for a multi-tenant app; ensures users cannot access other tenants' or stores' data~~
2. ~~**Tenant Auth** - Dealer-side authentication flows~~
3. **Policies** - Authorization gates for domain objects
4. **Middleware** - Security headers, store access, impersonation
5. **Form Requests** - Input validation at system boundaries
6. **Services** - Core business logic (UserCourseService, ReminderService)
7. **Traits** - Rating generation, grading, course status
8. **Observers** - Side effects on model events
9. **Livewire Components** - Audit CRUD, employee management, courses, vendors
10. **Controllers** - Route handler tests
11. **Jobs** - PDF generation, uploads, imports
12. **Commands** - Scheduled tasks, reminders, imports
13. **Mail / Notifications** - Email content and delivery
14. **Models** - Relationship and scope validation
15. **Enums / Casts / Factories** - Data integrity
