<?php

namespace App\Mail;

use App\Models\Order;
use App\Services\Order as OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;


class SendOrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    public $order;

    /**
     * The order service instance.
     *
     * @var OrderService
     */
    public $orderService;

    public $email_logo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, OrderService $orderService)
    {
        $this->email_logo = config('attendize.email_logo_url');
        $this->order = $order;
        $this->orderService = $orderService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = trans(
            "Controllers.tickets_for_event",
            ["event" => $this->order->event->title]
        );
        return $this->subject($subject)
                    ->view('Emails.OrderConfirmation');
    }
}
