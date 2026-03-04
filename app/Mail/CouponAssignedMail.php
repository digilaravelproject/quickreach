<?php

namespace App\Mail;

use App\Models\Coupon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $coupon;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A Special Coupon Has Been Assigned to You!')
                    ->view('emails.coupon_assigned');
    }
}
