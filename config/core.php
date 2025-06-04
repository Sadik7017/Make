<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Module Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the settings for the Core module.
    |
    */

    'name' => 'Core',
    'description' => 'Core module for the application',
    'version' => '1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Cache settings for the module.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // 1 hour
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | Pagination settings for the module.
    |
    */
    'pagination' => [
        'per_page' => 10,
        'max_per_page' => 100,
    ],
]; 