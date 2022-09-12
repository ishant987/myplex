<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ask Expert Sections Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during common for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'topic' => [
        'label_txt' => 'Topic',

        'all_txt' => 'All Topics',
        'add_txt' => 'Add Topic',
        'edit_txt' => 'Edit Topic',

        'flds_hide' => [
            'c_order' => false,
            'image' => true,
        ],

        'available_usr_txt' => 'Available Experts',
        'selected_usr_txt' => 'Selected Experts',
    ],

    'question' => [
        'label_txt' => 'Question',

        'all_txt' => 'All Questions',
        'add_txt' => 'Add Question',
        'edit_txt' => 'Edit Question',
    ],

    'answer' => [
        'label_txt' => 'Answer',

        'all_txt' => 'All Answers',
        'add_txt' => 'Add Answer',
        'edit_txt' => 'Edit Answer',

        'status' => [
            '1' => 'Enabled',
            '2' => 'Disabled',
            '3' => 'Draft',
        ],
    ],

    'answer_list_txt' => 'Answer List',
    'pnl_of_exprts_txt' => 'Panel of Experts',
    'question_txt' => 'Question',
    'topic_txt' => 'Topic',
    'topics_txt' => 'Topics',
    'topic_other_txt' => 'Please Specify Other',
    'ask_question_txt' => 'Ask Question',
    'search_by_topic_txt' => 'Search By Topic',
    'answer_txt' => 'Answer',
    'expert_txt' => 'Expert',
    'expert_pfx_title_txt' => 'Ask An Experts',
    'draft_txt' => 'Draft',
    'drafts_txt' => 'Drafts',
    'add_answer' => 'Add Answer',
    'most_expert_ans_txt' => 'Most Expert Answered',
    'most_ans_txt' => 'Most Answered',
    'most_liked_txt' => 'Most Liked',
    'picture1_txt' => 'Picture 1',
    'picture2_txt' => 'Picture 2',
    'picture3_txt' => 'Picture 3',
    'video_type_txt' => 'Video Type',
    'local_file_txt' => 'Local File',
    'yt_share_link_text' => 'Youtube Share Link',
    'yt_share_info_txt' => 'Put valid youtube share link with http:// or https://. Ex. https://youtu.be/SfdWE445dsd',
    'local_video_info_txt' => 'Uploded only MP4 video file and size should be under 100MB.',
    'picture_info_txt' => 'Upload only JPEG / JPG and PNG image and size should be under 5MB.',

    'total_expert_ans_txt' => 'Total Expert Answered',
    'total_ans_txt' => 'Total Answered',
    'total_liked_txt' => 'Total Liked',
    'edit_draft_txt' => 'Edit Draft',
    'dlt_all_draft_txt' => 'Delete All Drafts',
    'dlt_draft_txt' => 'Delete Draft',

    'title_char_limit' => '140',
    'descp_char_limit' => '300',

    'pictures_txt' => 'Pictures',
    'video_txt' => 'Video',

    'aeq_txt' => 'Ask Expert Questions',

    'mail' => [
        'from_name' => 'Ask Experts',
        'answer' => [
            'subject' => 'Answered your Question' . __('common.mail_sbjct_sfx'),
            'body_txt1' => 'answered your question',
            'body_txt2' => 'to see if you wish.',
        ],
        'question' => [
            'subject' => 'Ask Experts Question' . __('common.mail_sbjct_sfx'),
            'mail_p_pfx' => 'A new question comes from ',
            'mail_p_sfx' => ' to login into CMS and review.',
        ],
    ],

    'ntf_subtitle_sfx' => ' answered your question',


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
            'question' => 'Please select question',
            'answer' => 'Please enter answer',
        ],
    ],

    'error' => [
        'question_not_found' => 'Question was not found'
    ],

    'success' => [],

    'info' => [
        'topic_featured_img' => '1. Upload only JPG / JPEG and PNG image.<br>
                2. Image should be 1:1 aspect ratio resolutions.<br> 
                3. For best view image size should be in W=136px, H=136px and under 250KB.',
    ],

    'warning' => [
        'delete_draft' => 'Are you sure to delete it?',
    ],
];
