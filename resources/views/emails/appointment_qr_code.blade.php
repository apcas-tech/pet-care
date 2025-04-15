<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Update</title>
</head>

<body>
    <h1>Appointment Confirmation</h1>
    <p>Dear <strong>{{ $ownerName }}</strong>,</p> <!-- Bold owner name -->
    <p>Your appointment for <strong>{{ $petName }}</strong> has been confirmed for the service: <strong>{{ $serviceName }}</strong> at <strong>{{ $appointmentTime }}</strong> on <strong>{{ $appointmentDate }}</strong>.</p>
    <p>Please show and scan the QR code after your appointment.</p>
    <p>Thank you for choosing our service!</p>
</body>

</html>