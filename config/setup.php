<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Password salt Defaults
    |--------------------------------------------------------------------------
    |
    | This option sets default salt for password encryption.
    |
    */
    'salt' => env("EMC_PASSWORD_SALT", "default_!#%SALT"),

    /*
    |--------------------------------------------------------------------------
    | Login lock after too many failed attempts
    |--------------------------------------------------------------------------
    */
    'lock_params' => [
        'attempts' => 3,    //number of failed attempts before lock
        'time' => 2,        //time before unlocking in minutes
    ],
    "http_codes" => [
        'PAGE_NOT_FOUND' => 404,
        'PAGE_FOUND' => 302,
        'CREATED' => 201
    ]

];
