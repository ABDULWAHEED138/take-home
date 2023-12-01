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
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'article' => [
        'new_york_time_api_endpoint' => env('NEW_YORK_TIME_API_ENDPOINT'),
        'new_york_time_api_key'      => env('NEW_YORK_TIME_API_KEY'),
        'news_api_endpoint'          => env('NEWS_API_ENDPOINT'),
        'news_api_key'               => env('NEWS_API_KEY'),
        'the_guardian_api_endpoint'  => env('THE_GUARDIAN_API_ENDPOINT'),
        'the_guardian_api_key'       => env('THE_GUARDIAN_API_KEY'),
    ]

];
