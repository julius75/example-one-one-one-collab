<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, SparkPost and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', '203962672:AAGYzxSMD6oXtoBbTYhGm4dqUWrrFE6FRIE')
    ],
    
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    'stripe' => [
        'model' => \Ignite\Users\Entities\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],
    
    'rollbar' => [
        'access_token' => env('ROLLBAR_TOKEN'),
        'level' => env('ROLLBAR_LEVEL'),
    ],
    
    'nexmo' => [
        'key' => env('NEXMO_KEY'),
        'secret' => env('NEXMO_SECRET'),
        'sms_from' => env('NEXMO_FROM', '15556666666'),
    ],
    
    'africastalking' => [
        'mode' => env('AFRICASTALKING_MODE', "sandbox"), // live
        'live_username' => env('AFRICASTALKING_LIVE_USERNAME'),
        'live_api_key' => env('AFRICASTALKING_LIVE_API_KEY'),
        'sandbox_username' => env('AFRICASTALKING_SANDBOX_USERNAME', "sandbox"),
        'sandbox_api_key' => env('AFRICASTALKING_SANDBOX_API_KEY'),
    ],
    
];
