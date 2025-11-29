<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mime\Email;

class OrderStatusUpdated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $status;
    public $productItems;
    public $embeddedImages = [];


    /**
     * Create a new message instance.
     */
    public function __construct($order, $status, $productItems)
    {
        $this->order = $order;
        $this->status = $status;
        $this->productItems = $productItems;
    }

    /**
     * Build the message.
     */
     public function build()
{
    return $this->view('admin.email')
        ->subject('Order Status Updated')
        ->with([
            'order' => $this->order,
            'status' => $this->status,
            'productItems' => $this->productItems,
        ]);
}





}
