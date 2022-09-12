<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Api Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during api for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    // 'null_txt' => null,

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages. These are application API specific
    | and used for only this panel.
    |
    */

    'validation' => [
        'required' => [

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during common for various
    | messages that we need to display to the user. These are application specific and
    | used for only this panel.
    |
    */

    'error' => [
        'invld_token' => "Token expired, Please login again.",
        'intrnl_serv' => 'Internal server error.',
        'unauth' => "Unauthorised",

        'no_data_fcm_updt' => "No data found for FCM key updation.",
    ],

    'success' => [
        'api_dt_rtrv' => 'Data retrieved successfully.',

        'fcm_data_updt' => 'FCM key successfully updated.',
    ],

    'info' => [
        'fcm_data_updt' => 'FCM key not changed, Data already updated.',
    ],

    'warning' => [
        
    ],
];
