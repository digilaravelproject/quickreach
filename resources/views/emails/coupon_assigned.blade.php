<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Exclusive Coupon Code</title>
    <style>
        body { margin: 0; padding: 0; background-color: #f3f5fb; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f3f5fb; padding: 40px 0; }
        .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; }
        .header { background-color: #111827; padding: 30px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
        .content { padding: 40px 30px; color: #334155; line-height: 1.6; font-size: 16px; }
        .coupon-box { background-color: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 25px; text-align: center; margin: 30px 0; }
        .coupon-code { display: inline-block; background-color: #2563eb; color: #ffffff; font-size: 22px; font-weight: 800; padding: 12px 25px; border-radius: 8px; letter-spacing: 2px; margin-bottom: 15px; }
        .discount-text { font-size: 18px; font-weight: 700; color: #0f172a; margin: 0; }
        .expiry-text { font-size: 13px; color: #64748b; margin-top: 10px; }
        .footer { text-align: center; padding: 20px 30px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 13px; color: #64748b; }
        @media screen and (max-width: 600px) { .main { border-radius: 0; } .content { padding: 30px 20px; } }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td class="header">
                    <h1>Special Offer Inside!</h1>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <p>Hi <strong>{{ $coupon->user->name }}</strong>,</p>
                    <p>We have great news! A special promotional coupon has been assigned to your account. You can use this code on your next purchase to save big.</p>
                    
                    <div class="coupon-box">
                        <div class="coupon-code">{{ $coupon->code }}</div>
                        <p class="discount-text">
                            Gets you 
                            <span style="color: #2563eb;">
                                @if($coupon->discount_type === 'percentage')
                                    {{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }}% OFF
                                @else
                                    ₹{{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }} OFF
                                @endif
                            </span>
                        </p>
                        @if($coupon->expires_at)
                            <p class="expiry-text">Hurry! Valid until {{ $coupon->expires_at->format('d M, Y') }}</p>
                        @else
                            <p class="expiry-text">This coupon has lifetime validity.</p>
                        @endif
                    </div>

                    <p>To redeem, simply apply the code during checkout.</p>
                    <p style="margin-top: 30px;">Best regards,<br>The Team</p>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    &copy; {{ date('Y') }} All rights reserved.
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
