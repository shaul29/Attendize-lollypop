<?php

namespace App\Mail;

use App\Models\Order;
use App\Services\Order as OrderService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class SendOrderNotificationMail extends Mailable
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
        $this->order = $order;
        $this->orderService = $orderService;
        $this->email_logo = config('attendize.email_logo_url');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = trans("Controllers.new_order_received", ["event" => $this->order->event->title, "order" => $this->order->order_reference]);
        return $this->subject($subject)
                    ->view('Emails.OrderNotification');
    }
}
