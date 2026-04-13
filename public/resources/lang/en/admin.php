<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Admin Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during admin for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'success_ttl' => 'Success!',
    'error_ttl' => 'Error!',
    'warning_ttl' => 'Warning!',
    'info_ttl' => 'Info!',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages. These are application Admin specific
    | and used for only this panel.
    |
    */

    'validation' => [
        'required' => [
            'featured_img' => 'The featured image field is required.',
            'c_order' => 'The order field is required.',
            'role' => 'The role field is required.',
            'to_device' => 'The to (device type) field is required.',
            'to_user_group' => 'The to (available / selected user group) field is required.',
            'to' => 'The assigned to field is required.',
            'users' => 'The users field is required.',
            'user_groups' => 'The user group field is required.',
            'user_class' => 'The user class field is required.',
            'template' => 'The template field is required.',

            'ft_id' => 'The scheme type field is required.',
            'idc_id' => 'The benchmark field is required.',
            'aa_col1_value' => 'The asset allocation 1st column value field is required.',
            'aa_col1_text' => 'The asset allocation 1st column text field is required.',
            'aa_col2_value' => 'The asset allocation 2nd column value field is required.',
            'aa_col2_text' => 'The asset allocation 2nd column text field is required.',
            'ces_row1_col1_text' => 'The comparable existing schemes 1st row 1st column text field is required.',
            'ces_row1_col2_text' => 'The comparable existing schemes 1st row 2nd column text field is required.',
            'ces_row1_col3_text' => 'The comparable existing schemes 1st row 3rd column text field is required.',
            'ces_row2_col1_text' => 'The comparable existing schemes 2nd row 1st column text field is required.',
            'ces_row2_col2_text' => 'The comparable existing schemes 2nd row 2nd column text field is required.',
            'ces_row2_col3_text' => 'The comparable existing schemes 2nd row 3rd column text field is required.',
        ],
        'integer' => [
            'c_order' => 'The order field must be an integer.',
            'template_int' => 'The template field must be an integer.',
        ],
        'unique' => [],

        'fcm_key' => 'The fcm key field is required when push notification status is yes.',
        'dup_scrip_name' => 'Already the same scrip name and actual scrip added.',
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
        'admin_permission' => "You don't have permission to access this.",
        'clear_cache' => "Unable to clear the cache, Contact administrator.",
    ],

    'success' => [
        'clear_cache' => 'Cache cleared Successfully.'
    ],

    'info' => [
        'add_slug' => 'This name may show up in your URLs, e.g. /toys. Just click on the above field and this will automatically take data from above.',
        'edit_slug' => 'This name may show up in your URLs, e.g. /toys. Normally avoid changing this.',
        'descp' => 'Hit enter for new line.',
        'valid_url' => 'Put valid url with http:// or https://',
        'featured_img' => '1. Upload only JPEG and PNG image.<br>
                            2. To load fast, size should be under 250 KB.',
        'def_pdf' => '1. Upload only PDF file.<br>
                2. Size should be under 50MB (51200 KB).',
        'link_target' => '_blank for open link in a new window and _self for open link in a same window.',
        'number' => 'Put valid number like 1, 2, etc.',
        'year' => 'Put valid year like 2013, 2014, etc.',
        'secret' => 'This is used for publishing the uploaded values.',
        'prof_pic' => '1. Upload only JPG / JPEG and PNG image.<br>
                2. Image resolution should be in 250W * 250H (pixels).<br>
                3. To load fast, size should be under 250 KB.',

        'excel_file_format' => 'Supports only xls / xlsx file format.',
    ],

    'warning' => [],

    'confirm' => [
        'clear_cache' => 'Are you sure you want to clear cache?',
    ],

    'username_txt' => 'Username',
    'password_txt' => 'Password',

    'mdfy_by_me_txt' => 'Me',
    'mdfy_by_def_spr_admn_txt' => 'Super Admin',

    'action_txt' => 'Action',
    'list_txt' => 'List',
    'add_new_txt' => 'Add New',
    'edit_txt' => 'Edit',
    'view_txt' => 'View',
    'delete_txt' => 'Delete',
    'remove_txt' => 'Remove',
    'multiple_delete_txt' => 'Multiple Delete',
    'download_img_txt' => 'Download Images',
    'submit_txt' => 'Submit',
    'generate_txt' => 'Generate',
    'deletelist_txt' => 'Delete List',
    'draftlist_txt' => 'Draft List',
    'confirm_n_save_txt' => 'Confirm & Save',
    'save_txt' => 'Save',
    'cancel_txt' => 'Cancel',
    'export_txt' => 'Export',
    'download_xls_txt' => 'Download XLS',
    'filter_txt' => 'Filter',
    'reset_txt' => 'Reset',
    'add_more_txt' => 'Add More',
    'browse_media_txt' => 'Browse Media',
    'remove_media_txt' => 'Remove Media',
    'see_all_txt' => 'See All',
    'recent_txt' => 'Recent',
    'upload_txt' => 'Upload',
    'load_previous_txt' => 'Load Previous Values for Holiday',
    'save_new_txt' => 'Save All Values to Database',
    'save_holiday_txt' => 'Save All Values to Database as Holiday',
    'del_last_saved_pfx_txt' => 'Delete Last (',
    'del_last_saved_sfx_txt' => ') Saved Data',

    'id_txt' => 'ID',
    'title_txt' => 'Title',
    'slug_txt' => 'Slug',
    'description_txt' => 'Description',
    'parent_txt' => 'Parent',
    'featured_img_txt' => 'Featured Image',
    'image_txt' => 'Image',
    'seo_title_txt' => 'SEO Title',
    'meta_key_txt' => 'Meta Keywords',
    'meta_descp_txt' => 'Meta Description',
    'order_txt' => 'Order',
    'status_txt' => 'Status',
    'note_txt' => 'Note',
    'mdfy_date_txt' => 'Modified Date',
    'mdfy_by_txt' => 'Modified By',
    'mdfy_user_txt' => 'Modified User',
    'added_date_txt' => 'Added Date',
    'added_by_txt' => 'Added By',
    'added_user_txt' => 'Added User',
    'serial_num_txt' => 'Sl. No.',

    'category_txt' => 'Category',
    'ntfy_users_txt' => 'Notify to users',
    'type_txt' => 'Type',
    'assigned_to_txt' => 'Assigned To',
    'user_group_txt' => 'User Group',
    'start_datetime_txt' => 'Start Datetime',
    'end_datetime_txt' => 'End Datetime',
    'link_txt' => 'Link',
    'link_text_txt' => 'Link Text',
    'target_txt' => 'Target',
    'template_txt' => 'Template',
    'medium_txt' => 'Medium',
    'created_medium_txt' => 'Created Medium',
    'updated_medium_txt' => 'Updated Medium',
    'file_txt' => 'File',
    'designation_txt' => 'Designation',
    'company_txt' => 'Company Name',
    'prof_pic_txt' => 'Profile Picture',

    'save_values_date_txt' => 'Save Values for Date',
    'last_save_txt' => 'Last Saved: ',
    'save_values_m_y_txt' => 'Save Values for Month and Year',
    'download_error_file_txt' => 'Download Error File',
    'entry_date_txt' => 'Entry Date',
    'value_txt' => 'Value',
    'percentage_txt' => 'Percentage',
    'percentage_change_txt' => 'Percentage Change',
    'holiday_txt' => 'Holiday',
    'publish_txt' => 'Data Published',
    'industry_txt' => 'Industry',
    'secret_txt' => 'Secret',
    'value_ready_txt' => 'Values Ready',
    'value_published_txt' => 'Values Published',
    'missing_date_txt' => 'Missing Date',
    'period_txt' => 'Period',

    'general_lbl' => 'General',
    'custom_fields_lbl' => 'Custom Fields',
    'attributes_lbl' => 'Attributes',
    'seo_lbl' => 'SEO',
    'publish_lbl' => 'Publish',
    'others_lbl' => 'Others',

    'def_none_txt' => '--None--',
    'def_drop_optn_styl1_txt' => '--please select--',
    'def_drop_optn_styl2_txt' => '--select--',
    'def_drop_optn_styl3_txt' => 'All',
    'def_drop_optn_styl4_txt' => 'Choose',
    'def_drop_optn_styl5_txt' => 'No Parent',
    'def_drop_optn_styl6_txt' => '---',
    'month_def_opt_txt' => '- Month -',
    'year_def_opt_txt' => '- Year -',

    'target_optn1_txt' => '_blank',
    'target_optn2_txt' => '_self',

    'previous_txt' => 'Previous',
    'next_txt' => 'Next',

    'available_ug_txt' => 'Available User Group',
    'selected_ug_txt' => 'Selected User Group',

    'available_usr_txt' => 'Available Users',
    'selected_usr_txt' => 'Selected Users',

    'sw_entry' => [
        'show_txt' => 'Show',
        'entries_txt' => 'entries',
        'options' => [
            'value' => [
                '0' => 20,
                '1' => 50,
                '2' => 100,
                '3' => 250,
                '4' => 500,
                '5' => 1000,
            ],
            'text' => [
                '0' => '20',
                '1' => '50',
                '2' => '100',
                '3' => '250',
                '4' => '500',
                '5' => '1000',
            ],
        ],
    ],

    'sort_txt' => 'Sort By',
    'order_by_txt' => 'Order By',

    'insertion_txt' => 'Insertion',

    'bulk_upload' => [
        'label_txt' => 'Bulk Upload',
        'add_manual_txt' => 'Add Manually',
        'add_manual_info' => 'Add all data manually and save',
        'select_draft_txt' => 'Select a draft list',
        'file_upload_txt' => 'File Upload',
        'file_upload_info' => 'Upload data through XLS file',

        'select_file_txt' => 'Select a file from your computer',
        'select_file_info' => 'You can import XLS file using this method. Allowed upto 5000 rows in an one time.',
        'file_format_info' => 'Supports only .XLS file format.',
        'demo_file_format_info' => ' to download demo file in XLS format.',
        'dwnld_csv_file_format_info' => ' to download upload csv file format.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Modules Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during application modules for various text,
    | labels, etc. that we need to display to the user. These are modules specific
    | and used for only this panel.
    |
    */

    'dashboard' => [
        'quick_box' => [
            '0' => 'All Order History',
            '1' => 'All Split Order History',
            '2' => 'All Full Order History',
            '3' => 'All Success Order History',
            '4' => 'All Cancelled Order History',
            '5' => 'All Ongoing Table Orders',
            '6' => 'All Food Items',
            '7' => 'All Tables',
        ],
        'recent_box' => [
            '0' => 'Order History',
            '1' => 'Tables',
            '2' => 'Food Items',
        ],
    ],

    'dashboard_txt' => 'Dashboard',
    'my_profile_txt' => 'My Profile',
    'edit_profile_txt' => 'Edit My Profile',
    'logout_txt' => 'Logout',

    'all_admn_user_txt' => 'All Users',
    'add_admn_user_txt' => 'Add User',
    'edit_admn_user_txt' => 'Edit User',
    'display_name_txt' => 'Display Name',
    'role_txt' => 'Role',
    'website_txt' => 'Website',

    'all_admnrole_user_txt' => 'All Admin User Roles',
    'add_admnrole_user_txt' => 'Add User Role',
    'edit_admnrole_user_txt' => 'Edit User Role',
    'rolename_txt' => 'Role Name',

    'settings' => [
        'general_txt' => 'General',
        'options_txt' => 'Options',
        'mail_txt' => 'Mail',
        'social_txt' => 'Social Settings',
        'custom_txt' => 'Custom Settings',
    ],

    'template' => [
        'all_txt' => 'All Template',
        'add_txt' => 'Add Template',
        'edit_txt' => 'Edit Template',

        'flds_hide' => [
            'descp' => false,
            'c_order' => true
        ],

        'class_name_txt' => 'Class Module Name',
    ],

    'customfield' => [
        'all_txt' => 'All Custom Fields',
        'add_txt' => 'Add Custom Field',
        'edit_txt' => 'Edit Custom Field',
        'show_txt' => 'Show Custom Field',
        'gt_txt' => 'Custom Field Groups',

        'fields_txt' => 'Fields',
        'total_fields_txt' => 'Total Fields',
        'field_label_txt' => 'Field Label',
        'field_name_txt' => 'Field Name',
        'field_type_txt' => 'Field Type',
        'field_for_txt' => 'Field For',
        'field_instrctns_txt' => 'Field Instructions',
        'field_options_txt' => 'Set Options',

        'page_template_info' => 'Be careful on selection of page template, once particular custom field`s type against template is saved. Then saved custom field can`t be modified / edited for other page template.',
        'field_label_info' => 'This is the name which will appear on the ADD / EDIT page',
        'field_name_info' => 'Single word, no spaces or special characters. Underscores and dashes are allowed',
        'field_instrctns_info' => 'Instructions for admin user, Shown when submitting data.',

        'grouptype' => [
            'all_txt' => 'All Group Types',
            'add_txt' => 'Add Group Type',
            'edit_txt' => 'Edit Group Type',
            'show_txt' => 'Show Group Type',
            'gtct_txt' => 'All Modules Templates',
            'sel_fldfor_txt' => 'Field For',
            'sel_fldtype_txt' => 'Field Type',
            'label_txt' => 'Field Label',
            'placeholder_txt' => 'Field Placeholder',
            'required_txt' => 'Is Field required',
            'description_txt' => 'Field Description',
            'instruction_txt' => 'Field Instruction',

            'class_name_txt' => 'Module',
            'template_for_txt' => 'Template',
            'classtemplate' => [
                'all_txt' => 'All Modules Template',
                'add_txt' => 'Add Module Template ',
                'edit_txt' => 'Edit module Template ',
                'show_txt' => 'Show Module Template ',
            ]
        ]
    ],

    'link' => [
        'menu_label_txt' => 'Links',
        'menu_url_txt' => 'URL',
        'menu_link_txt' => 'Link Text',
    ],

    'page' => [
        'all_txt' => 'All Pages',
        'add_txt' => 'Add Page',
        'edit_txt' => 'Edit Page',

        'flds_hide' => [
            'slug' => false,
            'image' => false,
            'parent' => false,
            'meta_title' => false,
            'meta_key' => false,
            'meta_descp' => false,
            'c_order' => false
        ],

        'menu_label_txt' => 'Pages',

        'note_info' => 'Show on hover under list page Title column. Just for knowing purpose that where this particular page used.'
    ],

    'menutype' => [
        'all_txt'   => 'All Menus',
        'add_txt'   => 'Add Menu',
        'edit_txt'  => 'Edit Menu',
        'title_txt' => 'Label',
        'slug_txt'  => 'Name',
        'menufor_txt'  => 'Menu For',
        'menu_select_txt'  => 'Select a menu to edit',

        'add_slug_info' => 'This menu name must be unique.',
        'add_menufor_info' => 'At a time only a single primary, sidebar, footer menu can preset in menu list',
    ],

    'menu' => [
        'all_txt' => 'All Menus',
        'add_txt' => 'Add Menu',
        'edit_txt' => 'Edit Menu',
        'add_to_menu_txt' => 'Add to menu',

        'add_block_label' => [],
    ],

    'cf' => [
        'a' => 'For both Website & App',
        'w' => 'For Website only',
        'ap' => 'For App only',
    ],

    'currency' => [
        'label_txt' => 'Currency',

        'all_txt' => 'All Currencies',
        'add_txt' => 'Add Currency',
        'edit_txt' => 'Edit Currency',

        'name_txt' => 'Currency Name',
        'url_txt' => 'Currency URL',

        'edit_daily_value_txt' => 'Edit Daily Currencies Values',

        'last_save_txt' => 'Last Saved',

        'list' => [
            'label_txt' => 'List Daily Currencies Values',

            'value_txt' => 'Value',
        ],

        'publish_label_txt' => 'Publish Daily Currencies Values',

        'missing' => [
            'label_txt' => 'Missing Currency',

            'upld_lbl_txt' => 'Upload Missing Currency Values',

            'currency_id' => 'Currency ID',
        ],

        'validation' => [
            'required' => [
                'name_txt' => 'The currency name field is required.'
            ],
        ],
    ],

    'indices' => [
        'label_txt' => 'Indices',

        'all_txt' => 'All Indices',
        'add_txt' => 'Add Indices',
        'edit_txt' => 'Edit Indices',

        'name_txt' => 'Index Name',
        'corelation_txt' => 'Index Corelation',

        'nocor' => [
            'label_txt' => 'No Correlation Indices',

            'all_txt' => 'All No Correlation Indices',
        ],

        'file_format_info' => 'Supports only .csv file format. Save as .csv before uploading.',

        'upld_daily_txt' => 'Upload Daily Indices Values',
        'list_upld_daily_txt' => 'List Uploaded Daily Indices Values',

        'value_txt' => 'Value',
        'label_readonly_txt' => 'Value (readonly)',

        'comp' => [
            'label_txt' => 'Indices Composition',

            'file_format_info' => 'Supports only .csv file format. Save as .csv before uploading.',

            'upld_lbl_txt' => 'Upload Monthly Indices Composition Values',

            'list_label_txt' => 'List Monthly Indices Composition Values',

            'publish_label_txt' => 'Publish Monthly Indices Composition Values',
        ],

        'list' => [
            'label_txt' => 'List Daily Indices Values',
        ],

        'publish_label_txt' => 'Publish Daily Indices Values',

        'missing' => [
            'label_txt' => 'Missing Indices',

            'upld_lbl_txt' => 'Upload Missing Indices Values',
        ],

        'validation' => [
            'required' => [
                'name_txt' => 'The index name field is required.',
                'corelation_txt' => 'The index corelation field is required.'
            ],
        ],
    ],

    'fundtype' => [
        'label_txt' => 'Fund Type',

        'all_txt' => 'All Fund Type',
        'add_txt' => 'Add Fund Type',
        'edit_txt' => 'Edit Fund Type',

        'name_txt' => 'Name',
        'active_passive_txt' => 'Active Passive',
        'monthly_performance_txt' => 'Monthly Performance',
    ],

    'fundterm' => [
        'label_txt' => 'Fund Term',

        'all_txt' => 'All Fund Term',
        'add_txt' => 'Add Fund Term',
        'edit_txt' => 'Edit Fund Term',

        'term_txt' => 'Term',
        'days_txt' => 'Days',
    ],

    'fund' => [
        'label_txt' => 'Funds',

        'all_txt' => 'All Funds',
        'add_txt' => 'Add Fund',
        'edit_txt' => 'Edit Fund',

        'name_txt' => 'Fund Name',
        'code_txt' => 'Fund Code',
        'corelation_txt' => 'Fund Corelation',
        'house_txt' => 'Fund House',
        'manager_txt' => 'Fund Manager',
        'type_txt' => 'Fund Type',
        'term_txt' => 'Fund Term',
        'index_txt' => 'Index',
        'classification_txt' => 'Classification',
        'face_value_txt' => 'Face Value',
        'risk_free_return_txt' => 'Risk Free Return',
        'opened_txt' => 'Fund Opened',
        'cost_txt' => 'Cost',

        'nocor' => [
            'label_txt' => 'No Correlation Funds',

            'all_txt' => 'All No Correlation Funds',
        ],

        'corpus_txt' => 'Corpus',
        'edit_corpus_txt' => 'Add a new funds for',
        'corpus_change_txt' => 'Corpus Change',

        'nav' => [
            'label_txt' => 'NAV',

            'file_format_info' => 'Supports only .txt file format. Download TXT file from <a href="https://www.amfiindia.com" class="b-b-primary text-primary" target="_blank">AMFI</a> and save as .txt before uploading.',

            'upld_daily_txt' => 'Upload Daily NAVs Values',
            'list_upld_daily_txt' => 'List Uploaded Daily NAVs Values',

            'label_readonly_txt' => 'NAV (readonly)',

            'list_label_txt' => 'List Daily NAVs Values',

            'publish_label_txt' => 'Publish Daily NAVs Values',
        ],

        'aums' => [
            'label_txt' => 'AUMs',

            'file_format_info' => 'Supports only .csv file format. Download EXCEL file from <a href="https://www.amfiindia.com" class="b-b-primary text-primary" target="_blank">AMFI</a> and save as .csv before uploading.',

            'upld_lbl_txt' => 'Upload Monthly AUMs Values',
            'list_lbl_txt' => 'List Uploaded Monthly AUMs Values',

            'no_of_funds_txt' => 'No of Funds',
            'in_lacs_txt' => 'AUM (in Lacs)',

            'list_label_txt' => 'List Monthly AUMs Values',

            'publish_label_txt' => 'Publish Monthly AUMs Values',
        ],

        'comp' => [
            'label_txt' => 'Fund Composition',

            'file_format_info' => 'Supports only .csv file format. Save as .csv before uploading.',

            'upld_lbl_txt' => 'Upload Monthly Fund Composition Values',

            'list_label_txt' => 'List Monthly Fund Composition Values',
            'idc_percentage_txt' => 'Indices Percentage',

            'publish_label_txt' => 'Publish Monthly Fund Composition Values',
        ],

        'missing' => [
            'label_txt' => 'Missing NAV',

            'upld_lbl_txt' => 'Upload Missing NAV Values',

            'scheme_txt' => 'Scheme',
        ],

        'validation' => [
            'required' => [
                'cor_txt' => 'The fund correlation field is required.'
            ],
            'cor_exist_txt' => 'The fund correlation has already been taken.'
        ],

    ],

    'mcapeps' => [
        'label_txt' => 'MCAP EPS',

        'file_format_info' => 'Supports only .csv file format. Save as .csv before uploading.',

        'upld_lbl_txt' => 'Upload Monthly MCAP EPS Values',

        'list_label_txt' => 'List Monthly MCAP EPS Values',
        'mcap_txt' => 'Market Cap',
        'eps_txt' => 'EPS',
        'pe_txt' => 'P/E',

        'publish_label_txt' => 'Publish Monthly MCAP EPS Values',
    ],

    'scrip' => [
        'label_txt' => 'Scrip Name',

        'all_txt' => 'All Scrips',
        'add_txt' => 'Add Scrip',
        'add_manual_txt' => 'Add Manually',
        'edit_txt' => 'Edit Scrip',

        'actual_txt' => 'Actual Scrip',

        'bulk_upload_hdng' => 'Upload Scrips List',

        'dashboard_label' => 'Scrip Master',
    ],

    'clear_cache_txt' => 'Clear Cache',

    'fundwatch' => [
        'label_txt' => 'Fund Watch',

        'all_txt' => 'All Fund Watch',
        'add_txt' => 'Add Fund Watch',
        'edit_txt' => 'Edit Fund Watch',

        'flds_hide' => [
            'c_order' => true
        ],
    ],

    'funddictionary' => [
        'label_txt' => 'Fund Dictionary',

        'all_txt' => 'All Fund Dictionary',
        'add_txt' => 'Add Fund Dictionary',
        'edit_txt' => 'Edit Fund Dictionary',
    ],

    'fundclassification' => [
        'label_txt' => 'Fund Classification',

        'all_txt' => 'All Fund Classification',
        'add_txt' => 'Add Fund Classification',
        'edit_txt' => 'Edit Fund Classification',

        'flds_hide' => [
            'c_order' => true
        ],
    ],

    'fundtaxation' => [
        'label_txt' => 'Fund Taxation',

        'all_txt' => 'All Fund Taxation',
        'add_txt' => 'Add Fund Taxation',
        'edit_txt' => 'Edit Fund Taxation',

        'flds_hide' => [
            'c_order' => true
        ],
    ],

    'fundman' => [
        'label_txt' => 'Fund Man',

        'all_txt' => 'All Fund Man',
        'add_txt' => 'Add Fund Man',
        'edit_txt' => 'Edit Fund Man',

        'synopsis_txt' => 'Synopsis',
        'disclaimer_txt' => 'Disclaimer',
        'disclaimer_note_txt' => 'Disclaimer Note',
    ],

    'newsletter' => [
        'label_txt' => 'Newsletter Data',

        'all_txt' => 'All Newsletter',
    ],

    'common_category' => [
        'all_txt' => 'All Category',
        'add_txt' => 'Add Category',
        'edit_txt' => 'Edit Category',

        'flds_hide' => [
            'f' => [
                'slug' => true,
                'descp' => true,
                'image' => true,
                'parent' => true,
                'c_order' => true,
            ],
        ],
    ],

    'team' => [
        'all_txt' => 'All Teams',
        'add_txt' => 'Add Team',
        'edit_txt' => 'Edit Team',

        'name_txt' => 'Name',
        'linkedin_link_txt' => 'LinkedIn Link',

        'prof_pic_info' => '1. Upload only JPEG and PNG image.<br>
                2. Image resolution should be in 236W * 152H (pixels).<br>
                3. To load fast, size should be under 250 KB.',
    ],

    'knowtheratio' => [
        'all_txt' => 'All Know The Ratio',
        'add_txt' => 'Add Know The Ratio',
        'edit_txt' => 'Edit Know The Ratio',
    ],

    'fundsuggestion' => [
        'all_txt' => 'All Fund Suggestion',
        'add_txt' => 'Add Fund Suggestion',
        'edit_txt' => 'Edit Fund Suggestion',

        'flds_hide' => [
            'c_order' => true
        ],
    ],

    'nfomonitor' => [
        'all_txt' => 'All NFO Monitor',
        'add_txt' => 'Add NFO Monitor',
        'edit_txt' => 'Edit NFO Monitor',

        'fund_facts_lbl' => 'Fund Facts',
        'fund_stats_lbl' => 'Fund Stats',
        'asset_allocation_lbl' => 'Asset Allocation',
        'comparable_existing_schemes_lbl' => 'Comparable Existing Schemes',
        'fund_prognonosis_lbl' => 'Fund Prognonosis',
        'scheme_dna_lbl' => 'Scheme DNA',

        'fund_name' => 'Fund Name',
        'fund_opening' => 'Fund Opening',
        'fund_closing' => 'Fund Closing',
        'ft_id' => 'Scheme Type',
        'minimum_investment' => 'Minimum Investment',
        'plan' => 'Plan',
        'options' => 'Options',
        'entry_load' => 'Entry Load',
        'exit_load' => 'Exit Load',
        'thereafter' => 'Thereafter',
        'objective' => 'Objective',
        'idc_id' => 'Benchmark',
        'fund_manager' => 'Fund Manager',
         'aa_col1_value' => '1st Column Value',
        'aa_col1_text' => '1st Column Text',
        'aa_col2_value' => '2nd Column Value',
        'aa_col2_text' => '2nd Column Text',
        'aa_col3_value' => '3rd Column Value',
        'aa_col3_text' => '3rd Column Text',
        'aa_col4_value' => '4th Column Value',
        'aa_col4_text' => '4th Column Text',
        'ces_row1_col1_text' => '1st Row 1st Column Text',
        'ces_row1_col2_text' => '1st Row 2nd Column Text',
        'ces_row1_col3_text' => '1st Row 3rd Column Text',
        'ces_row2_col1_text' => '2nd Row 1st Column Text',
        'ces_row2_col2_text' => '2nd Row 2nd Column Text',
        'ces_row2_col3_text' => '2nd Row 3rd Column Text',
        'idea_distiller' => 'Idea Distiller',
        'fund_house_aaum' => 'Fund House AAUM',
        'fund_manager_experience' => 'Fund Manager Experience',
        'uniqness' => 'Uniqness',
        'return' => 'Return',
        'risk' => 'Risk',
        'operability' => 'Operability',
        'oomph_factor' => 'OOMPH Factor',
        'media_id' => 'Fund Logo',
        'post_date' => 'Post Date',

        'media_id_info' => 'Only JPEG and PNG image allowed.<br>For best view image size should be in W=250px, H=Auto and under 250KB.',
    ],
];
