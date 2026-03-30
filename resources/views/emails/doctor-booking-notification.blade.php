<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #1f2937;">
    <h2 style="margin-bottom: 8px;">New Appointment Booking</h2>
    <p style="margin-top: 0;">A patient has booked an appointment with you.</p>

    <ul style="padding-left: 18px;">
        <li><strong>Booking ID:</strong> #APT000{{ $booking->id }}</li>
        <li><strong>Patient:</strong> {{ $booking->patient->name ?? 'N/A' }}</li>
        <li><strong>Patient Email:</strong> {{ $booking->patient->email ?? 'N/A' }}</li>
        <li><strong>Appointment Type:</strong> {{ ucfirst($booking->appointment_type) }}</li>
        <li><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($booking->appointment_datetime)->format('d M Y h:i A') }}</li>
        <li><strong>Duration:</strong> {{ $booking->service_time }} minutes</li>
        <li><strong>Status:</strong> {{ strtoupper($booking->status ?? 'PROCESSING') }}</li>
    </ul>

    <p style="margin: 20px 0;">
        <a href="{{ $actionUrl }}"
           style="display: inline-block; background: #2563eb; color: #fff; text-decoration: none; padding: 10px 16px; border-radius: 6px;">
            Open This Booking
        </a>
    </p>

    <p>Regards,<br>{{ config('app.name') }}</p>
</body>
</html>

