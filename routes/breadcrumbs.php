<?php
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(__('admin.dashboard_txt'), route('admin.dashboard'));
});

Breadcrumbs::for('admin.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.all_admn_user_txt'), route('admin.admin.index'));
});

Breadcrumbs::for('admin.create', function ($trail) {
    $trail->parent('admin.index');
    $trail->push(__('admin.add_admn_user_txt'), route('admin.admin.create'));
});

Breadcrumbs::for('admin.edit', function ($trail, $dataArr) {
    $trail->parent('admin.index');
    $trail->push(__('admin.edit_admn_user_txt'), route('admin.admin.edit', $dataArr->admin_id));
});

Breadcrumbs::register('admin.profile', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.edit_profile_txt'), route('admin.profile'));
});


Breadcrumbs::for('adminrole.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.all_admnrole_user_txt'), route('admin.adminrole.index'));
});

Breadcrumbs::for('adminrole.create', function ($trail) {
    $trail->parent('adminrole.index');
    $trail->push(__('admin.add_admnrole_user_txt'), route('admin.adminrole.create'));
});

Breadcrumbs::for('adminrole.edit', function ($trail, $userrole) {
    $trail->parent('adminrole.index');
    $trail->push(__('admin.edit_admnrole_user_txt'), route('admin.adminrole.edit', $userrole->role_id));
});


Breadcrumbs::for('subscribeduser.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('subscribeduser.all_txt'), route('admin.subscribeduser.index'));
});

Breadcrumbs::for('subscribeduser.create', function ($trail) {
    $trail->parent('subscribeduser.index');
    $trail->push(__('subscribeduser.add_txt'), route('admin.subscribeduser.create'));
});

Breadcrumbs::for('subscribeduser.createmanual', function ($trail) {
    $trail->parent('subscribeduser.create');
    $trail->push(__('subscribeduser.add_manual_txt'), route('admin.subscribeduser.createmanual'));
});

Breadcrumbs::for('subscribeduser.edit', function ($trail, $dataArr) {
    $trail->parent('subscribeduser.create');
    $trail->push(__('subscribeduser.edit_txt'), route('admin.subscribeduser.edit', $dataArr->u_id));
});

Breadcrumbs::for('usergroup.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('subscribeduser.user_group.all_txt'), route('admin.usergroup.index'));
});

Breadcrumbs::for('usergroup.create', function ($trail) {
    $trail->parent('usergroup.index');
    $trail->push(__('subscribeduser.user_group.add_txt'), route('admin.usergroup.create'));
});

Breadcrumbs::for('usergroup.edit', function ($trail, $dataArr) {
    $trail->parent('usergroup.index');
    $trail->push(__('subscribeduser.user_group.edit_txt'), route('admin.usergroup.edit', $dataArr->u_g_id));
});


Breadcrumbs::for('media.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('media.all_txt'), route('admin.media.index'));
});

Breadcrumbs::for('media.create', function ($trail) {
    $trail->parent('media.index');
    $trail->push(__('media.add_txt'), route('admin.media.create'));
});

Breadcrumbs::for('media.edit', function ($trail, $dataArr) {
    $trail->parent('media.index');
    $trail->push(__('media.edit_txt'), route('admin.media.edit', $dataArr->media_id));
});


Breadcrumbs::for('contact.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('contact.all_txt'), route('admin.contact.index'));
});

Breadcrumbs::for('contact.show', function ($trail, $id) {
    $trail->parent('contact.index');
    $trail->push(__('contact.show_txt'), route('admin.contact.show', $id));
});


Breadcrumbs::for('settings.general', function ($trail, $title) {
    $trail->parent('dashboard');
    $trail->push($title, route('admin.settings.general'));
});

Breadcrumbs::for('settings.options', function ($trail, $title) {
    $trail->parent('dashboard');
    $trail->push($title, route('admin.settings.options'));
});

