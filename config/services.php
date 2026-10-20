<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
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
    | Xendit Payment Gateway
    |--------------------------------------------------------------------------
    |
    | Kunci dibaca dari .env.example: XENDIT_SECRET_KEY, XENDIT_WEBHOOK_SECRET,
    | XENDIT_SUCCESS_URL, XENDIT_FAILURE_URL.
    |
    */

    'xendit' => [
        'secret' => env('XENDIT_SECRET_KEY'),
        'webhook_secret' => env('XENDIT_WEBHOOK_SECRET'),
        'success_url' => env('XENDIT_SUCCESS_URL', env('APP_URL') . '/payment-success'),
        'failure_url' => env('XENDIT_FAILURE_URL', env('APP_URL') . '/payment-failed'),
    ],

];
