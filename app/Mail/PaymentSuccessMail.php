<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class PaymentSuccessMail extends Mailable
{
  use Queueable, SerializesModels;

  public $payment;

  public function __construct(Payment $payment)
  {
    $this->payment = $payment;
  }

  public function envelope(): Envelope
  {
    return new Envelope(
      subject: 'Payment Successful',
    );
  }

  public function content(): Content
  {
    return new Content(
      view: 'emails.payments.success',
    );
  }
}
