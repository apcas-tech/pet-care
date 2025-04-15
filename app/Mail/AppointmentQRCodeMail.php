<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentQRCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $qrCodePath;
    public $ownerName;
    public $serviceName;

    public function __construct($appointment, $qrCodePath)
    {
        $this->appointment = $appointment;
        $this->qrCodePath = $qrCodePath;

        // Get the pet owner's name
        $owner = $appointment->pet->owner;
        $this->ownerName = trim("{$owner->Fname} " . ($owner->Mname ? "{$owner->Mname}. " : "") . "{$owner->Lname}");

        // Get the service name
        $this->serviceName = $appointment->service->service; // Assuming 'service' is the column name in the Service model
    }

    public function build()
    {
        return $this->view('emails.appointment_qr_code')
            ->with([
                'ownerName' => $this->ownerName, // Pass the full name
                'petName' => $this->appointment->pet->name,
                'appointmentId' => $this->appointment->id,
                'appointmentDate' => $this->appointment->appt_date,
                'appointmentTime' => $this->appointment->appt_time,
                'serviceName' => $this->serviceName, // Pass the service name
            ])
            ->attach($this->qrCodePath, [
                'as' => 'appointment_qr.png',
                'mime' => 'image/png',
            ]);
    }
}
