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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' =>[
        'STRIPE_KEY' =>'pk_test_51HWGI7AEX4dqjMHKVkWjzWAQ4v683p4iWGRlw9wPEn0IfoUCjoxpoC00cYE04fzVzwBOASt5GxvqujhTLX4pN5oB00qC6qLvx1',null ,
        'STRIPE_SECRET' =>'sk_test_51HWGI7AEX4dqjMHKn3tpx0BSgLaWareo5dZ7zSBQjLnlsx4XBmGNflMxYc7SJsaNUsZQcrsHKOMPCIZFiy2xv77g00ndxNeFTs',null ,
    ]

];
