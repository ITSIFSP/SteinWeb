<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptanceEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $organization)
    {
        $this->data = $data;
        $this->organization = $organization;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->data);
        return $this->from('itscatanduva.recovery@gmail.com')
            ->subject('Interdições de vias públicas (autorização)')
            ->view('email.notification')
            ->with('data', $this->data)
            ->with('organization', $this->organization);
    }
}
