<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cartItems;

    public function __construct($order, $cartItems)
    {
        $this->order = $order;
        $this->cartItems = $cartItems;
    }

    public function build()
    {
        return $this->subject('Confirmación de tu compra')
                    ->view('emails.order_confirmation')
                    ->with([
                        'order' => $this->order,
                        'cartItems' => $this->cartItems,
                    ]);
    }
}

