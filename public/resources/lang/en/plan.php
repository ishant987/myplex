<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Plans Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during common for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'label_txt' => 'Plans',

    'all_txt' => 'All Plans',
    'add_txt' => 'Add Plan',
    'edit_txt' => 'Edit Plan',

    'type_txt' => 'Plan Type',
    'name_txt' => 'Plan Name',
    'amount_txt' => 'Amount',
    'duration_txt' => 'Plan Duration',
    'duration_name_txt' => 'Plan Duration Name',
    'free_trial_txt' => 'Free Trial',
    'show_website_app_txt' => 'Show on Website & App',
    'no_of_tests_txt' => 'No. of Tests',

    'start_date_txt' => 'Start Date',
    'end_date_txt' => 'End Date',
    'label2_txt' => 'Plan / Subscription',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages. These are application module
    | specific and used for only this module.
    |
    */

    'validation' => [
        'required' => [
            'plan_duration' => 'The plan duration field is required when plan type is limited period.',
        ],
    ],

    'error' => [
        
    ],

    'success' => [

    ],

    'info' => [
        'not_change' => 'Can’t change later.',
        'plan_duration' => 'Must be in days. Can’t change later.',
        'no_of_tests' => '-1 for unlimited.',
    ],

    'warning' => [
        'free_trial' => 'Already a free trial added, you can not add more than one free trial.',
        'plan_type' => 'Already a free forever plan type was added, you can not add more than one free forever plan type.',
    ],

];
