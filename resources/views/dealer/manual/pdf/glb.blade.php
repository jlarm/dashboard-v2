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
<div class="cover">
    <h1 class="pdf-title">{{ $manual->name }}</h1>
    <h2 class="pdf-desc">Information Security Program</h2>
    <p class="pdf-date">{{ $manual->assessment_date->format('F d, Y') }}</p>
    <table class="cover-signatures">
        <thead>
        <tr>
            <th>Date</th>
            <th>ACC Rep Signature</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
<div class="page-break"></div>
<div>
    <table class="full-width">
        <tbody>
        <tr>
            <td>{{ $manual->name }}</td>
            <td align="right">{{ $manual->assessment_date->format('F d, Y') }}</td>
        </tr>
        </tbody>
    </table>
    <table class="full-width">
        <tbody>
        <td class="half-width">Information</td>
        <td class="half-width">
            <table class="border">
                <tbody>
                <tr>
                    <td>Address</td>
                    <td>{{ $manual->address }}</td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>{{ $manual->phone }}</td>
                </tr>
                <tr>
                    <td>Fax Number</td>
                    <td>{{ $manual->fax ?? '' }}</td>
                </tr>
                <tr>
                    <td>Internet Home Page</td>
                    <td>{{ $manual->website }}</td>
                </tr>
                <tr>
                    <td>Hours of Operation</td>
                    <td>See web info</td>
                </tr>
                <tr>
                    <td>Qualified Individual</td>
                    <td>{{ $manual->qi }}</td>
                </tr>
                <tr>
                    <td>Number of Security Receptacles</td>
                    <td>{{ count($manual->receptacles) }}</td>
                </tr>
                <tr>
                    <td>Locations</td>
                    <td>
                        @foreach($manual->receptacles as $receptacle)
                            {{ $receptacle['name'] }}<br>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        </tbody>
    </table>
    <table class="full-width border">
        <thead>
        <tr>
            <th>Managers Name</th>
            <th>Title</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($manual->managers as $manager)
            <tr>
                <td>{{ $manager['name'] }}</td>
                <td>{{ $manager['title'] }}</td>
                <td>{{ $manager['email'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
<div class="page-break"></div>
<div>
    <h2>Information Security Program (ISP)</h2>
    <p>This document contains the ISP for <strong>Dealershipx</strong>, and is part of the
        Compliance Management System for the Dealership. This information was
        assembled with the help of Automotive Risk Management Partners, Inc. It
        contains the process that <strong>Dealershipx</strong> follows to ensure compliance with
        the Gramm Leach Bliley Act, Federal Trade Commission Safeguards Rule,
        and the privacy and security of customer and dealership information.</p>
    <p>All information provided includes all revisions to the Safeguards Rule that are to be
        implemented by June 9 th , 2023. There are 8 elements that dealerships must comply
        with listed below and reviewed throughout this ISP manual.</p>
    <ol>
        <li>Designation of a Qualified Individual</li>
        <li>Periodic Risk Assessments of dealership</li>
        <li>Design and Implement safeguards for
            <ul>
                <li>access control</li>
                <li>system inventory</li>
                <li>Encryption</li>
                <li>Secure development practices</li>
                <li>MFA – Multifactor Authentication</li>
                <li>Disposal Procedures</li>
                <li>Change management procedures</li>
                <li>Monitoring and Logging of Authorized User Activity</li>
            </ul>
        <li>Penetration Testing</li>
        <li>Implement P&amp;P for personnel to implement your ISP</li>
        <li>Oversee Service Providers</li>
        <li>Draft Incident Response Plan</li>
        <li>Prepare an annual report to board or equivalent</li>
    </ol>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
<div class="page-break"></div>
<div>
    <h2>Objectives</h2>
    <p>The objective of this program is to establish the necessary policies and procedures for the handling
        of, use of, and safeguarding of consumer/customer information as required for compliance with the
        Gramm Leach Bliley Act.</p>
    <p>Concerning this program, “Non-Public Personal Information” (NPI) shall mean any information about
        a customer/consumer of dealership which it receives about the customer/consumer, and can be
        directly attributed in any manner to a customer/consumer.</p>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
<div class="page-break"></div>
<div>
    <h2>General</h2>
    <div class="question">
        1. Have you been in business less than five years? If so, how long have you been in business?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q1a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q1a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q1c ?? '' !!}
        </div>
    </div>
    <div class="question">
        2. Are you a public entity? If not, what is your organizational type?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q2a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q2a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q2c ?? '' !!}
        </div>
    </div>
    <div class="question">
        3. Have you provided the service/product under consideration for more than one year?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q3a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q3a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q3c ?? '' !!}
        </div>
    </div>
    <div class="question">
        4. Have you recently merged or acquired another entity or are you in the process of merging or acquiring another
        entity? If so, provide a summary of the transaction, if disclosure is appropriate.
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q4a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q4a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q4c ?? '' !!}
        </div>
    </div>
    <h2>Customer Privacy</h2>
    <div class="question">
        5. Do you have a company privacy policy?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q5a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q5a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q5c ?? '' !!}
        </div>
    </div>
    <div class="question">
        6. Does your privacy policy comply with the GLBA?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q6a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q6a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q6c ?? '' !!}
        </div>
    </div>
    <div class="question">
        7. Do you have a data retention and/or data destruction policy?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q7a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q7a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q7c ?? '' !!}
        </div>
    </div>
    <div class="question">
        8. Is your privacy policy communicated to all of your employees? If so, how often?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q8a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q8a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q8c ?? '' !!}
        </div>
    </div>
    <div class="question">
        9. Are your employees required to sign non-disclosure agreements?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q9a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q9a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q9c ?? '' !!}
        </div>
    </div>
    <div class="question">
        10. Do you conduct background checks on your employees? If so, please explain the types of background checks
        performed, how often.
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q10a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q10a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q10c ?? '' !!}
        </div>
    </div>
    <div class="question">
        11. Do you have exit procedures in place to verify that customer non-public information is no longer accessible
        to terminated or suspended employees?
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q11a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q11a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q11c ?? '' !!}
        </div>
    </div>
    <div class="question">
        12. Please provide a copy of your record retention policy.
        <div class="answer">
            <label for="yes">
                Yes
                <input type="radio" @if($manual->q12a === 1) checked @endif>
            </label>
            <label for="no">
                No
                <input type="radio" @if($manual->q12a === 0) checked @endif>
            </label>
        </div>
        <div>
            <strong>Comments:</strong><br/>
            {!! $manual->q12c ?? '' !!}
        </div>
    </div>
</div>
<div class="footer">
    <div class="footer-company">AUTOMOTIVE RISK MANAGEMENT PARTNERS INC.</div>
    <span class="page_number"></span>
</div>
</body>
</html>
