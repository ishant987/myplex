<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Frontend (Website & Api) Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during api for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */



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
            'name' => "The name field is required.",
            'f_name' => "The first name field is required.",
            'l_name' => 'The Last name field is required.',
            'email' => 'The email field is required.',
            'message' => 'The message field is required.',

            'aet_id' => 'The topic field is required.',
            'aeq_id' => 'The Question ID is required.',

            'image' => 'The image field is required.',
            'video_file' => 'The video file field is required.',
            'youtube_code' => 'The youtube share link field is required.',
        ],

        'email' => 'The email must be a valid email address.',
        'confirm_password_txt' => 'This does not match with your password',
        'img_file_upload_type' => "The attachment must be a file of type image (jpeg/jpg and png).",
        'img_file_upload_max_sz' => "The maximum file size to upload is 2MB (2048 KB). Try to reduce its resolution to make it under 2MB",
        'img_file_upload_max_sz5' => "The maximum file size to upload is 5MB (5120 KB). Try to reduce its resolution to make it under 5MB",
        'vid_file_upload_max_sz100' => "Maximum file size to upload is 100MB (102400 KB). Try to reduce size to make it under 100MB",
        'cr_password' => "The provided current password does not match.",
        'invitation_email' => 'Invitation Email is not valid.',
        'invalid_status' => 'Status is not valid.',
        'email_exist' => 'This Email already exists in the system',
        'phone_exist' => 'This Phone number already exists in the system',

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
        'other_topic_required' => 'Topic title is required.',
        'img_ext' => 'JPEG / JPG or PNG image.',
        'vid_ext' => 'MP4 video.',
    ],

    'success' => [
        'reset_password_save' => "Your password has been updated successfully.",
        'user_update' => "User data updated successfully.",

        'question_save' => "Thank you for submitting the question.",
        'answer_save' => "Thank you for answering the question.",
        'draft_answer_save' => "Your answer saved as a draft.",

        'like' => "Successfully liked.",
        'unlike' => "Successfully unlike.",
    ],

    'info' => [
        'img_file' => 'Upload only JPEG/JPG and PNG image, Size should be under 2MB (2048 KB).',
    ],

    'warning' => [],

    'no_results_txt' => 'No Results',
];
