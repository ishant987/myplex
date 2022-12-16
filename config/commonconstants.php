<?php

return [
    'admin_prefix' => 'admin39',

    'setting_type_sbscp_stng' => 'subscription',
    'setting_type_general' => 'general',
    'setting_type_mail_stng' => 'mail_setting',
    'setting_type_options' => 'options',
    'setting_type_custom_stng' => 'custom',
    'setting_type_social_stng' => 'social',

    'setting_dir_name' => 'setting',
    'media_dir_name' => 'media',
    'blog_dir_name' => 'media',
    'blog_dir_name_front_end' => 'storage/media/',
    'user_dir_name' => 'user',
    'pdf_dir_name' => 'pdf',
    'raw_dir_name' => 'raw',
    'idc_del_dir_name' => 'indices_del',
    'news_dir_name' => 'news',
    'aeq_dir_name' => 'askexpert',

    'bool_true' => true,
    'bool_false' => false,
    'null' => null,
    'float_def' => '0.000000',

    'y_n_val' => [
        '1' => 'y',
        '2' => 'n',
    ],

    'cu_by_val' => [
        '1' => 'a',
        '2' => 'u',
    ],

    'def_super_admin_id' => 1,
    'def_super_adminrole_id' => 1,

    'def_sbsrbd_usr_grp_id' => 1,
    'def_faq_cat_id' => 1,
    'expert_group_id' => 2,
    'other_aet_id' => 1,

    'subscription_status_val' => [
        'value' => [
            '0' => 'a',
            '1' => 'e',
        ],
        'text' => [
            'a' => 'Active',
            'e' => 'Expired',
        ]
    ],

    'status_val' => [
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
    ],

    'db_dt_tm_frmt' => 'Y-m-d H:i:s',
    'db_dt_tm_frmt_sec' => 'Y-m-d H:i:00',
    'y_m_d_frmt' => 'Y-m-d',
    'd_m_y_frmt' => 'd-m-Y',
    'd_m_y_frmt2' => 'd/m/Y',
    'd_m_y_frmt3' => 'd.m.Y',
    'dt_tm_frmt' => 'd-m-Y-h-i-A',
    'dt_tm_frmt_dnld' => 'd-m-Y_h-i-s_A',
    'dt_tm_frmt2' => 'd-m-Y H:i:s',
    'dt_tm_frmt3' => 'd-m-Y h:i a',
    'dt_tm_report_frmt' => 'dd-mm-yyyy h:mm:ss',
    'dt_tm_frnt_frmt' => 'd M Y \a\t h:i A',
    'dt_frmt' => 'jS F Y',
    'dt_frmt2' => 'l, j M Y',
    'tm_frmt' => 'h-i-A',
    'tm_frmt2' => 'H:i:s',
    'tm_frmt3' => 'h:i A',

    'pagination_no' => 20,
    'pagination_no_front' => 10,
    'gen_usr_password_no' => 6,

    'img_upld_max_size' => 2048,
    'vdo_upld_max_size' => 102400,
    'media_upld_max_size' => 15360,
    'pdf_upld_max_size' => 102400,

    'bdy_data_spltr' => '-',
    'qs_img_data_spltr' => '-_-',
    'comma_sign' => ',',
    'colon_sign' => ':',

    'target_opt1' => '_blank',

    'media_type' => [
        'value' => [
            '0' => 'i',
            '1' => 'v',
        ],
        'text' => [
            'i' => 'Image',
            'v' => 'Video',
        ]
    ],

    'video_type' => [
        'value' => [
            '0' => 'l',
            '1' => 'y',
        ],
        'text' => [
            'l' => 'Local',
            'y' => 'YouTube',
        ]
    ],

    'field_type_image' => 'image',
    'field_type_text' => 'text',

    'uopt_typ_opt1_val' => 'g',
    'uopt_typ_opt2_val' => 'n',

    'category_type' => [
        'value' => [
            '1' => 'f',
        ],
        'text' => [
            'f' => 'FAQ',
        ]
    ],

    'medium' => [
        'value' => [
            '0' => 'a',
            '1' => 'w',
            '2' => 'ap',
            '3' => 'ad',
            '4' => 's',
        ],
        'text' => [
            'a' => 'All',
            'w' => 'Website',
            'ap' => 'App',
            'ad' => 'Admin',
            's' => 'System',
        ]
    ],

    'like_type' => [
        'value' => [
            '0' => 'ae',
            '1' => 'aea',
        ],
        'text' => [
            'ae' => 'Ask Expert',
            'aea' => 'Ask Expert Answer',
        ]
    ],

    'enquiry_type' => [
        'value' => [
            '0' => 'c',
            '1' => 'qc',
        ],
        'text' => [
            'c' => 'Contact',
            'qc' => 'Quick Contact',
        ]
    ],

    'plan_type' => [
        'value' => [
            '0' => 'ff',
            '1' => 'lp',
        ],
        'text' => [
            'ff' => 'Free Forever',
            'lp' => 'Limited Period',
        ]
    ],

    'module_user_rel_type' => [
        'value' => [
            '0' => 'aet',
        ],
        'text' => [
            'aet' => 'Ask Expert Topic',
        ]
    ],

    'nfo_monitor_type' => [
        'value' => [
            '0' => 'f',
            '1' => 'l',
            '2' => 't',
        ],
        'text' => [
            'f' => 'File',
            'l' => 'Link',
            't' => 'Text',
        ]
    ],

    'active_passive' => [
        'A' => 'Active',
        'P' => 'Passive',
    ],

    'monthly_performance' => [
        'Y' => 'Yes',
        'N' => 'No',
    ],

    'recaptcha' => [
        'site_key' => '6LcPwtEfAAAAAA5UJ3HHwBfawn7Zdf7Auag25Ksz',
        'secret_key' => '6LcPwtEfAAAAAFJzoUz5-HiFjOJwAvzILQiaT-MJ',
        'score' => '0.5',
    ],

    'razorpay' => [
        'key' => '',
        'secret' => '',
    ],
];
