<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
            <meta name="myplexus-layout-version" content="filters-debug-2026-04-22-01">
            <title>myplexus | Ratio</title>
            <link rel="shortcut icon" href="<?php echo e(asset('themes/frontend/assets/infosolz/images/favicon.png')); ?>" type="image/x-icon">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/bootstrap.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/all.min.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/jquery-ui.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/login.css')); ?>">
            <link rel="stylesheet" href="<?php echo e(asset('themes/frontend/assets/infosolz/css/style.css')); ?>">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
            <style>
                .select2-container {
                    width: 100% !important;
                }

                .datepicker {
                    cursor: pointer;
                }

                .datepicker-wrap {
                    position: relative;
                    width: 100%;
                }

                .datepicker-wrap .datepicker {
                    padding-right: 44px;
                }

                .datepicker-trigger {
                    position: absolute;
                    top: 50%;
                    right: 10px;
                    transform: translateY(-50%);
                    border: 0;
                    background: transparent;
                    color: #3ca05e;
                    width: 28px;
                    height: 28px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    padding: 0;
                    z-index: 3;
                }

                .datepicker-trigger:focus {
                    outline: none;
                    box-shadow: none;
                }

                .datepicker-trigger i {
                    pointer-events: none;
                }

                .ui-datepicker {
                    z-index: 9999 !important;
                }

                .share_pdf .pdf,
                .new-share-pdf .pdf {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    width: 44px;
                    height: 44px;
                    flex: 0 0 44px;
                    border-radius: 12px;
                    background: linear-gradient(180deg, #56BF84 0%, #12773E 112.47%);
                    box-shadow: 0 8px 18px rgba(18, 119, 62, 0.18);
                    position: relative;
                    overflow: hidden;
                }

                .share_pdf .pdf img,
                .new-share-pdf .pdf img {
                    display: none;
                }

                .share_pdf .pdf::before,
                .new-share-pdf .pdf::before {
                    content: "\f1c1";
                    color: #ffffff;
                    font-family: "Font Awesome 6 Free";
                    font-weight: 900;
                    font-size: 20px;
                    line-height: 1;
                }

                .share_pdf .sharethis-inline-share-buttons,
                .new-share-pdf .sharethis-inline-share-buttons {
                    display: none !important;
                }

                .share-actions-inline {
                    display: inline-flex;
                    align-items: center;
                    justify-content: flex-end;
                    gap: 8px;
                    flex-wrap: wrap;
                }

                .share-actions-inline__label {
                    font-size: 13px;
                    font-weight: 600;
                    line-height: 1;
                    color: #12773E;
                }

                .share_pdf,
                .new-share-pdf {
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                    gap: 10px;
                    flex-wrap: wrap;
                }

                .share-action-pill {
                    min-height: 40px;
                    border: 1px solid #d7e7dc;
                    border-radius: 999px;
                    background: #ffffff;
                    color: #1f2937;
                    padding: 8px 12px;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    cursor: pointer;
                    font-size: 13px;
                    font-weight: 500;
                    line-height: 1;
                    text-decoration: none;
                    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
                }

                .share-action-pill:hover,
                .share-action-pill:focus {
                    background: #edf7f0;
                    color: #12773E;
                    outline: none;
                }

                .share-action-pill i {
                    width: 16px;
                    text-align: center;
                    flex: 0 0 16px;
                }

                .share-action-pill--email i {
                    color: #12773E;
                }

                .share-action-pill--whatsapp i {
                    color: #25d366;
                }

                .share-actions-inline__status {
                    font-size: 12px;
                    line-height: 1.4;
                    color: #667085;
                    flex-basis: 100%;
                    text-align: right;
                }

                .dataTables_wrapper {
                    width: 100%;
                }

                .dataTables_wrapper .dataTables_filter,
                .dataTables_wrapper .dataTables_length {
                    margin-bottom: 12px;
                }

                .mobile_header_links {
                    display: none;
                }

                .mobile_profile_link {
                    display: none;
                }

                .mobile_toggle_row {
                    display: none;
                }

                .desktop_toggle_row {
                    display: flex !important;
                }

                .menu_toggle {
                    width: 37px;
                    height: 39px;
                    cursor: pointer;
                }

                .menu_toggle div {
                    width: 18px;
                    height: 2px;
                    background: white;
                    margin: 2px 0;
                    transition: all 0.3s;
                    backface-visibility: hidden;
                }

                .menu_toggle .one {
                    transform: none;
                }

                .menu_toggle .two {
                    opacity: 1;
                }

                .menu_toggle .three {
                    transform: none;
                }

                .menu_toggle.on .two {
                    opacity: 0;
                }

                .menu_toggle.on .one {
                    transform: translateY(6px) rotate(45deg);
                }

                .menu_toggle.on .three {
                    transform: translateY(-6px) rotate(-45deg);
                }

                @media  only screen and (max-width: 991px) {
                    header.head {
                        z-index: 40;
                    }

                    .desktop_toggle_row {
                        display: none !important;
                    }

                    .mobile_toggle_row {
                        display: flex !important;
                    }

                    .top_bar {
                        height: auto;
                        min-height: 74px;
                        line-height: normal;
                        padding: 14px 20px;
                        flex-wrap: wrap;
                        gap: 12px;
                        align-items: center;
                    }

                    .tgl_menu {
                        width: auto;
                        justify-content: flex-start;
                        gap: 16px;
                    }

                    a.inner_logo {
                        display: block;
                        max-width: 140px;
                        overflow: visible;
                    }

                    a.inner_logo img {
                        width: 100%;
                        height: auto;
                        max-height: 36px;
                        object-fit: contain;
                        display: block;
                    }

                    .mobile_toggle_row {
                        width: 100%;
                        align-items: center;
                        justify-content: flex-start;
                        gap: 12px;
                    }

                    .top_bar > ul.welcome {
                        display: none;
                    }

                    .mobile_header_links {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        gap: 10px;
                        width: auto;
                        margin: 0;
                        padding: 0;
                        list-style: none;
                    }

                    .mobile_profile_link {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin: 0;
                        padding: 0;
                        list-style: none;
                    }

                    .mobile_header_links li {
                        list-style: none;
                    }

                    .mobile_header_links li a {
                        width: 44px;
                        height: 44px;
                        min-height: 44px;
                        border-radius: 12px;
                        background: transparent;
                        color: #ffffff;
                        border: 1px solid rgba(255, 255, 255, 0.45);
                        font-size: 0;
                        font-weight: 500;
                        padding: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0;
                        text-align: center;
                        box-shadow: none;
                    }

                    .mobile_header_links li a img {
                        width: 20px;
                        height: 20px;
                        margin: 0;
                        filter: brightness(0) invert(1);
                    }

                    .mobile_profile_link a {
                        width: 44px;
                        height: 44px;
                        min-height: 44px;
                        border-radius: 12px;
                        background: transparent;
                        color: #ffffff;
                        border: 1px solid rgba(255, 255, 255, 0.45);
                        padding: 0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: none;
                    }

                    .mobile_profile_link a img {
                        width: 20px;
                        height: 20px;
                        display: block;
                        filter: brightness(0) invert(1);
                    }

                    .subscription_heading {
                        margin-top: 0;
                    }

                    .head_brdcm,
                    .monthly_snapshop_sec,
                    .new_page,
                    .disclaimer {
                        max-width: 100%;
                    }

                    .disclaimer {
                        margin-top: 18px;
                        padding: 14px 16px;
                        border-radius: 14px;
                    }

                    .disclaimer p {
                        font-size: 13px;
                    }

                    .inner_main {
                        padding-top: 150px;
                    }

                    .inner_padding {
                        padding: 48px 20px 28px;
                    }

                    .all_dash {
                        padding-left: 0;
                    }

                    .all_dash h1.page_heading {
                        margin-left: 0;
                    }

                    .all_dash ul {
                        display: grid;
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                        gap: 18px;
                    }

                    .all_dash li {
                        width: 100%;
                        min-width: 0;
                        height: 104px;
                        margin-bottom: 0;
                    }

                    .all_dash li figure {
                        width: 92px;
                        height: 92px;
                        left: -16px;
                        top: 6px;
                        padding: 20px;
                    }

                    .all_dash li h4 {
                        font-size: 16px;
                        line-height: 1.2;
                        padding-left: 74px;
                        padding-right: 28px;
                        word-break: break-word;
                    }

                    .all_dash li h4 span {
                        font-size: 14px;
                    }

                    .all_dash li:before {
                        width: 36px;
                        height: 104px;
                    }
                }

                @media  only screen and (max-width: 640px) {
                    .top_bar {
                        padding: 12px 16px;
                        min-height: 64px;
                    }

                    a.inner_logo {
                        display: block;
                        max-width: 140px;
                        overflow: visible;
                    }

                    .mobile_header_links {
                        gap: 8px;
                    }

                    .mobile_header_links li a {
                        width: 40px;
                        height: 40px;
                        min-height: 40px;
                    }

                    .mobile_header_links li a img {
                        width: 18px;
                        height: 18px;
                    }

                    .menu_toggle {
                        width: 22px;
                        height: 24px;
                    }

                    .menu_toggle div {
                        margin: 5px auto;
                    }

                    .inner_main {
                        padding-top: 170px;
                    }

                    h1.page_heading {
                        font-size: 26px;
                        margin-bottom: 18px;
                    }

                    .all_dash ul {
                        grid-template-columns: 1fr;
                    }

                    .all_dash li {
                        height: 96px;
                    }

                    .all_dash li figure {
                        width: 86px;
                        height: 86px;
                        left: -12px;
                        top: 5px;
                        padding: 18px;
                    }

                    .all_dash li h4 {
                        padding-left: 82px;
                        padding-right: 24px;
                    }

                    .all_dash li:before {
                        width: 32px;
                        height: 96px;
                    }
                }

                html,
                body {
                    overflow-x: hidden;
                }

                *,
                *::before,
                *::after {
                    box-sizing: border-box;
                }

                .top_bar {
                    display: flex;
                    align-items: center;
                    background: linear-gradient(180deg, #56BF84 0%, #12773E 112.47%);
                }

                .top_bar .welcome li a {
                    color: #ffffff;
                }

                .top_bar .welcome li a img {
                    filter: brightness(0) invert(1);
                }

                .top_bar .welcome li a i span {
                    background: #ffffff;
                    color: #12773E;
                }

                .mobile_toggle_row {
                    min-width: 0;
                }

                .tgl_menu,
                .mobile_header_links,
                .mobile_profile_link {
                    min-width: 0;
                }

                .mobile_header_links li a,
                .mobile_profile_link a,
                .mobile_header_links li .menu_toggle {
                    min-width: 44px;
                    min-height: 44px;
                }

                .subscription_heading {
                    padding-right: 16px;
                    display: block;
                    width: 100%;
                    clear: both;
                    position: relative;
                }

                .subscription_heading.is-hidden {
                    display: none;
                }

                nav.left_menu > ul {
                    display: flex;
                    flex-direction: column;
                    min-height: 100%;
                }

                .left_menu__utility {
                    order: 20;
                }

                .left_menu__utility a img {
                    filter: brightness(0) invert(1);
                }

                .left_menu__utility--start {
                    margin-top: auto;
                }

                .head_brdcm {
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    gap: 12px;
                    flex-wrap: nowrap;
                    width: 100%;
                    max-width: 1320px;
                    margin-left: auto;
                    margin-right: auto;
                    margin-bottom: 12px;
                }

                .head_brdcm > a.back_btn {
                    flex: 0 0 auto;
                    margin: 0;
                }

                .head_brdcm > ul.brdcmb {
                    display: flex;
                    align-items: center;
                    flex-wrap: wrap;
                    margin: 0;
                    padding: 0;
                    min-width: 0;
                }

                .new_page > a.back_btn {
                    margin-bottom: 0;
                }

                .monthly_snapshop_sec,
                .new_page,
                .disclaimer {
                    max-width: 1320px;
                    margin-left: auto;
                    margin-right: auto;
                }

                .monthly_snapshop_sec > .container,
                .new_page > .container {
                    max-width: none;
                    padding-left: 0;
                    padding-right: 0;
                }

                .disclaimer {
                    margin-top: 24px;
                    padding: 18px 22px;
                    border-radius: 16px;
                    background: #f6fbf8;
                    border: 1px solid #dcece1;
                    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
                }

                .disclaimer p {
                    margin: 0;
                    font-size: 14px;
                    line-height: 1.6;
                    color: #344054;
                }

                .disclaimer strong {
                    color: #12773E;
                }

                .subs_in {
                    width: min(100%, 720px);
                    min-height: 44px;
                    margin: 0 auto;
                    padding: 8px 10px 8px 12px;
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 10px;
                    background: #f3f8f5;
                    border: 1px solid #dcece1;
                    box-shadow: 0 6px 18px rgba(16, 24, 40, 0.05);
                }

                .subs_in__body {
                    min-width: 0;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    flex: 1;
                }

                .subs_in__body > i {
                    width: 20px;
                    flex: 0 0 20px;
                    text-align: center;
                    font-size: 14px;
                }

                .subs_in__body p {
                    margin: 0;
                    min-width: 0;
                    font-size: 13px;
                    line-height: 1.4;
                    color: #344054;
                }

                .subs_in__body a {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 28px;
                    margin-left: 6px;
                    padding: 4px 10px;
                    border-radius: 999px;
                    font-size: 12px;
                    font-weight: 500;
                    white-space: nowrap;
                }

                .subs_close {
                    width: 44px;
                    height: 44px;
                    flex: 0 0 44px;
                    border: 0;
                    border-radius: 12px;
                    background: transparent;
                    color: #667085;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0;
                    cursor: pointer;
                }

                .subs_close:hover,
                .subs_close:focus {
                    background: rgba(16, 24, 40, 0.06);
                    outline: none;
                }

                .all_dash {
                    padding-left: 0 !important;
                }

                .all_dash h1.page_heading {
                    margin-left: 0 !important;
                }

                a.inner_logo {
                    display: flex !important;
                    align-items: center;
                    overflow: visible !important;
                    max-width: 180px;
                }

                a.inner_logo img.logo1 {
                    max-width: 150px;
                    max-height: 50px;
                    width: auto;
                    height: auto;
                    margin-top: 0 !important;
                    object-fit: contain;
                    display: block;
                }

                .all_dash ul {
                    display: grid;
                    grid-template-columns: minmax(0, 1fr);
                    gap: 12px;
                    margin: 0;
                    padding: 0;
                }

                .all_dash li {
                    width: 100%;
                    height: auto;
                    margin: 0;
                    background: transparent;
                    list-style: none;
                }

                .all_dash li::before {
                    display: none;
                }

                .all_dash li a.dashboard_card {
                    width: 100%;
                    min-height: 76px;
                    padding: 14px 16px;
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    border-radius: 16px;
                    background: #ffffff;
                    border: 1px solid #e3ece6;
                    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
                    text-decoration: none;
                }

                .all_dash li a.dashboard_card:focus,
                .all_dash li a.dashboard_card:hover {
                    border-color: #cfe1d5;
                    box-shadow: 0 10px 24px rgba(18, 119, 62, 0.08);
                }

                .all_dash li a.dashboard_card figure {
                    position: static;
                    margin: 0;
                    width: 44px;
                    height: 44px;
                    flex: 0 0 44px;
                    padding: 9px;
                    border-radius: 14px;
                    background: linear-gradient(180deg, #56BF84 0%, #12773E 112.47%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .all_dash li a.dashboard_card figure img {
                    width: 100%;
                    height: auto;
                    display: block;
                    object-fit: contain;
                }

                .dashboard_card_text {
                    min-width: 0;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 2px;
                }

                .dashboard_card_title {
                    font-size: 15px;
                    font-weight: 500;
                    line-height: 1.3;
                    color: #1f2937;
                }

                .dashboard_card_subtitle {
                    font-size: 12px;
                    font-weight: 400;
                    line-height: 1.35;
                    color: #667085;
                }

                .dashboard_card_arrow {
                    width: 32px;
                    height: 32px;
                    flex: 0 0 32px;
                    border-radius: 999px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    background: #f5f7f6;
                    color: #379962;
                    font-size: 14px;
                    align-self: center;
                }

                .all_dash li h4 {
                    padding: 0;
                    margin: 0;
                }

                @media  only screen and (max-width: 991px) {
                    .desktop_toggle_row {
                        display: none !important;
                    }

                    .mobile_toggle_row {
                        display: flex !important;
                    }

                    .top_bar {
                        padding: 10px 14px;
                        min-height: 60px;
                        gap: 10px;
                        position: relative;
                        z-index: 41;
                    }

                    .mobile_toggle_row {
                        display: grid !important;
                        grid-template-columns: 44px minmax(0, 1fr) 44px;
                        align-items: center;
                        gap: 8px;
                        position: relative;
                        z-index: 42;
                        width: 100%;
                        padding: 0;
                    }

                    .tgl_menu {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0;
                        width: 100%;
                        min-width: 0;
                        grid-column: 2;
                        justify-self: center;
                    }

                    a.inner_logo {
                        display: block;
                        max-width: 120px;
                        overflow: visible;
                        margin: 0 auto;
                        justify-self: center;
                    }

                    .mobile_header_links {
                        display: flex;
                        align-items: center;
                        justify-content: flex-start;
                        margin: 0;
                        padding: 0;
                        position: static;
                        z-index: 43;
                        grid-column: 1;
                        justify-self: start;
                    }

                    .mobile_profile_link {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        margin: 0;
                        padding: 0;
                        list-style: none;
                        position: static;
                        z-index: 43;
                        grid-column: 3;
                        justify-self: end;
                    }

                    .mobile_header_links li a {
                        width: 44px;
                        height: 44px;
                        border-radius: 12px;
                        box-shadow: none;
                        border: 1px solid rgba(255, 255, 255, 0.45);
                        background: transparent;
                        color: #ffffff;
                    }

                    .mobile_header_links li a img {
                        width: 18px;
                        height: 18px;
                        filter: brightness(0) invert(1);
                    }

                    .mobile_profile_link a {
                        width: 44px;
                        height: 44px;
                        border-radius: 12px;
                        box-shadow: none;
                        border: 1px solid rgba(255, 255, 255, 0.45);
                        background: transparent;
                        color: #ffffff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .mobile_profile_link a img {
                        width: 18px;
                        height: 18px;
                        filter: brightness(0) invert(1);
                    }

                    .menu_toggle {
                        width: 44px;
                        height: 44px;
                        display: inline-flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        border-radius: 12px;
                        background: #379962;
                        padding: 0;
                        flex: 0 0 44px;
                        position: relative;
                        z-index: 44;
                    }

                    .menu_toggle div {
                        width: 18px;
                        height: 2px;
                        margin: 2px 0;
                    }

                    .inner_main {
                        padding-top: 128px;
                    }

                    .inner_padding {
                        padding: 18px 14px 24px;
                    }

                    h1.page_heading {
                        font-size: 24px;
                        line-height: 1.2;
                        margin-bottom: 14px;
                    }

                    .subscription_heading {
                        margin-top: 0;
                        padding: 0 14px;
                        display: block;
                        width: 100%;
                        flex-basis: 100%;
                        order: 2;
                    }
                }

                @media  only screen and (max-width: 640px) {
                    a.inner_logo {
                        display: block;
                        max-width: 140px;
                        overflow: visible;
                    }

                    .top_bar {
                        padding: 10px 12px;
                    }

                    .mobile_profile_link a {
                        width: 40px;
                        height: 40px;
                        min-width: 40px;
                        min-height: 40px;
                    }

                    .mobile_profile_link a img {
                        width: 17px;
                        height: 17px;
                    }

                    .mobile_toggle_row {
                        grid-template-columns: 40px minmax(0, 1fr) 40px;
                    }

                    .mobile_header_links li a {
                        width: 40px;
                        height: 40px;
                        min-width: 40px;
                        min-height: 40px;
                    }

                    .mobile_header_links li a img {
                        width: 17px;
                        height: 17px;
                    }

                    .mobile_header_links li a {
                        width: 40px;
                        height: 40px;
                        min-width: 40px;
                        min-height: 40px;
                    }

                    .mobile_header_links li a img {
                        width: 17px;
                        height: 17px;
                    }

                    .menu_toggle {
                        width: 20px;
                        height: 20px;
                    }

                    .inner_main {
                        padding-top: 120px;
                    }

                    .inner_padding {
                        padding: 16px 12px 22px;
                    }

                    .subscription_heading {
                        padding: 0 12px;
                    }

                    .subs_in {
                        padding: 8px 8px 8px 10px;
                        border-radius: 12px;
                        gap: 8px;
                    }

                    .subs_in__body {
                        gap: 8px;
                    }

                    .subs_in__body p {
                        font-size: 12px;
                    }

                    .subs_in__body a {
                        margin-left: 4px;
                        padding: 4px 8px;
                    }

                    .subs_close {
                        width: 40px;
                        height: 40px;
                        flex-basis: 40px;
                    }

                    .all_dash li a.dashboard_card {
                        min-height: 72px;
                        padding: 12px 14px;
                        gap: 10px;
                        border-radius: 14px;
                    }

                    .all_dash li a.dashboard_card figure {
                        width: 40px;
                        height: 40px;
                        flex-basis: 40px;
                        border-radius: 12px;
                        padding: 8px;
                    }

                    .dashboard_card_title {
                        font-size: 14px;
                    }

                    .dashboard_card_subtitle {
                        font-size: 11px;
                    }
                }

                @media  only screen and (min-width: 768px) {
                    .all_dash ul {
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                    }
                }

                @media  only screen and (min-width: 992px) {
                    .mobile_toggle_row {
                        display: none !important;
                    }

                    .desktop_toggle_row {
                        display: flex !important;
                    }
                }

                @media  only screen and (min-width: 1200px) {
                    .all_dash ul {
                        grid-template-columns: repeat(3, minmax(0, 1fr));
                        gap: 16px;
                    }

                    .all_dash li a.dashboard_card {
                        min-height: 84px;
                    }
                }
            </style>
        </head>
        <body>
        <header class="head">
                <div class="top_bar">
                    <div class="mobile_toggle_row">
                        <div class="tgl_menu">
                            <a href="<?php echo e(route('user.index_dashboard')); ?>" class="inner_logo">
                                <img class="logo1" src="<?php echo e(asset('themes/frontend/assets/v1/img/logo_dash.png')); ?>" alt="">
                            </a>
                        </div>
                        <ul class="mobile_header_links">
                            <li>
                                <div class="menu_toggle" data-menu-toggle aria-label="Open menu" role="button" tabindex="0">
                                    <div class="one"></div>
                                    <div class="two"></div>
                                    <div class="three"></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="mobile_profile_link">
                            <li>
                                <a href="<?php echo e(route('user.profile')); ?>" aria-label="Profile">
                                    <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tgl_menu desktop_toggle_row">
                        <a href="<?php echo e(route('user.index_dashboard')); ?>" class="inner_logo">
                            <img class="logo1" src="<?php echo e(asset('themes/frontend/assets/v1/img/logo_dash.png')); ?>" alt="">
                        </a>
                        <div class="menu_toggle" data-menu-toggle>
                            <div class="one"></div>
                            <div class="two"></div>
                            <div class="three"></div>
                        </div>
                    </div>
                    <ul class="welcome">
                        <li><a href="<?php echo e(route('user.index_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">Welcome to Dashboard</a></li>
                        <li><a href="<?php echo e(route('user.profile')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">Profile</a></li>
                        <li><a href="<?php echo e(route('user.notifications')); ?>">
                            <i>
                                <img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/noti.png')); ?>" alt="">
                                <span>0</span>
                            </i>
                            Notification</a></li>
                        <li><a href="<?php echo e(route('user.logout')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/log.png')); ?>" alt="">Logout</a></li>
                    </ul>
                </div>
                <div class="subscription_heading">
                    <div class="subs_in" data-subscription-banner>
                        <div class="subs_in__body">
                            <?php if(!empty($show_expired_warning)): ?>
                                <i class="fa-solid fa-triangle-exclamation red"></i>
                                <p>
                                    <?php echo e(!empty($expiry_date_display) ? 'Subscription will expire on ' . $expiry_date_display . '.' : 'Subscription has expired.'); ?>

                                    <a href="<?php echo e($subscription_cta_url ?? '#'); ?>">Renew now</a>
                                </p>
                            <?php elseif(!empty($show_renew_warning)): ?>
                                <i class="fa-solid fa-triangle-exclamation yellow"></i>
                                <p>
                                    Subscription will expire on <?php echo e($expiry_date_display ?? date('d/m/Y', strtotime($expiry_date))); ?>.
                                    <a href="<?php echo e($subscription_cta_url ?? '#'); ?>">Renew now</a>
                                </p>
                            <?php elseif(!empty($expiry_date)): ?>
                                <i class="fa-solid fa-bell green"></i>
                                <p>Subscription active until <?php echo e(date('d/m/Y', strtotime($expiry_date))); ?>.</p>
                            <?php else: ?>
                                <i class="fa-solid fa-bell green"></i>
                                <p>Subscription is active.</p>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="subs_close" data-dismiss-subscription aria-label="Dismiss notification">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <nav class="left_menu same_height">
                    <ul>
                        <li class="<?php echo e(request()->routeIs('user.ratio_dashboard') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.ratio_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratop_report.png')); ?>" alt="">Ratio Reports</a></li>
                        <li class="<?php echo e(request()->routeIs('user.ratio_analysis') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.ratio_analysis')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/ratio_ana.png')); ?>" alt=""> Ratio Analysis</a></li>
                        <li class="<?php echo e(request()->routeIs('user.composition_report') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.composition_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/compos.png')); ?>" alt="">Composition Report</a></li>
                        <li class="<?php echo e(request()->routeIs('user.indies_report') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.indies_report')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/indies.png')); ?>" alt="">Indies Report</a></li>
                        <li class="<?php echo e(request()->routeIs('user.model_portfolio') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.model_portfolio')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/model.png')); ?>" alt="">Model Portfolio</a></li>
                        <li class="<?php echo e(request()->routeIs('user.filters') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.filters')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/filter.png')); ?>" alt="">Filters</a></li>
                        <li class="<?php echo e(request()->routeIs('user.predictive') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.predictive')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/predic.png')); ?>" alt="">Predictive</a></li>
                        <!-- <li class="left_menu__utility left_menu__utility--start <?php echo e(request()->routeIs('user.index_dashboard') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.index_dashboard')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">Dashboard</a></li>
                        <li class="left_menu__utility <?php echo e(request()->routeIs('user.profile') ? 'active' : ''); ?>"><a href="<?php echo e(route('user.profile')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/wel.png')); ?>" alt="">Profile</a></li>
                        <li class="left_menu__utility"><a href="<?php echo e(route('user.logout')); ?>"><img src="<?php echo e(asset('themes/frontend/assets/infosolz/images/log.png')); ?>" alt="">Logout</a></li> -->
                    </ul>
                </nav>
        </header>

            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/bootstrap.min.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/jquery-ui.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/icon.js')); ?>"></script>
            <script src="<?php echo e(asset('themes/frontend/assets/infosolz/js/main.js')); ?>"></script>
            <script src="<?php echo e(mix('js/vue-app.js')); ?>"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ratioDashboardUrl = <?php echo json_encode(route('user.ratio_dashboard'), 15, 512) ?>;
                    var menuStorageKey = 'myplexusAuthMenuOpen';

                    function setMenuOpenState(isOpen) {
                        var toggles = document.querySelectorAll('[data-menu-toggle]');
                        var targets = document.querySelectorAll('.head, .main_foot, .page_detail, .subscription_heading');

                        toggles.forEach(function (toggle) {
                            toggle.classList.toggle('on', isOpen);
                        });

                        targets.forEach(function (target) {
                            target.classList.toggle('menu_close', !isOpen);
                        });

                        try {
                            sessionStorage.setItem(menuStorageKey, isOpen ? '1' : '0');
                        } catch (error) {
                            console.warn('Menu state could not be persisted:', error);
                        }
                    }

                    function initializeMenuState() {
                        var isMobileViewport = window.matchMedia('(max-width: 991px)').matches;
                        var savedState = null;

                        try {
                            savedState = sessionStorage.getItem(menuStorageKey);
                        } catch (error) {
                            savedState = null;
                        }

                        // No saved state: open on desktop, closed on mobile
                        if (savedState === null) {
                            setMenuOpenState(!isMobileViewport);
                            return;
                        }

                        // On desktop, ignore any saved closed state from mobile — always open
                        if (!isMobileViewport && savedState === '0') {
                            setMenuOpenState(true);
                            return;
                        }

                        setMenuOpenState(savedState === '1');
                    }

                    function bindMenuToggle() {
                        if (!(window.jQuery && $('[data-menu-toggle]').length)) {
                            return;
                        }

                        $('[data-menu-toggle]').off('click keydown').on('click keydown', function (event) {
                            if (event.type === 'keydown' && event.key !== 'Enter' && event.key !== ' ') {
                                return;
                            }

                            event.preventDefault();
                            var willOpen = !this.classList.contains('on');
                            setMenuOpenState(willOpen);

                            setTimeout(function () {
                                $('.head').toggleClass('logo_change', willOpen);
                            }, 20);
                        });

                        $('nav.left_menu a, .mobile_header_links a').off('click.myplexusMenu').on('click.myplexusMenu', function () {
                            if (window.matchMedia('(max-width: 991px)').matches) {
                                setMenuOpenState(false);
                            }
                        });
                    }

                    function initializeBackButtons() {
                        document.querySelectorAll('.head_brdcm').forEach(function (breadcrumb) {
                            var newPage = breadcrumb.nextElementSibling;
                            var siblingBackButton = null;

                            if (newPage) {
                                if (newPage.classList.contains('new_page')) {
                                    var directChildren = Array.prototype.slice.call(newPage.children || []);
                                    siblingBackButton = directChildren.find(function (child) {
                                        return child.matches && child.matches('a.back_btn');
                                    }) || null;
                                } else {
                                    siblingBackButton = newPage.querySelector(':scope > a.back_btn');
                                }
                            }

                            if (!siblingBackButton || breadcrumb.querySelector('a.back_btn')) {
                                return;
                            }

                            breadcrumb.prepend(siblingBackButton);
                        });

                        document.querySelectorAll('.new_page').forEach(function (container) {
                            var breadcrumb = container.querySelector('.head_brdcm');
                            var backButton = container.querySelector(':scope > a.back_btn');

                            if (!breadcrumb || !backButton || breadcrumb.querySelector('a.back_btn')) {
                                return;
                            }

                            breadcrumb.prepend(backButton);
                        });

                        document.querySelectorAll('a.back_btn').forEach(function (backButton) {
                            backButton.setAttribute('aria-label', 'Go back');

                            backButton.addEventListener('click', function (event) {
                                var hasUsableHistory = window.history.length > 1 && document.referrer;
                                var sameOriginReferrer = hasUsableHistory && document.referrer.indexOf(window.location.origin) === 0;

                                if (sameOriginReferrer) {
                                    event.preventDefault();
                                    window.history.back();
                                    return;
                                }

                                if (backButton.getAttribute('href') === '#' || !backButton.getAttribute('href')) {
                                    event.preventDefault();
                                    window.location.href = ratioDashboardUrl;
                                }
                            });
                        });
                    }

                    function initializeDatepickers() {
                        if (!(window.jQuery && $.fn.datepicker)) {
                            return;
                        }

                        $('.datepicker').each(function () {
                            var $input = $(this);

                            if ($input.parent().hasClass('datepicker-wrap')) {
                                return;
                            }

                            $input.wrap('<div class="datepicker-wrap"></div>');
                            $('<button type="button" class="datepicker-trigger" aria-label="Open calendar"><i class="fa-regular fa-calendar"></i></button>')
                                .insertAfter($input);
                        });

                        $('.datepicker').attr('readonly', true);

                        $('.datepicker').datepicker('destroy').datepicker({
                            dateFormat: 'dd-mm-yy',
                            changeMonth: true,
                            changeYear: true,
                            numberOfMonths: 1,
                            showButtonPanel: true,
                            yearRange: '-100:+20',
                            constrainInput: false
                        });

                        $('.datepicker').off('focus click').on('focus click', function () {
                            $(this).datepicker('show');
                        });

                        $(document).off('click.datepickerTrigger').on('click.datepickerTrigger', '.datepicker-trigger', function (event) {
                            event.preventDefault();

                            var $input = $(this).siblings('.datepicker');

                            if ($input.length) {
                                $input.datepicker('show');
                                $input.trigger('focus');
                            }
                        });

                        $(document).off('click.datepickerWrap').on('click.datepickerWrap', '.datepicker-wrap', function (event) {
                            if ($(event.target).hasClass('datepicker-trigger')) {
                                return;
                            }

                            var $input = $(this).find('.datepicker');

                            if ($input.length) {
                                $input.datepicker('show');
                            }
                        });
                    }

                    function initializeShareActions() {
                        var shareContainers = document.querySelectorAll('.share_pdf, .new-share-pdf');

                        shareContainers.forEach(function (container) {
                            if (container.querySelector('.share-actions-inline')) {
                                return;
                            }

                            var actions = document.createElement('div');
                            actions.className = 'share-actions-inline';

                            var pageTitle = document.title || 'myplexus report';
                            var pageUrl = window.location.href;
                            var shareText = 'Check this report on myplexus';

                            actions.innerHTML = [
                                '<span class="share-actions-inline__label">Share PDF</span>',
                                '<button type="button" class="share-action-pill share-action-pill--email" data-share-channel="email"><i class="fa-solid fa-envelope"></i><span>Email PDF</span></button>',
                                '<button type="button" class="share-action-pill share-action-pill--whatsapp" data-share-channel="whatsapp"><i class="fa-brands fa-whatsapp"></i><span>WhatsApp PDF</span></button>',
                                '<span class="share-actions-inline__status" data-share-status></span>'
                            ].join('');

                            async function sharePdf(channel) {
                                var exportButton = container.querySelector('.pdf');
                                var status = actions.querySelector('[data-share-status]');

                                if (!exportButton || !window.__myplexPdfShareBridgeReady) {
                                    if (status) {
                                        status.textContent = 'PDF sharing is not available here.';
                                    }

                                    return;
                                }

                                window.__myplexPendingPdfShare = {
                                    channel: channel,
                                    title: pageTitle,
                                    url: pageUrl,
                                    text: shareText,
                                    statusEl: status
                                };

                                exportButton.click();

                                window.setTimeout(function () {
                                    if (window.__myplexPendingPdfShare && window.__myplexPendingPdfShare.statusEl === status) {
                                        window.__myplexPendingPdfShare = null;
                                        exportButton.click();

                                        if (status) {
                                            status.textContent = 'This browser cannot share the PDF directly, so it was downloaded instead.';
                                        }
                                    }
                                }, 1200);
                            }

                            actions.addEventListener('click', function (event) {
                                var button = event.target.closest('[data-share-channel]');

                                if (!button) {
                                    return;
                                }

                                event.preventDefault();
                                sharePdf(button.getAttribute('data-share-channel'));
                            });

                            container.insertBefore(actions, container.firstChild);
                        });
                    }

                    function initializePdfShareBridge() {
                        if (!window.jspdf || !window.jspdf.jsPDF || window.__myplexPdfShareBridgeReady) {
                            return;
                        }

                        var JsPdfConstructor = window.jspdf.jsPDF;
                        var originalSave = JsPdfConstructor.prototype.save;

                        JsPdfConstructor.prototype.save = function (filename, options) {
                            var pendingShare = window.__myplexPendingPdfShare;

                            if (!pendingShare) {
                                return originalSave.call(this, filename, options);
                            }

                            window.__myplexPendingPdfShare = null;

                            var pdfBlob = this.output('blob');
                            var pdfFile = new File([pdfBlob], filename || 'report.pdf', { type: 'application/pdf' });

                            (async function () {
                                var status = pendingShare.statusEl;
                                var shared = false;

                                if (navigator.share && navigator.canShare && navigator.canShare({ files: [pdfFile] })) {
                                    try {
                                        await navigator.share({
                                            title: pendingShare.title,
                                            text: pendingShare.text,
                                            files: [pdfFile]
                                        });
                                        shared = true;
                                        if (status) {
                                            status.textContent = 'Opened device share sheet for the PDF.';
                                        }
                                    } catch (error) {
                                        shared = false;
                                    }
                                }

                                if (shared) {
                                    return;
                                }

                                if (status) {
                                    status.textContent = 'Direct PDF sharing is not supported here, so the PDF was downloaded instead.';
                                }

                                originalSave.call(this, filename, options);
                            }).call(this);

                            return this;
                        };

                        window.__myplexPdfShareBridgeReady = true;
                    }

                    function initializeSubscriptionBanner() {
                        var banner = document.querySelector('[data-subscription-banner]');
                        var container = document.querySelector('.subscription_heading');

                        if (!banner || !container) {
                            return;
                        }

                        var dismissButton = banner.querySelector('[data-dismiss-subscription]');
                        var bannerKey = 'myplexusSubscriptionBannerDismissed:' + (banner.textContent || '').trim().replace(/\s+/g, ' ').slice(0, 120);

                        try {
                            if (sessionStorage.getItem(bannerKey) === '1') {
                                container.classList.add('is-hidden');
                            }
                        } catch (error) {
                            console.warn('Subscription banner state could not be restored:', error);
                        }

                        if (!dismissButton) {
                            return;
                        }

                        dismissButton.addEventListener('click', function () {
                            container.classList.add('is-hidden');

                            try {
                                sessionStorage.setItem(bannerKey, '1');
                            } catch (error) {
                                console.warn('Subscription banner state could not be persisted:', error);
                            }
                        });
                    }

                    try {
                        initializeMenuState();
                        bindMenuToggle();
                    } catch (error) {
                        console.error('Menu initialization failed:', error);
                    }

                    try {
                        initializeBackButtons();
                    } catch (error) {
                        console.error('Back button initialization failed:', error);
                    }

                    try {
                        initializeDatepickers();
                    } catch (error) {
                        console.error('Datepicker initialization failed:', error);
                    }

                    try {
                        initializeSubscriptionBanner();
                    } catch (error) {
                        console.error('Subscription banner initialization failed:', error);
                    }

                    try {
                        initializeShareActions();
                    } catch (error) {
                        console.error('Share actions initialization failed:', error);
                    }

                    try {
                        initializePdfShareBridge();
                    } catch (error) {
                        console.error('PDF share bridge initialization failed:', error);
                    }

                    console.log('Myplexus layout version:', 'filters-debug-2026-04-22-01');

                    if (window.jQuery && $.fn.select2) {
                        $('.select2').select2();
                    }
                });
            </script>

          <?php echo $__env->yieldContent('content'); ?>
          <footer class="main_foot">
            <p>Copyright © <?php echo e(date('Y')); ?> <span>myplexus.com</span>. All Rights Reserved.</p>
          </footer>

            <div id="ui-datepicker-div" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>
            <?php echo $__env->yieldPushContent('scripts'); ?>
        </body>
    </html>
<?php /**PATH /Users/ishant/Documents/GitHub/myplex/resources/views/web/layout/infosolz_user_app.blade.php ENDPATH**/ ?>