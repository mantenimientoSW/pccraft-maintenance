<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Orden;

class OrderCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('emails.canceled') // Cambia esto a emails.canceled
                    ->subject('Tu pedido ha sido cancelado')
                    ->with([
                        'order' => $this->order,
                    ]);
    }
}
