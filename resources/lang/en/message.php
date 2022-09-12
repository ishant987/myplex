<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during common for various
    | messages that we need to display to the user. These are application specific and
    | used for all panels (Admin / API / Website).
    |
    */

    'error' => [
        'no_data' => 'No data found.',

        'recaptcha' => 'Looklike you are a bot not human.',
        'request_validation' => 'Validation Error.',
        'req_data_not_found' => 'Required data not found, Contact administrator.',
        'required_fld' => 'Please filled up required fields.',
        'something_wrong' => 'Something wrong, Contact administrator.',
        'email_send' => 'Email not send, Contact administrator.',
        'saved' => 'Data not saved, Contact administrator.',
        'delete' => 'Data not deleted, Contact administrator.',
        'no_data_delete' => 'No data available for deletion.',

        'data_saved' => 'Data not saved, Contact administrator.',
        'sel_data' => 'Select/Fill the data to save.',
        'data_delete' => 'Data not deleted, Contact administrator.',

        'update' => 'Your updation has been failed, Contact administrator.',
        'rollback' => 'Rollback, Contact administrator.',
        'file_upload' => 'File not uploaded, Contact administrator.',
        'uploaded_file_not_exist' => 'Uploaded file not exist, Contact administrator.',
        'file_exist' => 'File already exist, clear cache first then retry.',
        'img_upload' => 'Image not uploaded, Contact administrator.',
        'vdo_upload' => 'Video not uploaded, Contact administrator.',
        'pdf_upload' => 'PDF not uploaded, Contact administrator.',
        'img_upload_max_sz' => 'Maximum file size to upload is 2MB (2048 KB). Try to reduce size to make it under 2MB',
        'vdo_upload_max_sz' => 'Maximum file size to upload is 100MB (102400 KB). Try to reduce size to make it under 100MB',
        'media_upload_max_sz' => 'Maximum file size to upload is 15MB (15360 KB). Try to reduce size to make it under 15MB',
        'pdf_upload_max_sz' => 'Maximum file size to upload is 50MB (51200 KB). Try to reduce size to make it under 50MB',
        'valid_url' => 'Put valid url with http:// or https://',
        'slug' => 'Slug name already exist, Please add another slug name.',
        'code_verify' => 'The verification code is incorrect.',
        'social_access_token' => 'Social media access token is unauthorised.',
        'data_exist' => 'Data already inserted.',

        'usr_not_found' => "No record found in our database. Please double check the entered value.",
        'usr_not_rgstrd' => "You are not registered with us. Please do sign up.",
        'usr_sub_exp' => "Please buy a subscription.",

        'values_ready' => "No values ready for publishing, please upload values then publish.",
        'values_published' => "Unable to fetch last published date, Contact administrator.",
        'data_publish' => 'Data not publish, Contact administrator.',
    ],

    'success' => [
        'add' => 'Data added successfully.',
        'update' => 'Data updated successfully.',
        'delete' => 'Data deleted successfully.',
        'saved' => 'Data saved successfully.',
        'email_send' => 'Email sent successfully.',
        'code_verify' => 'Code verified successfully.',

        'login' => "Login successfully.",
        'signup' => "Thank you for signing up",

        'logout' => "Logout successfully.",

        'saved_download_file' => 'Data saved successfully, You can download the error file from clicking below "Download Error File" button.',
        'data_publish' => 'Data published successfully.',

        'newsletter_add' => "Thank you for signing up.",
        'newsletter_exist' => "You already subscribed to our newsletter.",

        'contact_form_send' => "Your message has been sent."
    ],

    'info' => [
        'no_change' => 'No changes you made, Data already updated.',
        'already_reg' => "You already signup with us, you must login.",
        'search_blank' => "Type something to get the search result.",
        'search_no_data' => "No search result found, Try with some other keyword.",
        'autocomplete' => 'Start typing to auto complete.',
        'select_filter' => 'No data available. Filter from above to get the data.',
    ],

    'warning' => [
        'data_inserted' => 'Data already inserted.',

        'acc_dsbld' => "Account disabled, Contact administrator.",
        'usr_not_aprvd' => "Your account approval is pending. Please wait and try after sometime.",

        'already_saved' => 'The data have already been saved for ',
        'must_be_continuous' => 'The data should be continuous. Last saved ',
        'must_be_save_tomorrow' => 'Today\'s data can only be saved tomorrow.',
        'error_file_not_exist' => 'Error file does not exist, may you already downloaded the file.',
        'dwnld_file_not_exist' => 'File does not exist, may you already downloaded the file.',
        'values_published' => "Something wrong with values ready and published dates, Contact administrator.",
        'already_published' => 'The data have already been published for ',
        'must_be_continuous_published' => 'The data should be continuous. Last published ',

        'validate_file_type' => 'File type not allowed',
    ],

    'confirm' => [
        'default' => 'Are you sure?',
        'save' => 'Are you sure you want to save the changes?',
        'cancel' => 'All changes will be lost. Continue?',
        'holiday' => 'Are you absolutely sure you want to save these values in the database as holidays?',
        'click_ok_txt' => 'Click Ok to Save...',
        'del_last_saved' => 'Are you absolutely sure you want to delete these values from the database?',
        'del_related_data_too' => 'Are you sure you want to remove it? If yes, also deleted others related data of these.',
    ],

    'data_not_available' => 'No data available.',

    'command_start_txt' => 'START: Command executing',
    'command_end_txt' => 'END: Command executing',

    'dwnld_deleted_indices' => 'to download the csv file of deleted indices which exist under the funds.',

    'mail' => [
        'member_birthday' => [
            'from_name' => "Birthday Wishes",
            'subject' => "Birthday Wishes" . __('common.mail_sbjct_sfx'),
            'body' => "The whole team at MyPlexus would like to wish you a very Happy Birthday. We hope you have a wonderful day and a great year ahead of yourself. We are there with you every part of the way!"
        ],
    ],
];
