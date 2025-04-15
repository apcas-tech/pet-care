<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFC Animal Clinic</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin: 1in;
        /* Set all margins to 1 inch */
    }

    .container {
        width: 100%;
        padding: 20px;
        border: 2px solid #000;
        position: relative;
    }

    .header {
        display: flex;
        flex-direction: row;
        /* Explicitly set horizontal layout */
        justify-content: space-between;
        align-items: center;
        width: 100%;
        /* Ensure full width */
    }

    .rx-icon {
        width: 80px;
        /* Adjust as needed */
        height: 80px;
    }

    .logo {
        width: 100px;
        height: 100px;
    }

    .clinic-details {
        text-align: center;
        margin-bottom: 10px;
    }

    .clinic-details h2 {
        margin-bottom: 5px;
    }

    .clinic-details p {
        margin: 2px 0;
    }

    /* Flexbox layout for Owner & Pet Details */
    .details-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
        margin-bottom: 20px;
        border-bottom: 2px solid black;
        padding-bottom: 10px;
    }

    .details-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        /* Ensures proper alignment */
    }

    .details-row p {
        display: inline-block;
        margin: 5px 10px 5px 0;
        /* Add spacing between elements */
        white-space: nowrap;
        /* Prevents wrapping */
    }

    .details {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .details p {
        margin: 5px 0;
        white-space: nowrap;
        /* Prevents wrapping */
    }

    .details strong {
        display: inline-block;
        min-width: 150px;
    }

    .prescription-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .prescription-table th,
    .prescription-table td {
        padding: 8px;
        text-align: left;
    }

    .prescription-table th {
        background-color: #f2f2f2;
        border: 1px solid #000;
        text-align: center;
    }

    .signature-section {
        margin-top: 50px;
        text-align: center;
        float: right;
        /* Float the signature section to the right */
        width: 250px;
        /* Set a fixed width to prevent overflow */
    }

    .signature-section img {
        display: block;
        width: 150px;
    }

    .signature-line {
        display: block;
        width: 100%;
        /* Make sure the line spans the section width */
        border-top: 2px solid black;
        font-weight: bold;
    }

    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }

    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        /* Adjust size */
        height: auto;
        opacity: 0.1;
        /* Adjust transparency */
        z-index: -1;
        /* Ensure it stays in the background */
    }
</style>

<body>
    <div class="container">
        <img src="{{ public_path('imgs/logo.png') }}" alt="Watermark" class="watermark">
        <!-- Header -->
        <table width="100%">
            <tr>
                <td style="width: 20%; text-align: left;">
                    <img src="{{ public_path('imgs/rx-icon-6.png') }}" alt="RX Icon" class="rx-icon">
                </td>
                <td style="width: 60%; text-align: center;">
                    <h2>BFC Animal Clinic</h2>
                    <p>National Rd, Orani, Bataan, 2112</p>
                    <p>Email: bfcanimalclinic@yahoo.com</p>
                </td>
                <td style="width: 20%; text-align: right;">
                    <img src="{{ public_path('imgs/logo.png') }}" alt="Clinic Logo" class="logo">
                </td>
            </tr>
        </table>

        <!-- Pet & Owner Details with Flexbox -->
        <div class="details-container">
            <div class="details-row">
                <p><strong>Owner Name:</strong> {{ $pet->owner->Fname ?? '' }} {{ $pet->owner->Lname ?? '' }}</p>
                <p><strong>Contact No.:</strong> {{ $pet->owner->phone ?? '' }}</p>
                <p><strong>Address:</strong> {{ $pet->owner->address ?? '' }}</p>
                <p><strong>Email:</strong> {{ $pet->owner->email ?? '' }}</p>
            </div>

            <div class="details-row">
                <p><strong>Pet Name:</strong> {{ $pet->name ?? '' }}</p>
                <p><strong>Species:</strong> {{ $pet->species ?? '' }}</p>
                <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($pet->bday)->diff(\Carbon\Carbon::now())->y ?? '' }} yrs old</p>
            </div>
        </div>

        <!-- Prescription Details -->
        <div class="details-row">
            <p><strong>Dr.</strong> {{ $prescription->veterinarian->Fname }} {{ $prescription->veterinarian->Lname }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($prescription->record_date)->format('M d, Y') }}</p>
            <p><strong>Diagnosis/Notes:</strong> {{ $prescription->description }}</p>
        </div>

        <table class="prescription-table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Dosage</th>
                    <th>Instructions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescription->prescription as $med)
                <tr>
                    <td>{{ $med['name'] ?? '' }}</td>
                    <td>{{ $med['dosage'] ?? '' }}</td>
                    <td>{{ ($med['frequency'] ?? '') . ' for ' . ($med['duration'] ?? '') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix">
            <div class="signature-section">
                @if($signaturePath)
                <img src="{{ public_path($signaturePath) }}" alt="Vet Signature" style="width: 200px;">
                @endif
                <p class="signature-line">Veterinarian's Signature</p>
            </div>
        </div>
    </div>
</body>

</html>