Breadcrumbs::for('settings.mail', function ($trail, $title) {
    $trail->parent('dashboard');
    $trail->push($title, route('admin.settings.mail'));
});

Breadcrumbs::for('settings.social', function ($trail, $title) {
    $trail->parent('dashboard');
    $trail->push($title, route('admin.settings.social'));
});

Breadcrumbs::for('settings.custom', function ($trail, $title) {
    $trail->parent('dashboard');
    $trail->push($title, route('admin.settings.custom'));
});


Breadcrumbs::for('template.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.template.all_txt'), route('admin.template.index'));
});

Breadcrumbs::for('template.create', function ($trail) {
    $trail->parent('template.index');
    $trail->push(__('admin.template.add_txt'), route('admin.template.create'));
});

Breadcrumbs::for('template.edit', function ($trail, $dataArr) {
    $trail->parent('template.index');
    $trail->push(__('admin.template.edit_txt'), route('admin.template.edit', $dataArr->template_id));
});


Breadcrumbs::for('customfield.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.customfield.all_txt'), route('admin.customfield.index'));
});

Breadcrumbs::for('customfield.show', function ($trail, $dataArr) {
    $trail->parent('customfield.index');
    $trail->push(__('admin.customfield.show_txt'), route('admin.customfield.show', $dataArr->cf_group_id));
});

Breadcrumbs::for('customfield.create', function ($trail) {
    $trail->parent('customfield.index');
    $trail->push(__('admin.customfield.add_txt'), route('admin.customfield.create'));
});

Breadcrumbs::for('customfield.edit', function ($trail, $dataArr) {
    $trail->parent('customfield.show', $dataArr);
    $trail->push(__('admin.customfield.edit_txt'), route('admin.customfield.edit', $dataArr->cf_group_id));
});

Breadcrumbs::for('customfield.grouptype.create', function ($trail, $dataArr) {
    $trail->parent('customfield.show', $dataArr);
    $trail->push(__('admin.customfield.grouptype.add_txt'), route('admin.customfield.grouptype.create', $dataArr->cf_group_id));
});

Breadcrumbs::for('customfield.grouptype.edit', function ($trail, $dataArr) {
    $trail->parent('customfield.grouptype.show', $dataArr);
    $trail->push(__('admin.customfield.grouptype.edit_txt') . " ( $dataArr->field_name )", route('admin.customfield.grouptype.edit', [$dataArr->cf_group_id, $dataArr->cf_group_type_id]));
});

Breadcrumbs::for('customfield.grouptype.show', function ($trail, $dataArr) {
    $trail->parent('customfield.show', $dataArr);
    $trail->push(__('admin.customfield.grouptype.show_txt') . " ( $dataArr->field_name )", route('admin.customfield.grouptype.show', [$dataArr->cf_group_id, $dataArr->cf_group_type_id]));
});

Breadcrumbs::for('customfield.grouptype.classtemplate.show', function ($trail, $dataArr) {
    $trail->parent('customfield.grouptype.show', $dataArr);
    $trail->push(__('admin.customfield.grouptype.show_txt'), route('admin.customfield.grouptype.classtemplate.show', [$dataArr->cfgt->cf_group_id, $dataArr->cf_group_type_id, $dataArr->cf_gt_class_template_id]));
});

Breadcrumbs::for('customfield.grouptype.classtemplate.create', function ($trail, $dataArr) {
    $trail->parent('customfield.grouptype.show', $dataArr);
    $trail->push(__('admin.customfield.grouptype.classtemplate.add_txt'), route('admin.customfield.grouptype.classtemplate.create', [$dataArr->cf_group_id, $dataArr->cf_group_type_id]));
});

Breadcrumbs::for('customfield.grouptype.classtemplate.edit', function ($trail, $dataArr) {
    $trail->parent('customfield.grouptype.show', $dataArr->cfgt);
    $trail->push(__('admin.customfield.grouptype.classtemplate.edit_txt'), route('admin.customfield.grouptype.classtemplate.edit', [$dataArr->cfgt->cf_group_id, $dataArr->cf_group_type_id, $dataArr->cf_gt_class_template_id]));
});


