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
    <h1 class="pdf-title">{{ config('app.name') }}</h1>
    <h2 class="pdf-desc">Information Security Program</h2>
    <p class="pdf-date">{{ $isp->created_at->format('F d, Y') }}</p>
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
            <td>{{ config('app.name') }}</td>
            <td align="right">{{ $isp->created_at->format('F d, Y') }}</td>
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
                    <td>921 S Milwaukee Ave 921 S Milwaukee Ave, Illinois 60048</td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>847-362-5000</td>
                </tr>
                <tr>
                    <td>Fax Number</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Internet Home Page</td>
                    <td>https://libertyautoplaza.com</td>
                </tr>
                <tr>
                    <td>Hours of Operation</td>
                    <td>See web info</td>
                </tr>
                <tr>
                    <td>Qualified Individual</td>
                    <td>{{ $isp->qualified_individual_name }}</td>
                </tr>
                </tbody>
            </table>
        </td>
        </tbody>
    </table>
    <table class="full-width border">
        <thead>
        <tr>
            <th>Title</th>
            <th>Managers Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Owner</td>
            <td>{{ $isp->owner_name }}</td>
            <td>{{ $isp->owner_phone }}</td>
        </tr>
        <tr>
            <td>General Manager</td>
            <td>{{ $isp->general_manager_name }}</td>
            <td>{{ $isp->general_manager_phone }}</td>
        </tr>
        <tr>
            <td>Body Shop Manager</td>
            <td>{{ $isp->body_shop_manager_name }}</td>
            <td>{{ $isp->body_shop_manager_phone }}</td>
        </tr>
        <tr>
            <td>Parts Manager</td>
            <td>{{ $isp->parts_manager_name }}</td>
            <td>{{ $isp->parts_manager_phone }}</td>
        </tr>
        <tr>
            <td>Service Manager</td>
            <td>{{ $isp->service_manager_name }}</td>
            <td>{{ $isp->service_manager_phone }}</td>
        </tr>
        <tr>
            <td>Qualified Individual</td>
            <td>{{ $isp->qualified_individual_name }}</td>
            <td>{{ $isp->qualified_individual_phone }}</td>
        </tr>
        </tbody>
    </table>
    <table class="full-width border">
        <tbody>
        <tr>
            <td>Police Emergency Number <br> {{ $isp->police_emergency_phone }}</td>
            <td>Police Non-Emergency Number <br> {{ $isp->police_non_emergency_phone }}</td>
        </tr>
        <tr>
            <td>Fire Emergency Number <br> {{ $isp->fire_emergency_phone }}</td>
            <td>Fire Non-Emergency Number <br> {{ $isp->fire_non_emergency_phone }}</td>
        </tr>
        </tbody>
    </table>
    <p>Fire Alarm Type: {{ $isp->fire_alarm_type }}</p>
    <p>Burglar Alarm Type: {{ $isp->burglar_alarm_type }}</p>
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
</body>
</html>
