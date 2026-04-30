<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import SignaturePad from '@/components/manuals/SignaturePad.vue';
import isp from '@/routes/dealer/manual/isp';
import dealer from '@/routes/dealer/dealer';
import type { BreadcrumbItem } from '@/types';

type Defaults = {
    store_id: number;
    store_name: string;
    qualified_individual_name: string;
    qualified_individual_phone: string;
    owner_name: string;
    owner_phone: string;
    general_manager_name: string;
    general_manager_phone: string;
    service_manager_name: string;
    service_manager_phone: string;
    parts_manager_name: string;
    parts_manager_phone: string;
    body_shop_manager_name: string;
    body_shop_manager_phone: string;
    police_emergency_phone: string;
    police_non_emergency_phone: string;
    fire_emergency_phone: string;
    fire_non_emergency_phone: string;
    fire_alarm_type: string;
    burglar_alarm_type: string;
};

const props = defineProps<{
    defaults: Defaults;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'ISP Manuals', href: isp.index.url() },
    { title: 'Sign Manual', href: isp.create.url() },
];

const sections = [
    { id: 'elements', label: '8 Elements Dealerships Must Comply With' },
    { id: 'objectives', label: 'ISP Objectives' },
    { id: 'handling', label: 'Handling and Processing Customer NPI' },
    { id: 'incident', label: 'Incident Response Plan' },
    { id: 'breach', label: 'Data Breach Guidelines' },
    { id: 'storage', label: 'Information Storage IT Safeguards Cyber Security' },
    { id: 'disposal', label: 'Disposal of Consumer Information and Records' },
    { id: 'processing', label: 'Processing Customer NPI by Department' },
    { id: 'sales', label: '— Sales', indent: true },
    { id: 'fi', label: '— F&I', indent: true },
    { id: 'service', label: '— Service', indent: true },
    { id: 'parts', label: '— Parts', indent: true },
    { id: 'accounting', label: '— Accounting', indent: true },
    { id: 'cashier', label: '— Cashier', indent: true },
    { id: 'body', label: '— Body Shop', indent: true },
    { id: 'personnel', label: 'Dealership Personnel' },
    { id: 'third', label: 'Third Party Providers' },
    { id: 'records', label: 'Record Retention List' },
    { id: 'form', label: 'Signature' },
];

const activeId = ref<string | null>(null);
const contentRef = ref<HTMLElement | null>(null);
let observer: IntersectionObserver | null = null;

onMounted(() => {
    const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
    const root = (isDesktop ? contentRef.value : null) as Element | null;

    observer = new IntersectionObserver(
        (entries) => {
            const visible = entries
                .filter((entry) => entry.isIntersecting)
                .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
            if (visible) {
                activeId.value = visible.target.id;
            }
        },
        {
            root,
            rootMargin: '-30% 0px -55% 0px',
            threshold: [0, 0.25, 0.5, 1],
        },
    );

    sections.forEach((section) => {
        const element = document.getElementById(section.id);
        if (element) {
            observer?.observe(element);
        }
    });
});

onBeforeUnmount(() => {
    observer?.disconnect();
    observer = null;
});

