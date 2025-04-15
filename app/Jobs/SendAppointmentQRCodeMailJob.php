<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\AppointmentQRCodeMail;
use Illuminate\Support\Facades\Mail;

class SendAppointmentQRCodeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $appointment;
    protected $qrCodePath;

    public function __construct($email, $appointment, $qrCodePath)
    {
        $this->email = $email;
        $this->appointment = $appointment;
        $this->qrCodePath = $qrCodePath;
    }

    public function handle()
    {
        Mail::to($this->email)->send(new AppointmentQRCodeMail($this->appointment, $this->qrCodePath));
    }
}
