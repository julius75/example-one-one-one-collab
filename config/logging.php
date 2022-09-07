<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'slack'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'quickfixes' => [
            'driver' => 'single',
            'path' => storage_path('logs/fixes.log'),
            'level' => 'debug',
        ],

        'insuranceSettlement' => [
            'driver' => 'single',
            'path' => storage_path('logs/insuranceSettlement.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'slack' => [
            'driver' => env('SLACk_LOG_DRIVER', 'slack'),
            'url' => env('LOG_SLACK_WEBHOOK_URL'), // https://hooks.slack.com/services/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
            'username' => env('APP_NAME', 'Laravel') . ' log',
            'emoji' => ':boom:',
            'level' => env('LOG_SLACK_LEVEL', 'error'),
        ],

        'emails' => [
            'driver' => 'single',
            'path' => storage_path('logs/emails.log'),
            'level' => 'debug',
        ],

        'accounting-errors' => [
            'driver' => 'single',
            'path' => storage_path('logs/accounting_logs.log'),
            'level' => 'debug',
        ],

        'user_error_logs' => [
            'driver' => 'single',
            'path' => storage_path('logs/user_error_logs.log'),
            'level' => 'debug',
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        'db_changes' => [
            'driver' => 'daily',
            'path' => storage_path('logs/db_changes.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'sync_updates' => [
            'driver' => 'daily',
            'path' => storage_path('logs/sync_updates.log'),
            'level' => 'debug',
            'days' => 14,
        ],

        'auto_backups' => [
            'driver' => 'daily',
            'path' => storage_path('logs/auto_backups.log'),
            'level' => 'debug',
            'days' => 14,
        ],
    ],

];