const scrollToSection = (event: MouseEvent, id: string): void => {
    event.preventDefault();
    const target = document.getElementById(id);
    if (!target) {
        return;
    }
    const container = contentRef.value;
    if (container && window.matchMedia('(min-width: 1024px)').matches) {
        container.scrollTo({
            top: target.offsetTop - container.offsetTop - 12,
            behavior: 'smooth',
        });
    } else {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    activeId.value = id;
};

const form = useForm({
    signature: null as string | null,
});

const canSubmit = computed(() => form.signature !== null && !form.processing);

const submit = (): void => {
    form.post(isp.store.url(), {
        preserveScroll: true,
        onError: () => {
            scrollToSection(new MouseEvent('click'), 'form');
        },
    });
};

const qi = computed(() => props.defaults.qualified_individual_name);
const qip = computed(() => props.defaults.qualified_individual_phone);
const owner = computed(() => props.defaults.owner_name);
const ownerp = computed(() => props.defaults.owner_phone);
const gm = computed(() => props.defaults.general_manager_name);
const gmp = computed(() => props.defaults.general_manager_phone);
const sm = computed(() => props.defaults.service_manager_name);
const smp = computed(() => props.defaults.service_manager_phone);
const pm = computed(() => props.defaults.parts_manager_name);
const pmp = computed(() => props.defaults.parts_manager_phone);
const bsm = computed(() => props.defaults.body_shop_manager_name);
const bsmp = computed(() => props.defaults.body_shop_manager_phone);
const pepn = computed(() => props.defaults.police_emergency_phone);
const pnepn = computed(() => props.defaults.police_non_emergency_phone);
const fepn = computed(() => props.defaults.fire_emergency_phone);
const fnepn = computed(() => props.defaults.fire_non_emergency_phone);
const storeName = computed(() => props.defaults.store_name);
</script>

<template>
    <Head title="Sign ISP Manual" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
<div
                class="relative grid gap-8 lg:grid-cols-[16rem_minmax(0,1fr)] lg:h-[calc(100vh-12rem)] lg:overflow-hidden"
            >
                <aside class="hidden lg:block lg:overflow-y-auto pr-4">
                    <nav>
                        <ul class="space-y-2 text-sm">
                            <li v-for="section in sections" :key="section.id" :class="section.indent ? 'pl-3' : ''">
                                <a
                                    :href="`#${section.id}`"
                                    class="block transition-colors hover:text-foreground"
                                    :class="activeId === section.id ? 'font-semibold text-primary' : 'text-muted-foreground'"
                                    @click="scrollToSection($event, section.id)"
                                >
                                    {{ section.label }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <div
                    ref="contentRef"
                    class="prose prose-sm dark:prose-invert min-w-0 max-w-none space-y-10 lg:overflow-y-auto lg:pr-4"
                >
                    <!-- Contact summary -->
                    <section class="not-prose grid gap-4 rounded-lg border bg-card p-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Qualified Individual</p>
                            <p class="text-sm font-medium text-foreground">{{ qi || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ qip }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Owner</p>
                            <p class="text-sm font-medium text-foreground">{{ owner || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ ownerp }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">General Manager</p>
                            <p class="text-sm font-medium text-foreground">{{ gm || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ gmp }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Service Manager</p>
                            <p class="text-sm font-medium text-foreground">{{ sm || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ smp }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Parts Manager</p>
                            <p class="text-sm font-medium text-foreground">{{ pm || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ pmp }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Body Shop Manager</p>
                            <p class="text-sm font-medium text-foreground">{{ bsm || '—' }}</p>
                            <p class="text-xs text-muted-foreground">{{ bsmp }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Police Emergency</p>
                            <p class="text-sm font-medium text-foreground">{{ pepn || '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Police Non-Emergency</p>
                            <p class="text-sm font-medium text-foreground">{{ pnepn || '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Fire Emergency</p>
                            <p class="text-sm font-medium text-foreground">{{ fepn || '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">Fire Non-Emergency</p>
                            <p class="text-sm font-medium text-foreground">{{ fnepn || '—' }}</p>
                        </div>
                    </section>

                    <p class="text-sm text-muted-foreground">
                        If any of the information above is outdated, please make adjustments in
                        <a class="underline" :href="dealer.settings.url()">settings</a>
                        before signing.
                    </p>

                    <!-- 8 Elements -->
                    <section id="elements">
                        <h1>Information Security Program (ISP)</h1>
                        <p>This document contains the ISP for {{ storeName }}, and is part of the
                            Compliance Management System for the Dealership. This information was
                            assembled with the help of Automotive Risk Management Partners, Inc. It
                            contains the process that {{ storeName }} follows to ensure compliance with
                            the Gramm Leach Bliley Act, Federal Trade Commission Safeguards Rule,
                            and the privacy and security of customer and dealership information.</p>
                        <p>All information provided includes all revisions to the Safeguards Rule that are to be
                            implemented by June 9th, 2023. There are 8 elements that dealerships must comply
                            with listed below and reviewed throughout this ISP manual.</p>
                        <ol>
                            <li>Designation of a Qualified Individual</li>
                            <li>Periodic Risk Assessments of dealership</li>
                            <li>Design and Implement safeguards for
                                <ul>
                                    <li>Access Control</li>
                                    <li>System Inventory</li>
                                    <li>Encryption</li>
                                    <li>Data Breach</li>
                                    <li>Secure development practices</li>
                                    <li>MFA – Multifactor Authentication</li>
                                    <li>Disposal Procedures</li>
                                    <li>Change management procedures</li>
                                    <li>Monitoring and Logging of Authorized User Activity</li>
                                </ul>
                            </li>
                            <li>Penetration Testing</li>
                            <li>Implement P&amp;P for personnel to implement your ISP</li>
                            <li>Oversee Service Providers</li>
                            <li>Draft Incident Response Plan</li>
                            <li>Prepare an annual report to board or equivalent</li>
                        </ol>
                        <h2>**Prepare an Annual Report to Board or Equivalent</h2>
                        <p>Your SQI (Single Qualified Individual, {{ qi }}) must prepare a written report annually to the Board or Equivalent to discuss the overall status of your ISP, compliance with the revised safeguards rule and material matter related to the company's ISP including Risk Assessment, Risk Management and control decisions, service provider arrangements, results of penetration testing, security events and violations along with responses to such events and violations, and recommended changes to the ISP. This is NOT required if dealer has records on fewer than 5,000 customers.</p>
                    </section>

                    <!-- ISP Objectives -->
                    <section id="objectives">
                        <h1>Information Security Program</h1>
                        <h2>Objectives</h2>
                        <p>The objective of this program is to establish the necessary policies and procedures for the handling of, use of, and safeguarding of consumer/customer information as required for compliance with the Gramm Leach Bliley Act.</p>
                        <p>Concerning this program, &ldquo;Non-Public Personal Information&rdquo; (NPI) shall mean any information about a customer/consumer of dealership which it receives about the customer/consumer, and can be directly attributed in any manner to a customer/consumer.</p>
                        <p>The objectives of the program are as follows:</p>
                        <ul>
                            <li>Ensure the security and confidentiality of all customers/consumers NPI and data, both electronically and physically.</li>
                            <li>Protect against reasonably anticipated threats or hazards, both internal and external, to the security and integrity of NPI that is maintained, handled and retained by dealership.</li>
                            <li>Protect against unauthorized use and disclosure of NPI that could result in harm or inconvenience to any customer of dealership and verify steps are taken to maintain current knowledge of security threats.</li>
                            <li>Maintain written proof of continued compliance with the established program.</li>
                        </ul>
                        <h2>Single Qualified Individual (Program Coordinator)</h2>
                        <p>The Safeguards Rule requires the appointment of a &ldquo;Single Qualified Individual&rdquo; (SQI) who will be responsible for overseeing, implementing, and enforcing all aspects of your information security program to include the following:</p>
                        <ul>
                            <li>Enforce ISP policies and procedures.</li>
                            <li>Oversee and implementing periodic risk assessments.</li>
                            <li>Coordinate regular employee information security training.</li>
                            <li>Implementing mandatory safeguards and testing and auditing those safeguards.</li>
                            <li>Supervise service providers that handle customer information.</li>
                            <li>Designing and overseeing the drafting of a written incident response plan.</li>
                        </ul>
                        <p>The Qualified Individual assigned by {{ storeName }} will be {{ qi }} and shall report directly to a senior member of your dealership, and your board of directors if your business has a board.</p>
                    </section>

                    <!-- Handling and Processing Customer NPI -->
                    <section id="handling">
                        <h1>Safeguards Rule for Customer/Consumer NPI</h1>
                        <p><i>Handling and Processing Customer NPI:</i></p>
                        <ul>
                            <li>All employees are required to complete an <strong><i>information security awareness training program</i></strong> on the proper handling and safeguarding of customer information, and applicable laws and regulations. Records of employee training will be maintained electronically in the dealerships on-line dashboard.</li>
                            <li>At no time will any employee, independent contractor, or third party acting on behalf of the dealership allow customer information to be exposed to the risk of being lost, misplaced or stolen.</li>
                            <li>It shall be every employees' responsibility to ensure that all customer information will be handled, used, and stored securely, and in accord with the policies and procedures established in this ISP.</li>
                            <li>Customer information shall be transmitted or shared, internally or externally, only for legitimate business purposes.</li>
                            <li>Any sharing of customer/consumer information with any third party shall only be done with verified entities necessary to the transaction and that have been properly vetted for information security safeguards and compliance utilizing an individual service provider risk assessment.</li>
                            <li>Each employee that has a need to access the Dealership Management System, must have their own unique password for login.</li>
                            <li>Deal jackets may be obtained by management staff only.</li>
                            <li>All deal jackets that are being held by managers must be secured in locked filing cabinets when not in use.</li>
                            <li>Any program designed to capture e-mail addresses from customers such as drawings, giveaways, solicitations must be secured in locked receptacles.</li>
                            <li>At NO time are deal jackets to be left alone or unattended for any length of time.</li>
                            <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                            <li>All terminals or PCs with customer information must be placed in a position to hide sensitive information from others not directly involved with the transaction.</li>
                            <li>Each night at closing an inspection is to be performed by each department manager to ensure compliance.</li>
                            <li>All new employees will be trained in the Gramm-Leach-Bliley Act and Patriot Act requirements within 30 days of employment.</li>
                            <li>All computers that access the internet must have the newest version of an antivirus software installed and operating.</li>
                            <li>All customers are to be given a dealership Privacy Policy Notice at the beginning of each deal.</li>
                            <li>All Dealership employees shall comply with the Privacy Policy.</li>
                            <li>Faxing or emailing customer NPI may only be done with dealership equipment and through the dealership server, and only if secure protocols are in place.</li>
                            <li>Copies of driver licenses must be secured in a deal jacket or disposed of in a secure shredding receptacle.</li>
                            <li>Storage of customer information on personal devices is strictly forbidden.</li>
                            <li>All employees and third-party service providers are responsible for complying with dealerships program.</li>
                            <li>All employees and third-party service providers will sign a security, confidentiality and non-disclosure statement.</li>
                            <li>All information that is classified as customer or consumer NPI may only be accessed on a need-to-know basis.</li>
                            <li>Personnel shall not be permitted to copy, access, or use customer and consumer NPI for their own personal use or for any reason not authorized by employer.</li>
                            <li><strong>Enforcement</strong> - All persons who do not comply with dealerships Information Security Program shall be subject to disciplinary measures up to and including termination of employment for employees and termination of third-party providers that perform services for dealership.</li>
                        </ul>
                        <h2>Draft your Incident Response Plan</h2>
                        <p>Written plan, in advance, of what actions you will take in the event of a &ldquo;Security Event&rdquo; i.e., unauthorized access to or disruption or misuse of an information system, information stored on such system, or customer information held in physical form.</p>
                    </section>

                    <!-- Incident Response Plan -->
                    <section id="incident">
                        <h1>NPI Breach Response, Data Breach (Incident Response Plan)</h1>
                        <p>&quot;Breach of security&quot; or &quot;Data Breach&quot; means unauthorized access of personal information. Good faith access of personal information by an employee or agent of the dealership does not constitute a breach of security, provided that the information is not used for a purpose unrelated to the business or subject to further unauthorized use. In the event NPI is believed to have been breached:</p>
                        <ul>
                            <li><strong>{{ qi }}</strong> shall be notified immediately.</li>
                            <li>Management will be advised</li>
                            <li>The nature and extent of the breach shall be determined.</li>
                            <li>Determine whether there is a reasonable expectation of harm to any individuals as a result of the incident.</li>
                            <li>Determine the extent to which any breach has caused, or is likely to result in customer NPI being compromised.</li>
                            <li>Notify consumers/customers regarding details of the disclosure, the information likely to have been disclosed, the action taken to correct the breach and to secure the information, and the name address, email and phone number of the individual to contact regarding information concerning the breach where it is determined the individual may be adversely affected.</li>
                            <li><strong>[Provide notice to individuals and State departments pursuant to state law where needed]</strong></li>
                        </ul>
                    </section>

                    <!-- Data Breach Guidelines -->
                    <section id="breach">
                        <h1>Data Breach Guidelines</h1>
                        <h4>Safeguards Rule</h4>
                        <p>Requires financial institutions to notify the FTC of a security breach that affects at least 500 consumers as soon as possible, but no later than 30 days after discovery.</p>
                        <p>ONLINE REPORTING FORM:
                            <a href="https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form" target="_blank" rel="noopener">https://www.ftc.gov/business-guidance/privacy-security/gramm-leach-bliley-act/safeguards-rule-form</a>
                        </p>
                        <p>Now that the Safeguards Rule reporting requirement is in effect, what must businesses do? The amendment requires financial institutions to notify the FTC as soon as possible &ndash; and no later than 30 days after discovery &ndash; of a security breach involving the information of at least 500 consumers. Here's how the Rule defines an incident that triggers notification:</p>
                        <p>An acquisition of unencrypted customer information without the authorization of the individual to which the information pertains. Customer information is considered unencrypted for this purpose if the encryption key was accessed by an unauthorized person. Unauthorized acquisition will be presumed to include unauthorized access to unencrypted customer information unless you have reliable evidence showing that there has not been, or could not reasonably have been, unauthorized acquisition of such information.</p>
                        <h2>Prepare an Annual Report to Board or Equivalent</h2>
                        <p>Your SQI (Single Qualified Individual, {{ qi }}) must prepare a written report annually to the Board or Equivalent to discuss the overall status of your ISP, compliance with the revised safeguards rule and material matter related to the company's ISP including Risk Assessment, Risk Management and control decisions, service provider arrangements, results of penetration testing, security events and violations along with responses to such events and violations, and recommended changes to the ISP. This is NOT required if dealer has records on fewer than 5,000 customers.</p>
                    </section>

                    <!-- Storage / IT -->
                    <section id="storage">
                        <h1>Information Security Policies and Procedure - Information Storage IT Safeguards Cyber Security</h1>
                        <ul>
                            <li><strong>Access control</strong> where dealer must insure physical locks and physical data and password protection on all electronic data.</li>
                            <li><strong>Dealer must take inventory</strong> &ndash; Include all systems that are part of the business so that your dealership can locate all customer information it controls.</li>
                            <li>In rare instances where you develop your own software you are required to implement <strong>Secured Development Practices</strong> for apps that transmit, access or store customer information.</li>
                            <li>All systems must be password protected including DMS terminals as well as PC.</li>
                            <li>All system passwords will be set to expire no longer than 90 days from issue date.</li>
                            <li>Passwords are to be random alpha numeric combinations of 8 or more and cannot be identical to the user id or common words.</li>
                            <li>Passwords cannot be written or posted in the terminal area.</li>
                            <li>Passwords must be unique to the user and not shared among employees.</li>
                            <li>Users accessing the system must be sensitive to observers reading their password as they log on.</li>
                            <li>Screensavers must be installed on all PC's. They must be password protected with an interval not to exceed 5 minutes of inactivity.</li>
                            <li>Non-PC terminals must be logged off when unattended.</li>
                            <li>All media containing confidential customer information (disk drives, USB keys, etc.) must be secure.</li>
                            <li>All servers containing confidential customer information must be in a locked, limited access room.</li>
                            <li>All computer systems containing confidential customer information must not be exposed to any non-protected network sources including the internet, and third party networks.</li>
                            <li>Terminals and PCs should be turned off at the end of the day by the last user of that equipment.</li>
                            <li>Non-essential drives that access the system and can be used to add programs must be de-activated.</li>
                            <li>Computer screens should not be in public view if possible.</li>
                            <li>Confidential customer data must not be stored on PC, or personal devices.</li>
                            <li>A physical inventory of all computer hardware must be maintained.</li>
                            <li>Any back up media must be protected in a locked, secure location.</li>
                            <li>Obsolete equipment that is being decommissioned should be cleansed of confidential customer data, and the procedure documented before being destroyed.</li>
                        </ul>
                        <h2>System Security</h2>
                        <ul>
                            <li>All computer systems must be protected by current anti-virus software.</li>
                            <li>Networks with internet access must be protected by a secure firewall.</li>
                            <li>Both anti-virus and firewall systems must be periodically updated.</li>
                            <li>Use of USB flash drives is restricted.</li>
                            <li>All software downloads must be approved by IT.</li>
                            <li><strong>Encryption</strong> &ndash; dealerships must encrypt all customer information held or transmitted when in transit over external networks and when at rest.</li>
                            <li>Dealer must implement <strong>Multifactor Authentication</strong> whenever any individual accesses an information system containing customer information.</li>
                            <li><strong>Change Management Procedures</strong> &ndash; Due to increased cybersecurity risk associated with changes/modifications to Company's IT infrastructure and systems, any addition, removal, or modification of the elements within Company's IT infrastructure and systems shall be governed accordingly:
                                <ul>
                                    <li><strong>Adding/removing end-user devices</strong>: The Qualified Individual in conjunction with designated IT personnel must be involved in adding and removing end-user devices.</li>
                                    <li><strong>Adding/removing third-party software and applications</strong>: Prior to adding third-party software or applications, the service provider must be assessed for the adequacy of their technical and physical information safeguards.</li>
                                    <li><strong>Web browser additions/modifications</strong>: Plugins limited to trusted sources, automatic updates configured, pop-up blockers enabled, content filters enabled.</li>
                                    <li><strong>Major additions/modifications to servers, operating systems, or network</strong>: A full penetration test, full internal and external vulnerability assessment, and risk assessment as appropriate.</li>
                                </ul>
                            </li>
                            <li>Implement <strong>Monitoring and logging of Authorized User Activity</strong> which will monitor activity of authorized users and detect unauthorized access or use of customer information.</li>
                            <li>Regular testing/auditing of the effectiveness of your safeguards key controls, systems and procedures. Implement either continuous monitoring or annual periodic <strong>Penetration Testing</strong> and vulnerability assessments.</li>
                        </ul>
                    </section>

                    <!-- Disposal -->
                    <section id="disposal">
                        <h1>Disposal of Consumer Information and Records</h1>
                        <p>Amendments to the Fair Credit Reporting Act require that users of consumer reports, which contain consumer information, be properly disposed of. Consumer information means any record about an individual, whether in paper, electronic, or other form, that is a consumer report or is derived from a consumer report. Any person who maintains or possesses consumer information for a business purpose must properly dispose of such information by taking <strong>reasonable measures</strong> to protect against unauthorized access to or use of the information in connection with its disposal.</p>
                        <ul>
                            <li>Dealership uses Shredding Co, a vetted third-party provider to dispose of all documents containing any consumer information.</li>
                            <li>Dealership shall have all electronic equipment scrubbed of all information by vetted and qualified third-party providers prior to disposing of any equipment that contained electronic data.</li>
                            <li>Customer NPI in all forms that is moved within the dealership must be handed off in a manner that leaves no doubt the hand-off has occurred.</li>
                            <li><strong>Disposal Procedures</strong> &ndash; Personnel must shred customer information prior to disposal, use secured wastebins, and use reputable document disposal vendors. Follow document retention policies already in place and dispose of customer information within 2 years of expiration from retention policy unless it cannot be feasibly destroyed due to the way the information is maintained.</li>
                        </ul>
                        <h2>General Risk Assessment of Customer NPI Based on Internal Audit</h2>
                        <p>Risk assessment findings may be found in the Privacy/GLB section of the Initial Review conducted at the time of installation, and are hereby incorporated herein. These areas will be monitored for future compliance.</p>
                    </section>

                    <!-- Processing Customer NPI by Department -->
                    <section id="processing">
                        <h1>Processing Customer NPI by Department</h1>
                        <p><strong>From Sales Department to:</strong></p>
                        <ul>
                            <li>Accounting Dept. - Sales department prepares a buyer's order form and gives to the General Sales Manager. Deals are then further prepared in the F&amp;I office, and put together in a deal jacket, which is then turned over to the license and title clerk to be processed.</li>
                            <li>Service and Parts Dept. &ndash; &ldquo;We Owes&rdquo; and requests for internal work on vehicles are the only correspondence transferred.</li>
                        </ul>
                        <p><strong>From Accounting Department to:</strong></p>
                        <ul>
                            <li>Sales Dept. &ndash; there may be times where sales will remove a deal from accounting for review of specific issues but it is returned to a secure environment after review.</li>
                        </ul>
                        <p><strong>From Service and Parts Department to:</strong></p>
                        <ul>
                            <li>Accounting Dept. &ndash; All R/O's and invoices flow back to the cashier for payment and then to accounting for filing.</li>
                        </ul>
                        <p><strong>From Sales Department to Third Parties:</strong></p>
                        <ul>
                            <li>Third Party Vendors &ndash; F&amp;I shall acquire proper privacy verbiage from the 3rd party vendors.</li>
                            <li>Finance Companies &ndash; In normal course of business, information is securely transferred either electronically or faxed for processing.</li>
                        </ul>
                    </section>

                    <section id="sales">
                        <h2>Sales Department</h2>
                        <p>Internal Security Plan &mdash; Handling and Processing Customer NPI:</p>
                        <ul>
                            <li>All credit bureaus processed must never be left unattended until securely stored in a restricted access and locked location.</li>
                            <li>All credit bureaus processed must be attached inside of a secure deal jacket, maintained in a dead deal file in a secure location, or disposed of in a locked secure shredding container.</li>
                            <li>All credit applications shall be kept secure and never left unattended.</li>
                            <li>Each employee must have their own unique password for DMS login.</li>
                            <li>All customer information shall be placed in either the deal Jacket and secured, the secured dead deal file, or destroyed.</li>
                            <li>Customer information on working deals shall be kept secured and locked at all times when not in use.</li>
                            <li>Deal jackets may be obtained by management staff only and signed in/out on the Customer NPI Log.</li>
                            <li>At no time are deal jackets to be left alone or unattended for any length of time.</li>
                            <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                            <li>Each night at closing an inspection is performed by the manager on duty.</li>
                        </ul>
                    </section>

                    <section id="fi">
                        <h2>F&amp;I Department</h2>
                        <ul>
                            <li>After a deal is accepted by the F&amp;I office for processing, that deal can only be accessed by Sales Manager, or Finance Manager.</li>
                            <li>All deal jackets must be secured and out of sight before leaving the F&amp;I office.</li>
                            <li>All credit bureaus processed must either be attached to the inside of deal jacket or disposed of in a locked security container.</li>
                            <li>Credit bureaus may not be faxed without consent of Sales Manager or Finance Manager.</li>
                            <li>Any requests for customer information from outside parties must be properly verified before disclosure.</li>
                            <li>All terminals or PCs with customer information must hide sensitive information from others.</li>
                        </ul>
                    </section>

                    <section id="service">
                        <h2>Service Department</h2>
                        <ul>
                            <li>All service documents that contain customer information are to be securely filed or disposed of in a secure shredding receptacle.</li>
                            <li>All customer documents with possible NPI must be filed each day or secured for future filing in a locked cabinet.</li>
                            <li>Customer service files retrieved from the office must be signed out on the Service Customer NPI log.</li>
                            <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                            <li>Each night at closing, an inspection is performed by Service Manager.</li>
                        </ul>
                    </section>

                    <section id="parts">
                        <h2>Parts Department</h2>
                        <ul>
                            <li>All parts tickets or other documents with possible customer NPI must either be secured or disposed of in a secured shredding receptacle.</li>
                            <li>Customer NPI used in conjunction with special parts ordering must be secured each night.</li>
                            <li>At no time are parts tickets to be left alone or unattended.</li>
                            <li>Each night at closing an inspection is performed by Parts Manager.</li>
                        </ul>
                    </section>

                    <section id="accounting">
                        <h2>Accounting Department</h2>
                        <ul>
                            <li>After a deal is received from F&amp;I, that deal can only be accessed by office personnel or management after signing out the deal in the NPI log.</li>
                            <li>All filing cabinets must be secured with a lock.</li>
                            <li>Deal jackets in other areas of the dealership (Parts Department, offsite storage) must be secured by lock with limited access.</li>
                            <li>Each employee must have their own unique password for DMS login.</li>
                            <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                            <li>Back-up tape from DMS must be treated as an NPI document and stored in a secured data safe.</li>
                        </ul>
                    </section>

                    <section id="cashier">
                        <h2>Cashier</h2>
                        <ul>
                            <li>All copies of driver licenses are to be filed or disposed of in a secure shredding receptacle.</li>
                            <li>All extra copies of invoices are to be disposed of in secured shredding receptacles.</li>
                            <li>Any program designed to capture email addresses must be secured in locked receptacles.</li>
                            <li>Any information requested from an outside source must be confirmed as to the source of the inquiry.</li>
                            <li>All terminals or PCs are to be logged off before being left unsupervised.</li>
                        </ul>
                    </section>

                    <section id="body">
                        <h2>Body Shop</h2>
                        <ul>
                            <li>All documents containing NPI such as body shop estimates, work orders or invoice copies are to be either securely filed or disposed of in a secure shredding receptacle.</li>
                            <li>Each employee must have their own unique password for DMS login.</li>
                            <li>All customer documents with possible NPI must be filed each day or secured in a locked cabinet.</li>
                            <li>Credit card information on any document must be secured and not left in an open or unsecured area.</li>
                        </ul>
                    </section>

                    <!-- Personnel -->
                    <section id="personnel">
                        <h1>Dealership Personnel</h1>
                        <p>Internal Security Plan</p>
                        <ul>
                            <li>Dealership will check references of each potential employee prior to the start of his or her employment.</li>
                            <li>Dealership shall obtain a background check in accord with the Fair Credit Reporting Act and applicable state laws.</li>
                            <li>All new employees will participate in Dealership's Information Security Program. Each person shall sign and acknowledge his or her agreement to abide by information security practices and procedures.</li>
                            <li>Training must be performed no later than 30 days after start of employment and all employees will be given a yearly refresher course.</li>
                            <li>Security of customer/consumer information is the responsibility of each and every Dealership employee.</li>
                        </ul>
                        <p>All employees will be made aware of Dealership's security policy, and that failure to comply could result in disciplinary measures, up to and including termination of employment.</p>
                    </section>

                    <!-- Third Party Providers -->
                    <section id="third">
                        <h1>Third Party Providers</h1>
                        <p><strong>Oversee Service Providers</strong> &ndash; any entity permitted access to customer information through its provision of services directly to dealer must be monitored to verify maintenance of adequate safeguards protecting customer information.</p>
                        <ul>
                            <li>Conducting thorough risk assessment to verify that the service provider understands and is capable of complying with Federal consumer financial law.</li>
                            <li>Requesting and reviewing the service provider's policies, procedures, internal controls, and training materials.</li>
                            <li>Including in the contract clear expectations about compliance, as well as appropriate and enforceable consequences.</li>
                            <li>Establishing internal controls and on-going monitoring to determine compliance.</li>
                            <li>Taking prompt action to address fully any problems identified, including terminating the relationship where appropriate.</li>
                        </ul>
                        <h2>Third Party Provider Requirements</h2>
                        <ul>
                            <li>All third-party providers must complete and provide the Dealership Third Party Risk Assessment form.</li>
                            <li>Dealership shall obtain a copy of the privacy policy of each outside entity that has access to dealership's customer information.</li>
                            <li>All third-party provider contracts must have &ldquo;safeguard rule&rdquo; language verifying compliance with GLBA and the FTC Safeguards Rule.</li>
                            <li>All third-party providers must have opt-out clauses for breach of customer NPI.</li>
                            <li>All third-party providers must maintain reasonable safeguard procedures to protect dealership's customer NPI.</li>
                            <li>All third-party providers must offer Dealership an indemnification clause in their contract.</li>
                        </ul>
                        <p>{{ qi }} shall be responsible for overseeing all third-party providers who come in contact with, download, handle or have any access to customer or consumer NPI.</p>
                    </section>

                    <!-- Records Retention -->
                    <section id="records">
                        <h1>Records Retention List</h1>
                        <ul>
                            <li>Customer Information &amp; Account Records
                                <ul>
                                    <li>Account Opening Forms: Retain for 5 to 7 years after account closure.</li>
                                    <li>Customer Identification Records (KYC/AML records): Retain for 5 years after the last transaction or account closure.</li>
                                    <li>Bank Statements &amp; Transaction History: Retain for 7 years.</li>
                                    <li>Loan Documents: Retain for 7 years after loan closure or termination.</li>
                                </ul>
                            </li>
                            <li>Tax and Regulatory Records
                                <ul>
                                    <li>Tax Returns: Retain for 7 years after filing.</li>
                                    <li>Tax Filings and Supporting Documents: Retain for 7 years.</li>
                                    <li>AML and SAR Reports: Retain for 5 years after the report was filed.</li>
                                </ul>
                            </li>
                            <li>Investment &amp; Trading Records
                                <ul>
                                    <li>Brokerage Statements &amp; Investment Records: Retain for 7 years after account closure.</li>
                                    <li>Investment Transactions: Retain for 7 years.</li>
                                    <li>Prospectuses &amp; Offering Documents: Retain for 7 years after offering closure.</li>
                                    <li>Employee Trading Records: Retain for 5 years.</li>
                                </ul>
                            </li>
                            <li>Financial Statements
                                <ul>
                                    <li>Annual Financial Statements: Retain for 7 years.</li>
                                    <li>Audit Reports: Retain for 7 years.</li>
                                    <li>General Ledger Entries &amp; Journals: Retain for 7 years.</li>
                                    <li>Bank Reconciliations: Retain for 7 years.</li>
                                </ul>
                            </li>
                            <li>Credit and Loan Documentation
                                <ul>
                                    <li>Loan Agreements &amp; Contracts: Retain for 7 years after repayment.</li>
                                    <li>Mortgage Documentation: Retain for 7 years after payoff or foreclosure.</li>
                                    <li>Default or Delinquency Records: Retain for 7 years after resolution.</li>
                                    <li>Foreclosure Documentation: Retain for 7 years after resolution.</li>
                                </ul>
                            </li>
                            <li>Employee and Payroll Records
                                <ul>
                                    <li>Employee Records: Retain for 5 to 7 years after termination.</li>
                                    <li>Payroll Records: Retain for 7 years.</li>
                                    <li>Tax Forms (W-2, 1099): Retain for 7 years.</li>
                                    <li>Benefits and Retirement Plan Records: Retain for 7 years after termination.</li>
                                </ul>
                            </li>
                            <li>Loan/Payment Systems &amp; Electronic Records
                                <ul>
                                    <li>Electronic Transactions: Retain for 5 years.</li>
                                    <li>Digital Banking Service Data: Retain for 5 to 7 years.</li>
                                    <li>Digital Contracts/Signatures: Retain for 7 years.</li>
                                </ul>
                            </li>
                            <li>Insurance and Risk Management
                                <ul>
                                    <li>Insurance Policies &amp; Coverage Records: Retain for 5 years after expiration.</li>
                                    <li>Claims Records: Retain for 5 to 7 years after settlement.</li>
                                    <li>Risk Management Documents: Retain for 7 years.</li>
                                </ul>
                            </li>
                            <li>Corporate &amp; Legal Documents
                                <ul>
                                    <li>Corporate Charters, Bylaws, Articles of Incorporation: Retain permanent.</li>
                                    <li>Board Meeting Minutes: Retain permanent.</li>
                                    <li>Legal Contracts and Agreements: Retain for 7 years after termination.</li>
                                    <li>Litigation Documents: Retain for 7 years after resolution.</li>
                                </ul>
                            </li>
                            <li>General Business &amp; Operational Records
                                <ul>
                                    <li>Vendor Contracts: Retain for 7 years after termination.</li>
                                    <li>General Correspondence: Retain for 3 years.</li>
                                    <li>Internal Audit Reports: Retain for 7 years.</li>
                                    <li>Marketing and Promotional Materials: Retain for 3 years.</li>
                                </ul>
                            </li>
                            <li>Security &amp; Privacy Records
                                <ul>
                                    <li>Data Breach &amp; Security Incident Reports: Retain for 5 years after resolution.</li>
                                    <li>Internal and External Security Audits: Retain for 7 years.</li>
                                </ul>
                            </li>
                            <li>Miscellaneous Financial Records
                                <ul>
                                    <li>Bankruptcy &amp; Insolvency Records: Retain for 7 years after resolution.</li>
                                    <li>Safe Deposit Box Records: Retain for 7 years after box closure.</li>
                                </ul>
                            </li>
                        </ul>
                    </section>

                    <!-- Signature -->
                    <section id="form" class="not-prose">
                        <div class="rounded-lg border bg-card p-6">
                            <h2 class="text-base font-semibold text-foreground">Signature</h2>
                            <p class="mt-1 text-sm text-muted-foreground">
                                Sign below to acknowledge that you have reviewed and accepted the policies in this manual.
                            </p>
                            <form class="mt-5 space-y-4" @submit.prevent="submit">
                                <SignaturePad
                                    v-model="form.signature"
                                    :error="form.errors.signature ?? null"
                                />
                                <Button type="submit" :disabled="!canSubmit">
                                    <Loader2 v-if="form.processing" class="animate-spin" />
                                    Submit Manual
                                </Button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
