<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ARMP</title>
    <style>
        body {
            font-family: Helvetica, serif;
        }

        h1 {
            font-size: 16px;
        }

        h2 {
            text-align: center;
        }

        p {
            font-size: 18px;
        }

        .cover {
            text-align: center;
        }

        .pdf-title {
            font-size: 25px;
        }

        .pdf-desc {
            font-size: 20px;
        }

        .pdf-date {
            font-size: 14px;
        }

        .cover-signatures {
            width: 100%;
            margin-top: 200px
        }

        .cover-signatures th, .cover-signatures td {
            height: 50px;
        }

        .cover-signatures, .cover-signatures th, .cover-signatures td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .full-width {
            width: 100%;
        }

        .half-width {
            width: 50%;
        }

        .border, .border th, .border td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        .question {
            background: #f8f8f8;
            padding: 20px;
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .answer {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .page_number:before {
            content: "Page " counter(page);
        }

        .header {
            position: fixed;
            left: -50px;
            top: -100px;
            right: -50px;
            height: 100px;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: -50px;
            right: 0;
            height: auto;
            border-top: 3px solid black;
            padding: 25px 50px;
        }

        .footer-company {
            position: absolute;
            left: 0;
            top: 10px;
        }

        .page_number {
            position: absolute;
            right: 0;
            top: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Automotive Risk Management Partners</h1>
</div>
<!--  Front Page -->
<div class="cover">
    <h1 class="pdf-title">{{ $vendor->name }}</h1>
    <h2 class="pdf-desc">3rd Party Service Agreement</h2>
    <p class="pdf-date">{{ $vendor->updated_at->format('F d, Y') }}</p>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
<div class="page-break"></div>
<!-- Questions -->
<div>
    <div class="question">
        Are you an employee or authorized representative of this vendor/company? Indicate the Person’s Name in the
        comments.
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q1a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q1a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q1a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q1c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company offer software applications as part of its services?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q2a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q2a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q2a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q2c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Is client data encrypted at rest and in transit? If not, why not?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q3a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q3a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q3a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q3c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Has your company experienced a data breach in the past 12 months that affected customers’ personal information?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q4a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q4a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q4a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q4c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have insurance coverage for a data breach that may involve our customers’ information that
        your company acquires while doing business with us?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q5a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q5a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q5a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q5c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company require security awareness training for all employees? If so, please answer how often it is
        provided in the comments section.
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q6a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q6a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q6a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q6c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company monitor for the effectiveness of employee security training by testing your users with
        simulated attacks?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q7a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q7a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q7a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q7c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have a process for restricting access to customer files on a need-to-know basis?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q8a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q8a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q8a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q8c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Do you have a written information security program?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q9a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q9a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q9a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q9c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company conduct annual risk assessments that assess electronic, physical, and administrative
        information safeguards?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q10a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q10a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q10a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q10c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have systems in place to securely dispose of documents that have personal identifiable
        information on them?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q11a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q11a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q11a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q11c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have systems in place to restrict access to files/documents containing customers personal
        information to those with proper authorization?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q12a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q12a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q12a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q12c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have due diligence processes and procedures for vetting subcontractors, including having them
        sign processing agreements that are compliant with applicable federal and state laws?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q13a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q13a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q13a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q13c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Has your company performed penetration testing of its systems within the past 12 months?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q14a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q14a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q14a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q14c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Has your company conducted a vulnerability assessment of your systems within the past 6 months?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q15a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q15a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q15a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q15c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company maintain end-of-life or unsupported operating systems or software? If so, are these systems
        used to manage or maintain customer data?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q16a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q16a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q16a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q16c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company regularly patch or update systems and third-party software and monitor for noncompliance?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q17a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q17a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q17a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q17c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company have a written incident response plan in the event of a security breach?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q18a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q18a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q18a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q18c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company require users to create complex passwords with 9 characters or greater?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q19a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q19a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q19a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q19c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company prohibit shared logins?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q20a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q20a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q20a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q20c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Does your company require multi-factor authentication to log into your company’s systems?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q21a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q21a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q21a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q21c ?? '' !!}
        </div>
    </div>
    <div class="question">
        Do you have an account lockout policy?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($vendor->q22a === 'yes') checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($vendor->q22a === 'no') checked @endif>
            </label>
            <label for="na">
                N/A
                <input type="radio" @if($vendor->q22a === 'na') checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $vendor->q22c ?? '' !!}
        </div>
    </div>
</div>
<div>
    <h3>{{ $vendor->name }} - {{ $vendor->contact_name }}</h3>
    <img src="{{ storage_path() }}/app/signatures/{{ $vendor->signature }}" alt="Signature"/>


</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>

</body>
</html>
