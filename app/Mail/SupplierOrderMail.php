<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;


class SupplierOrderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $order ;
    public $tries = 2;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->afterCommit();
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::signedRoute('orderRecived', ['order' => $this->order->id, 'type' => 'Supplier']);
        return $this->subject('New Order From School Megamart')->markdown('emails.orders.SupplierOrder',['order' , $this->order, 'url' => $url]);
    }
}
