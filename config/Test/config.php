<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Test Module Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the configuration settings for the Test module.
    |
    */

    'name' => 'Test',
    'version' => '1.0.0',
    'description' => 'Test module for the application',
    'author' => 'Your Name',
    'email' => 'your.email@example.com',
    'website' => 'https://example.com',

    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the settings for the Test module.
    |
    */

    'settings' => [
        'enabled' => true,
        'debug' => false,
        'cache' => true,
        'cache_ttl' => 3600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Dependencies
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the dependencies for the Test module.
    |
    */

    'dependencies' => [
        // 'Core',
        // 'Auth',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Permissions
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the permissions for the Test module.
    |
    */

    'permissions' => [
        'view' => 'View Test',
        'create' => 'Create Test',
        'edit' => 'Edit Test',
        'delete' => 'Delete Test',
    ],
]; 