Breadcrumbs::for('page.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.page.all_txt'), route('admin.page.index'));
});

Breadcrumbs::for('page.create', function ($trail) {
    $trail->parent('page.index');
    $trail->push(__('admin.page.add_txt'), route('admin.page.create.custom'));
});

Breadcrumbs::for('page.edit', function ($trail, $dataArr) {
    $trail->parent('page.index');
    $trail->push(__('admin.page.edit_txt'), route('admin.page.edit.custom', $dataArr->page_id));
});


Breadcrumbs::for('banner.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('banner.all_txt'), route('admin.banner.index'));
});

Breadcrumbs::for('banner.create', function ($trail) {
    $trail->parent('banner.index');
    $trail->push(__('banner.add_txt'), route('admin.banner.create'));
});

Breadcrumbs::for('banner.edit', function ($trail, $dataArr) {
    $trail->parent('banner.index');
    $trail->push(__('banner.edit_txt'), route('admin.banner.edit', $dataArr->bnr_id));
});


Breadcrumbs::for('testimonial.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('testimonial.all_txt'), route('admin.testimonial.index'));
});

Breadcrumbs::for('testimonial.create', function ($trail) {
    $trail->parent('testimonial.index');
    $trail->push(__('testimonial.add_txt'), route('admin.testimonial.create'));
});

Breadcrumbs::for('testimonial.edit', function ($trail, $dataArr) {
    $trail->parent('testimonial.index');
    $trail->push(__('testimonial.edit_txt'), route('admin.testimonial.edit', $dataArr->tmnl_id));
});


Breadcrumbs::for('faq.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('faq.all_txt'), route('admin.faq.index'));
});

Breadcrumbs::for('faq.create', function ($trail) {
    $trail->parent('faq.index');
    $trail->push(__('faq.add_txt'), route('admin.faq.create'));
});

Breadcrumbs::for('faq.edit', function ($trail, $dataArr) {
    $trail->parent('faq.index');
    $trail->push(__('faq.edit_txt'), route('admin.faq.edit', $dataArr->faq_id));
});


Breadcrumbs::for('menu.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.menu.all_txt'), route('admin.menu.index.custom'));
});

Breadcrumbs::for('menu.create', function ($trail) {
    $trail->parent('menu.index');
    $trail->push(__('admin.menu.add_txt'), route('admin.menu.create'));
});

Breadcrumbs::for('menutype.create', function ($trail) {
    $trail->parent('menu.index');
    $trail->push(__('admin.menutype.add_txt'), route('admin.menutype.create'));
});

Breadcrumbs::for('menutype.edit', function ($trail, $dataArr) {
    $trail->parent('menu.index');
    $trail->push(__('admin.menutype.edit_txt'), route('admin.menutype.edit', $dataArr->menu_type_id));
});


Breadcrumbs::for('currency.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.currency.all_txt'), route('admin.currency.index'));
});

Breadcrumbs::for('currency.create', function ($trail) {
    $trail->parent('currency.index');
    $trail->push(__('admin.currency.add_txt'), route('admin.currency.create'));
});

Breadcrumbs::for('currency.edit', function ($trail, $dataArr) {
    $trail->parent('currency.index');
    $trail->push(__('admin.currency.edit_txt'), route('admin.currency.edit', $dataArr->cm_id));
});


Breadcrumbs::for('indices.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.all_txt'), route('admin.indices.index'));
});

Breadcrumbs::for('indices.create', function ($trail) {
    $trail->parent('indices.index');
    $trail->push(__('admin.indices.add_txt'), route('admin.indices.create'));
});

Breadcrumbs::for('indices.edit', function ($trail, $dataArr) {
    $trail->parent('indices.index');
    $trail->push(__('admin.indices.edit_txt'), route('admin.indices.edit', $dataArr->idc_id));
});

