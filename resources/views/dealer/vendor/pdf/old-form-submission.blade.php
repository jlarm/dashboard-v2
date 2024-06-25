<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Automotive Risk Management Partners</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="h-screen flex justify-center items-center">
    <div class="text-center space-y-5">
        <x-application-logo class="w-auto h-20 text-gray-600" />
        <h1 class="text-4xl font-bold text-arm-blue-500">3rd Party Service Agreement</h1>
        <h2 class="text-2xl font-bold text-arm-blue-500">{{ $vendor->name }}</h2>
        <h3 class="text-arm-blue-500">{{ $vendor->updated_at->format('F d, Y') }}</h3>
    </div>
</div>
<div class="w-full max-w-4xl mx-auto space-y-5 my-20">
    <div class="space-y-5">
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q1a === 'no' || $vendor->q1a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Are you an employee or authorized representative of this vendor/company? Indicate the Person’s Name in the comments.</h4>
            <p class="capitalize">{{ $vendor->q1a }}</p>
            <p class="text-sm">{{ $vendor->q1c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q2a === 'no' || $vendor->q2a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company offer software applications as part of its services?</h4>
            <p class="capitalize">{{ $vendor->q2a }}</p>
            <p class="text-sm">{{ $vendor->q2c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q3a === 'no' || $vendor->q3a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Is client data encrypted at rest and in transit? If not, why not?</h4>
            <p class="capitalize">{{ $vendor->q3a }}</p>
            <p class="text-sm">{{ $vendor->q3c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q4a === 'no' || $vendor->q4a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Has your company experienced a data breach in the past 12 months that affected customers’ personal information?</h4>
            <p class="capitalize">{{ $vendor->q4a }}</p>
            <p class="text-sm">{{ $vendor->q4c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q5a === 'no' || $vendor->q5a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have insurance coverage for a data breach that may involve our customers’ information that
            your company acquires while doing business with us?</h4>
            <p class="capitalize">{{ $vendor->q5a }}</p>
            <p class="text-sm">{{ $vendor->q5c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q6a === 'no' || $vendor->q6a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company require security awareness training for all employees? If so, please answer how often it is
            provided in the comments section.</h4>
            <p class="capitalize">{{ $vendor->q6a }}</p>
            <p class="text-sm">{{ $vendor->q6c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q7a === 'no' || $vendor->q7a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company monitor for the effectiveness of employee security training by testing your users with
            simulated attacks?</h4>
            <p class="capitalize">{{ $vendor->q7a }}</p>
            <p class="text-sm">{{ $vendor->q7c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q8a === 'no' || $vendor->q8a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have a process for restricting access to customer files on a need-to-know basis?</h4>
            <p class="capitalize">{{ $vendor->q8a }}</p>
            <p class="text-sm">{{ $vendor->q8c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q9a === 'no' || $vendor->q9a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Do you have a written information security program?</h4>
            <p class="capitalize">{{ $vendor->q9a }}</p>
            <p class="text-sm">{{ $vendor->q9c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q10a === 'no' || $vendor->q10a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company conduct annual risk assessments that assess electronic, physical, and administrative
            information safeguards?</h4>
            <p class="capitalize">{{ $vendor->q10a }}</p>
            <p class="text-sm">{{ $vendor->q10c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q11a === 'no' || $vendor->q11a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have systems in place to securely dispose of documents that have personal identifiable
            information on them?</h4>
            <p class="capitalize">{{ $vendor->q11a }}</p>
            <p class="text-sm">{{ $vendor->q11c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q12a === 'no' || $vendor->q12a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have systems in place to restrict access to files/documents containing customers personal
            information to those with proper authorization?</h4>
            <p class="capitalize">{{ $vendor->q12a }}</p>
            <p class="text-sm">{{ $vendor->q12c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q13a === 'no' || $vendor->q13a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have due diligence processes and procedures for vetting subcontractors, including having them
            sign processing agreements that are compliant with applicable federal and state laws?</h4>
            <p class="capitalize">{{ $vendor->q13a }}</p>
            <p class="text-sm">{{ $vendor->q13c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q14a === 'no' || $vendor->q14a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Has your company performed penetration testing of its systems within the past 12 months?</h4>
            <p class="capitalize">{{ $vendor->q14a }}</p>
            <p class="text-sm">{{ $vendor->q14c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q15a === 'no' || $vendor->q15a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Has your company conducted a vulnerability assessment of your systems within the past 6 months?</h4>
            <p class="capitalize">{{ $vendor->q15a }}</p>
            <p class="text-sm">{{ $vendor->q15c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q16a === 'no' || $vendor->q16a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company maintain end-of-life or unsupported operating systems or software? If so, are these systems
            used to manage or maintain customer data?</h4>
            <p class="capitalize">{{ $vendor->q16a }}</p>
            <p class="text-sm">{{ $vendor->q16c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q17a === 'no' || $vendor->q17a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company regularly patch or update systems and third-party software and monitor for noncompliance?</h4>
            <p class="capitalize">{{ $vendor->q17a }}</p>
            <p class="text-sm">{{ $vendor->q17c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q18a === 'no' || $vendor->q18a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company have a written incident response plan in the event of a security breach?</h4>
            <p class="capitalize">{{ $vendor->q18a }}</p>
            <p class="text-sm">{{ $vendor->q18c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q19a === 'no' || $vendor->q19a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company require users to create complex passwords with 9 characters or greater?</h4>
            <p class="capitalize">{{ $vendor->q19a }}</p>
            <p class="text-sm">{{ $vendor->q19c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q20a === 'no' || $vendor->q20a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company prohibit shared logins?</h4>
            <p class="capitalize">{{ $vendor->q20a }}</p>
            <p class="text-sm">{{ $vendor->q20c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q21a === 'no' || $vendor->q21a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Does your company require multi-factor authentication to log into your company’s systems?</h4>
            <p class="capitalize">{{ $vendor->q21a }}</p>
            <p class="text-sm">{{ $vendor->q21c }}</p>
        </div>
        <div class="border border-gray-200 rounded-xl p-5 space-y-3 page-break">
            <h4 class="{{ ($vendor->q22a === 'no' || $vendor->q22a === 'na') ? 'text-red-500' : '' }} font-bold text-xl">Do you have an account lockout policy?</h4>
            <p class="capitalize">{{ $vendor->q22a }}</p>
            <p class="text-sm">{{ $vendor->q22c }}</p>
        </div>
    </div>
    <div>
</div>
<div>
    <h3>{{ $vendor->contact_name }} - {{ $vendor->name }}</h3>
    <img src="{{ storage_path() }}/app/signatures/{{ $vendor->signature }}" alt="Signature"/>
</div>
</div>
</body>
</html>
