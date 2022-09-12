<?php

return [

    /*
    |--------------------------------------------------------------------------
    | News Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during common for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
    'label_txt' => 'News',

    'all_txt' => 'All News',
    'add_txt' => 'Add News',
    'edit_txt' => 'Edit News',

    'media_txt' => 'Media',
    'source_txt' => 'News Source',
    'source_link' => 'News Link',
    'video_from_txt' => 'Video From',
    'video_file_txt' => 'Video File',
    'youtube_code_txt' => 'YouTube Share Link',
    'video_image_txt' => 'Video Cover Image',

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
            'image' => 'The image field is required.',
            'video_from' => 'The video from field is required.',
            'video_file' => 'The video file field is required.',
            'youtube_code' => 'The youtube share link field is required.',
        ],
        'youtube_code_url_err_msg' => 'Put valid youtube SHARE link with http:// or https://. Ex. https://youtu.be/YNTR1uuGyzE',
    ],

    'error' => [
        
    ],

    'success' => [
        
    ],

    'info' => [
        'image' => '1.) Supported image type:- JPG / JPEG and PNG<br>
                    2.) Image Size should be under 2MB (2048 KB).<br>
                    3.) Image should be landscape type(width:height=16:9 aspect ratio)<br>
                    4.) For a quick check to see if the image is 16:9 Landscape, multiply Image width * 0.5625 for the required image height.<br>
                    5.) Recommended Min. image resolution = 960W * 540H (pixels)<br>
                    6.) Recommended Max. image resolution = 1920W * 1080H (pixels)<br>
                    Please note – the image placeholder does not auto stretch images to fit.',
        'video' => 'Upload only MP4 file and size should be under 100MB (102400 KB).',
        'youtube_code' => 'Put valid youtube SHARE link with http:// or https://. Ex. https://youtu.be/YNTR1uuGyzE',

        'video_image' => '1.) You need to upload a designed cover image for local video.<br>
                    2.) May upload the designed cover image for youtube else automatically get from the youtube.<br>
                    3.) Supported image type:- JPG / JPEG and PNG.<br>
                    4.) Image size should be under 2MB (2048 KB).<br>
                    5.) Image should be landscape type(width:height=16:9 aspect ratio).<br>
                    6.) For a quick check to see if the image is 16:9 landscape, multiply image width * 0.5625 for the required image height.<br>
                    7.) Recommended Min. image resolution = 960W * 540H (pixels).<br>
                    8.) Recommended Max. image resolution = 1920W * 1080H (pixels).<br>
                    Please note – the image placeholder does not auto stretch images to fit.',
    ],

    'warning' => [

    ],

];
