<h2>Dealer Participation Program Form</h2>
<div class="dpp-example relative max-w-3xl text-sm space-y-6 border rounded-md p-5 overflow-hidden">
    <span class="dpp-example-watermark">EXAMPLE</span>
    <div class="grid grid-cols-4 gap-5">
        <div class="col-span-3 flex items-end gap-2">
            <span class="shrink-0">Customer:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <div class="flex items-end gap-2">
            <span class="shrink-0">Date:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <div class="col-span-2 flex items-end gap-2">
            <span class="shrink-0">Standard DPP Rate:</span>
            <input disabled placeholder="{{ $standardDppRate }}" type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <div class="col-span-2 flex items-end gap-2">
            <span class="shrink-0">Final DPP Rate:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
    </div>
    <p class="italic">If the Final DPP Rate does not equal the Standard DPP Rate, complete the form below. If the customer did not identify a specific source or amount of a competing rate, indicate &ldquo;not identified&rdquo;.</p>
    <ul class="list-none pl-0 space-y-3">
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Financing source imposed participation rate less than DPP Rates.</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Customer qualifies for Dealer participation program (employee, family member, or other program qualified individual).</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Customer negotiated rate.</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Dealer Promotion.</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>PTI Constraint.</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Subvented Rate</span>
        </li>
        <li class="flex items-start gap-2">
            <input disabled type="checkbox" class="mt-1 h-4 w-4 rounded border-input">
            <span>Inventory reduction considerations (describe approximate number of days in inventory, approximate number in stock, declining value of vehicle, etc.)</span>
        </li>
    </ul>
    <div class="grid grid-cols-5 gap-3">
        <div class="col-span-3 flex items-end gap-2">
            <span class="shrink-0">Signature:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <div class="flex items-end gap-2">
            <span class="shrink-0">Title:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <div class="flex items-end gap-2">
            <span class="shrink-0">Date:</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
    </div>
    <div>
        <div class="flex items-end gap-2">
            <span class="shrink-0">Approved</span>
            <input disabled type="text" class="min-w-0 flex-1 border-0 border-b border-input bg-transparent py-0 text-sm focus:outline-none">
        </div>
        <p class="text-xs text-muted-foreground mt-1">Manager (shall not have participated in the credit decision)</p>
    </div>
</div>
<p class="mt-6">The Equal Credit Opportunity Act makes it illegal for a &ldquo;creditor&rdquo; to discriminate in any aspect of a credit transaction because of race, color, religion, national origin, sex, marital status, age, receipt of income from any public assistance program, or the exercise, in good faith, of a right under the Consumer Credit Protection Act.</p>

<h2>Appointment and Program Approval</h2>
<p>The following employee has been appointed as {{ $tenantName }} Fair Credit Compliance Program Coordinator:</p>
@if($qualifiedIndividualName)
    <p class="font-bold">{{ $qualifiedIndividualName }}</p>
@else
    <p class="text-destructive font-bold">A Qualified Individual is required to complete the CMS Manual</p>
@endif
<p>Dealership has adopted and approved a Fair Credit Compliance Policy and Program to be implemented throughout the dealership.</p>
<p>By signing below, the undersigned, constituting all of the members of the Dealership Board of Directors, acknowledge the Board&rsquo;s approval of the foregoing Dealership Fair Credit Policy and Fair Credit Compliance Program and its appointment of the Dealership Fair Credit Compliance Program.</p>
<p>Coordinator this {{ $todayDay }} day of {{ $todayMonth }}, {{ $todayYear }}.</p>

<h2>Acknowledgement</h2>
<p>The undersigned does hereby acknowledge receipt and review of Dealership Fair Credit Compliance Program, and agrees to the terms contained therein.</p>
<p>Dated: {{ $today }}</p>