Breadcrumbs::for('indices.nocor', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.nocor.all_txt'), route('admin.indices.nocor'));
});


Breadcrumbs::for('fundtype.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundtype.all_txt'), route('admin.fundtype.index'));
});

Breadcrumbs::for('fundtype.create', function ($trail) {
    $trail->parent('fundtype.index');
    $trail->push(__('admin.fundtype.add_txt'), route('admin.fundtype.create'));
});

Breadcrumbs::for('fundtype.edit', function ($trail, $dataArr) {
    $trail->parent('fundtype.index');
    $trail->push(__('admin.fundtype.edit_txt'), route('admin.fundtype.edit', $dataArr->ft_id));
});


Breadcrumbs::for('fundterm.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundterm.all_txt'), route('admin.fundterm.index'));
});

Breadcrumbs::for('fundterm.create', function ($trail) {
    $trail->parent('fundterm.index');
    $trail->push(__('admin.fundterm.add_txt'), route('admin.fundterm.create'));
});

Breadcrumbs::for('fundterm.edit', function ($trail, $dataArr) {
    $trail->parent('fundterm.index');
    $trail->push(__('admin.fundterm.edit_txt'), route('admin.fundterm.edit', $dataArr->ftm_id));
});


Breadcrumbs::for('fund.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.all_txt'), route('admin.fund.index'));
});

Breadcrumbs::for('fund.create', function ($trail) {
    $trail->parent('fund.index');
    $trail->push(__('admin.fund.add_txt'), route('admin.fund.create'));
});

Breadcrumbs::for('fund.edit', function ($trail, $dataArr) {
    $trail->parent('fund.index');
    $trail->push(__('admin.fund.edit_txt'), route('admin.fund.edit', $dataArr->fund_id));
});

Breadcrumbs::for('fund.nocor', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.nocor.all_txt'), route('admin.fund.nocor'));
});

Breadcrumbs::for('fund.corpus.edit', function ($trail, $dataArr, $activeTitle) {
    $trail->parent('fund.index');
    $trail->push($activeTitle, route('admin.fund.corpus.edit', $dataArr->fund_id));
});


Breadcrumbs::for('currency.values.edit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.currency.edit_daily_value_txt'), route('admin.currency.values.edit'));
});


Breadcrumbs::for('navs.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.nav.upld_daily_txt'), route('admin.navs.values.create'));
});

Breadcrumbs::for('navs.values.edit', function ($trail) {
    $trail->parent('navs.values.create');
    $trail->push(__('admin.fund.nav.list_upld_daily_txt'), route('admin.navs.values.edit'));
});


Breadcrumbs::for('indices.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.upld_daily_txt'), route('admin.indices.values.create'));
});

Breadcrumbs::for('indices.values.edit', function ($trail) {
    $trail->parent('indices.values.create');
    $trail->push(__('admin.indices.list_upld_daily_txt'), route('admin.indices.values.edit'));
});


Breadcrumbs::for('aums.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.aums.upld_lbl_txt'), route('admin.aums.values.create'));
});

Breadcrumbs::for('aums.values.edit', function ($trail) {
    $trail->parent('aums.values.create');
    $trail->push(__('admin.fund.aums.list_lbl_txt'), route('admin.aums.values.edit'));
});


Breadcrumbs::for('mcap-eps.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.mcapeps.upld_lbl_txt'), route('admin.mcap-eps.values.create'));
});


Breadcrumbs::for('indices-comp.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.comp.upld_lbl_txt'), route('admin.indices-comp.values.create'));
});


Breadcrumbs::for('fund-comp.values.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.comp.upld_lbl_txt'), route('admin.fund-comp.values.create'));
});


Breadcrumbs::for('navs.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.nav.list_label_txt'), route('admin.navs.list'));
});


Breadcrumbs::for('indices.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.list.label_txt'), route('admin.indices.list'));
});


