<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Razorpay Payment Gateway
    |--------------------------------------------------------------------------
    */
    'razorpay' => [
        'key' => env('RAZORPAY_KEY'),
        'secret' => env('RAZORPAY_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Paytm Payment Gateway
    |--------------------------------------------------------------------------
    */
    'paytm' => [
        'merchant_id' => env('PAYTM_MERCHANT_ID'),
        'merchant_key' => env('PAYTM_MERCHANT_KEY'),
        'website' => env('PAYTM_WEBSITE', 'DEFAULT'),
        'industry_type' => env('PAYTM_INDUSTRY_TYPE', 'Retail'),
        'channel' => env('PAYTM_CHANNEL', 'WEB'),
        'environment' => env('PAYTM_ENVIRONMENT', 'production'), // production or staging
    ],

    /*
    |--------------------------------------------------------------------------
    | Twilio (Call Masking)
    |--------------------------------------------------------------------------
    */
    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'phone_number' => env('TWILIO_PHONE_NUMBER'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Exotel (Call Masking - India)
    |--------------------------------------------------------------------------
    */
    'exotel' => [
        'sid' => env('EXOTEL_SID'),
        'token' => env('EXOTEL_TOKEN'),
        'phone_number' => env('EXOTEL_PHONE_NUMBER'),
        'subdomain' => env('EXOTEL_SUBDOMAIN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business API
    |--------------------------------------------------------------------------
    */
    'whatsapp' => [
        'api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v17.0'),
        'api_token' => env('WHATSAPP_API_TOKEN'),
        'business_phone_id' => env('WHATSAPP_BUSINESS_PHONE_ID'),
        'verify_token' => env('WHATSAPP_VERIFY_TOKEN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Gateway (MSG91 or Twilio SMS)
    |--------------------------------------------------------------------------
    */
    'sms' => [
        'provider' => env('SMS_PROVIDER', 'msg91'), // msg91, twilio, gupshup
        'msg91' => [
            'auth_key' => env('MSG91_AUTH_KEY'),
            'sender_id' => env('MSG91_SENDER_ID'),
            'route' => env('MSG91_ROUTE', '4'),
        ],
        'twilio' => [
            'sid' => env('TWILIO_SID'),
            'token' => env('TWILIO_TOKEN'),
            'phone_number' => env('TWILIO_PHONE_NUMBER'),
        ],
    ],

];
