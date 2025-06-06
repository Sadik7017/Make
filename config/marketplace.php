<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Marketplace Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration settings for the marketplace.
    |
    */

    'name' => 'Module Marketplace',
    'description' => 'Marketplace for discovering and installing modules',

    /*
    |--------------------------------------------------------------------------
    | Local Module Settings
    |--------------------------------------------------------------------------
    |
    | Settings for local module discovery and management.
    |
    */
    'local' => [
        'enabled' => true,
        'path' => base_path('packages/modules'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache settings for the marketplace.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Settings for module installation and updates.
    |
    */
    'modules' => [
        'backup' => [
            'enabled' => true,
            'path' => storage_path('app/modules/backups'),
        ],
        'download' => [
            'path' => storage_path('app/modules/downloads'),
        ],
        'extract' => [
            'path' => base_path('packages/modules'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Settings for module update notifications.
    |
    */
    'notifications' => [
        'enabled' => true,
        'channels' => [
            'mail',
            'database',
        ],
        'recipients' => [
            'admin@example.com',
        ],
    ],
]; 