Breadcrumbs::for('currencies.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.currency.list.label_txt'), route('admin.currencies.list'));
});


Breadcrumbs::for('aums.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.aums.list_label_txt'), route('admin.aums.list'));
});


Breadcrumbs::for('mcap-eps.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.mcapeps.list_label_txt'), route('admin.mcap-eps.list'));
});


Breadcrumbs::for('indices-comp.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.comp.list_label_txt'), route('admin.indices-comp.list'));
});


Breadcrumbs::for('fund-comp.list', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.comp.list_label_txt'), route('admin.fund-comp.list'));
});


Breadcrumbs::for('navs.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.nav.publish_label_txt'), route('admin.navs.publish.create'));
});


Breadcrumbs::for('indices.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.publish_label_txt'), route('admin.indices.publish.create'));
});


Breadcrumbs::for('currencies.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.currency.publish_label_txt'), route('admin.currencies.publish.create'));
});


Breadcrumbs::for('aums.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.aums.publish_label_txt'), route('admin.aums.publish.create'));
});


Breadcrumbs::for('mcap-eps.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.mcapeps.publish_label_txt'), route('admin.mcap-eps.publish.create'));
});


Breadcrumbs::for('indices-comp.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.comp.publish_label_txt'), route('admin.indices-comp.publish.create'));
});


Breadcrumbs::for('fund-comp.publish.create', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.comp.publish_label_txt'), route('admin.fund-comp.publish.create'));
});


Breadcrumbs::for('scrips.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.scrip.all_txt'), route('admin.scrips.index'));
});

Breadcrumbs::for('scrips.create', function ($trail) {
    $trail->parent('scrips.index');
    $trail->push(__('admin.scrip.add_txt'), route('admin.scrips.create'));
});

Breadcrumbs::for('scrips.createmanual', function ($trail) {
    $trail->parent('scrips.create');
    $trail->push(__('admin.scrip.add_manual_txt'), route('admin.scrips.createmanual'));
});

Breadcrumbs::for('scrips.edit', function ($trail, $dataArr) {
    $trail->parent('scrips.index');
    $trail->push(__('admin.scrip.edit_txt'), route('admin.scrips.edit', $dataArr->scrp_id));
});


Breadcrumbs::for('fundwatch.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundwatch.all_txt'), route('admin.fund-watch.index'));
});

Breadcrumbs::for('fundwatch.create', function ($trail) {
    $trail->parent('fundwatch.index');
    $trail->push(__('admin.fundwatch.add_txt'), route('admin.fund-watch.create'));
});

Breadcrumbs::for('fundwatch.edit', function ($trail, $dataArr) {
    $trail->parent('fundwatch.index');
    $trail->push(__('admin.fundwatch.edit_txt'), route('admin.fund-watch.edit', $dataArr->fw_id));
});


Breadcrumbs::for('funddictionary.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.funddictionary.all_txt'), route('admin.fund-dictionary.index'));
});

Breadcrumbs::for('funddictionary.create', function ($trail) {
    $trail->parent('funddictionary.index');
    $trail->push(__('admin.funddictionary.add_txt'), route('admin.fund-dictionary.create'));
});

Breadcrumbs::for('funddictionary.edit', function ($trail, $dataArr) {
    $trail->parent('funddictionary.index');
    $trail->push(__('admin.funddictionary.edit_txt'), route('admin.fund-dictionary.edit', $dataArr->fd_id));
});


Breadcrumbs::for('fundclassification.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundclassification.all_txt'), route('admin.fund-classification.index'));
});

Breadcrumbs::for('fundclassification.create', function ($trail) {
    $trail->parent('fundclassification.index');
    $trail->push(__('admin.fundclassification.add_txt'), route('admin.fund-classification.create'));
});

Breadcrumbs::for('fundclassification.edit', function ($trail, $dataArr) {
    $trail->parent('fundclassification.index');
    $trail->push(__('admin.fundclassification.edit_txt'), route('admin.fund-classification.edit', $dataArr->fc_id));
});


