<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrackingDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order, $trackingId, $trackingLink, $trackingSlip;

    public function __construct($order, $trackingId, $trackingLink, $trackingSlip)
    {
        $this->order = $order;
        $this->trackingId = $trackingId;
        $this->trackingLink = $trackingLink;
        $this->trackingSlip = $trackingSlip;
    }

    public function build()
    {
        return $this->subject('Order Tracking Details')
            ->view('emails.tracking-details')
            ->with([
                'order' => $this->order,
                'trackingId' => $this->trackingId,
                'trackingLink' => $this->trackingLink,
                'trackingSlip' => $this->trackingSlip
            ]);
    }
}