Breadcrumbs::for('fundtaxation.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundtaxation.all_txt'), route('admin.fund-taxation.index'));
});

Breadcrumbs::for('fundtaxation.create', function ($trail) {
    $trail->parent('fundtaxation.index');
    $trail->push(__('admin.fundtaxation.add_txt'), route('admin.fund-taxation.create'));
});

Breadcrumbs::for('fundtaxation.edit', function ($trail, $dataArr) {
    $trail->parent('fundtaxation.index');
    $trail->push(__('admin.fundtaxation.edit_txt'), route('admin.fund-taxation.edit', $dataArr->ft_id));
});


Breadcrumbs::for('missingnav.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fund.missing.label_txt'), route('admin.missing-nav.index'));
});

Breadcrumbs::for('missingnav.create', function ($trail) {
    $trail->parent('missingnav.index');
    $trail->push(__('admin.fund.missing.upld_lbl_txt'), route('admin.missing-nav.create'));
});


Breadcrumbs::for('fundman.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundman.all_txt'), route('admin.fund-man.index'));
});

Breadcrumbs::for('fundman.create', function ($trail) {
    $trail->parent('fundman.index');
    $trail->push(__('admin.fundman.add_txt'), route('admin.fund-man.create'));
});

Breadcrumbs::for('fundman.edit', function ($trail, $dataArr) {
    $trail->parent('fundman.index');
    $trail->push(__('admin.fundman.edit_txt'), route('admin.fund-man.edit', $dataArr->fm_id));
});


Breadcrumbs::for('news.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('news.all_txt'), route('admin.news.index'));
});

Breadcrumbs::for('news.create', function ($trail) {
    $trail->parent('news.index');
    $trail->push(__('news.add_txt'), route('admin.news.create'));
});

Breadcrumbs::for('news.edit', function ($trail, $dataArr) {
    $trail->parent('news.index');
    $trail->push(__('news.edit_txt'), route('admin.news.edit', $dataArr->n_id));
});

Breadcrumbs::for('plan.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('plan.all_txt'), route('admin.plan.index'));
});

Breadcrumbs::for('plan.create', function ($trail) {
    $trail->parent('plan.index');
    $trail->push(__('plan.add_txt'), route('admin.plan.create'));
});

Breadcrumbs::for('plan.edit', function ($trail, $dataArr) {
    $trail->parent('plan.index');
    $trail->push(__('plan.edit_txt'), route('admin.plan.edit', $dataArr->p_id));
});


Breadcrumbs::for('newsletter.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.newsletter.all_txt'), route('admin.newsletter.index'));
});


Breadcrumbs::for('faqcategory.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.common_category.all_txt'), route('admin.faq-category.index'));
});

Breadcrumbs::for('faqcategory.create', function ($trail) {
    $trail->parent('faqcategory.index');
    $trail->push(__('admin.common_category.add_txt'), route('admin.faq-category.create'));
});

Breadcrumbs::for('faqcategory.edit', function ($trail, $dataArr) {
    $trail->parent('faqcategory.index');
    $trail->push(__('admin.common_category.edit_txt'), route('admin.faq-category.edit', $dataArr->cc_id));
});


Breadcrumbs::for('team.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.team.all_txt'), route('admin.team.index'));
});

Breadcrumbs::for('team.create', function ($trail) {
    $trail->parent('team.index');
    $trail->push(__('admin.team.add_txt'), route('admin.team.create'));
});

Breadcrumbs::for('team.edit', function ($trail, $dataArr) {
    $trail->parent('team.index');
    $trail->push(__('admin.team.edit_txt'), route('admin.team.edit', $dataArr->team_id));
});


Breadcrumbs::for('knowtheratio.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.knowtheratio.all_txt'), route('admin.know-the-ratio.index'));
});

Breadcrumbs::for('knowtheratio.create', function ($trail) {
    $trail->parent('knowtheratio.index');
    $trail->push(__('admin.knowtheratio.add_txt'), route('admin.know-the-ratio.create'));
});

Breadcrumbs::for('knowtheratio.edit', function ($trail, $dataArr) {
    $trail->parent('knowtheratio.index');
    $trail->push(__('admin.knowtheratio.edit_txt'), route('admin.know-the-ratio.edit', $dataArr->ktr_id));
});


Breadcrumbs::for('fundsuggestion.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.fundsuggestion.all_txt'), route('admin.fund-suggestion.index'));
});

Breadcrumbs::for('fundsuggestion.create', function ($trail) {
    $trail->parent('fundsuggestion.index');
    $trail->push(__('admin.fundsuggestion.add_txt'), route('admin.fund-suggestion.create'));
});

Breadcrumbs::for('fundsuggestion.edit', function ($trail, $dataArr) {
    $trail->parent('fundsuggestion.index');
    $trail->push(__('admin.fundsuggestion.edit_txt'), route('admin.fund-suggestion.edit', $dataArr->fs_id));
});


Breadcrumbs::for('topic.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('askexpert.topic.all_txt'), route('admin.topic.index'));
});

Breadcrumbs::for('topic.create', function ($trail) {
    $trail->parent('topic.index');
    $trail->push(__('askexpert.topic.add_txt'), route('admin.topic.create'));
});

Breadcrumbs::for('topic.edit', function ($trail, $dataArr) {
    $trail->parent('topic.index');
    $trail->push(__('askexpert.topic.edit_txt'), route('admin.topic.edit', $dataArr->aet_id));
});

Breadcrumbs::for('question.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('askexpert.question.all_txt'), route('admin.question.index'));
});

Breadcrumbs::for('question.create', function ($trail) {
    $trail->parent('question.index');
    $trail->push(__('askexpert.question.add_txt'), route('admin.question.create'));
});

Breadcrumbs::for('question.edit', function ($trail, $dataArr) {
    $trail->parent('question.index');
    $trail->push(__('askexpert.question.edit_txt'), route('admin.question.edit', $dataArr->aet_id));
});

Breadcrumbs::for('answer.index', function ($trail, $aeqId) {
    $trail->parent('dashboard');
    $trail->push(__('askexpert.answer.all_txt'), route('admin.answer.list', $aeqId));
});

Breadcrumbs::for('answer.edit', function ($trail, $dataArr) {
    $trail->parent('answer.index', $dataArr->aeq_id);
    $trail->push(__('askexpert.answer.edit_txt'), route('admin.answer.edit', $dataArr->aet_id));
});


Breadcrumbs::for('nfomonitor.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.nfomonitor.all_txt'), route('admin.nfo-monitor.index'));
});

Breadcrumbs::for('nfomonitor.create', function ($trail) {
    $trail->parent('nfomonitor.index');
    $trail->push(__('admin.nfomonitor.add_txt'), route('admin.nfo-monitor.create'));
});

Breadcrumbs::for('nfomonitor.edit', function ($trail, $dataArr) {
    $trail->parent('nfomonitor.index');
    $trail->push(__('admin.nfomonitor.edit_txt'), route('admin.nfo-monitor.edit', $dataArr->no_id));
});


Breadcrumbs::for('missingindices.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.indices.missing.label_txt'), route('admin.missing-indices.index'));
});

Breadcrumbs::for('missingindices.create', function ($trail) {
    $trail->parent('missingindices.index');
    $trail->push(__('admin.indices.missing.upld_lbl_txt'), route('admin.missing-indices.create'));
});


Breadcrumbs::for('missingcurrency.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('admin.currency.missing.label_txt'), route('admin.missing-currency.index'));
});

Breadcrumbs::for('missingcurrency.create', function ($trail) {
    $trail->parent('missingcurrency.index');
    $trail->push(__('admin.currency.missing.upld_lbl_txt'), route('admin.missing-currency.create'));
});
