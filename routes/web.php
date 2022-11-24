<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::namespace('App\Http\Controllers\Admin')->name('admin.')->prefix(Config('commonconstants.admin_prefix'))->group(function () {
    Route::get('error/{error_code?}', ['uses' => 'BaseController@error', 'as' => 'error']);

    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('/', 'AuthController@login')->name('login.post');
    Route::get('/forgotpassword', 'AuthController@showForgotpasswordForm')->name('forgotpassword');
    Route::post('/forgotpassword', 'AuthController@forgotPassword')->name('forgotpassword.post');
    Route::get('/logout', 'AuthController@logout')->name('logout');

    Route::group(['middleware' => ['admin']], function () {

        Route::group(['prefix'=>'blog'], function(){
            Route::get('/','BlogController@index')->name('blog.index');
            Route::get('/create', 'BlogController@create')->name('blog.create');
            Route::post('/store/{id?}', 'BlogController@store')->name('blog.store');
            Route::get('/store/{id?}', 'BlogController@edit')->name('blog.edit');
            Route::post('/delete', 'BlogController@delete')->name('blog.delete');
            Route::get('/comments/{id}', 'BlogController@comments')->name('blog.comments');
           
        });
        Route::group(['prefix'=>'latest_update'],function(){
            Route::get('/','HomeLatestController@index')->name('latest.index');
            Route::post('/create','HomeLatestController@create')->name('latest.create');
        });
        Route::post('/change-status', 'BaseController@changeStatus')->name('changestatus');
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('/profile', 'AdminController@editprofile')->name('profile');
        Route::post('/profile/{id}', 'AdminController@update')->name('profile.update');

        Route::resource('admin', 'AdminController', ['except' => 'show', 'destroy']);
        Route::post('/admin/deleteuser', 'AdminController@deletedata')->name('deleteuser');

        Route::resource('adminrole', 'AdminroleController', ['except' => 'show', 'destroy']);
        Route::post('/admin/deleteuserrole', 'AdminroleController@deletedata')->name('deleteuserrole');

        Route::get('/subscribeduser/createmanual', 'SubscribeduserController@createmanual')->name('subscribeduser.createmanual');
        Route::post('/subscribeduser/uploadfile', 'SubscribeduserController@import')->name('subscribeduser.uploadfile');

        Route::resource('subscribeduser', 'SubscribeduserController', ['except' => 'show', 'destroy']);
        Route::post('/subscribeduser/deletesubscribeduser', 'SubscribeduserController@deletedata')->name('deletesubscribeduser');
        Route::get('/subscribeduser/deletepicture/{id}', 'SubscribeduserController@deletepicture')->name('subscribeduser.deletepicture');

        Route::resource('usergroup', 'UsergroupController', ['except' => 'show', 'destroy']);
        Route::post('/usergroup/deleteusergroup', 'UsergroupController@deletedata')->name('deleteusergroup');

        Route::get('/media/gallery/{typeid}', 'MediaController@getGallery')->name('media.gallery');
        Route::get('/media/mediainfo/{id}', 'MediaController@getMediainfo')->name('media.info');
        Route::post('/media/ajaxupdate', 'MediaController@updateajax')->name('media.ajaxupdate');
        Route::post('/media/ajaxupload', 'MediaController@storeajax')->name('media.ajaxupload');
        Route::get('/media/ajaxdelete/{id}', 'MediaController@destroyajax')->name('media.ajaxdelete');

        Route::resource('media', 'MediaController', ['except' => 'store', 'show', 'destroy']);
        Route::post('/media/deletemedia', 'MediaController@deletedata')->name('deletemedia');

        Route::get('/contact/export/', 'ContactController@export')->name('contact.export');
        Route::resource('contact', 'ContactController', ['except' => 'create', 'store', 'edit', 'update', 'destroy']);
        Route::post('/contact/deletecontact', 'ContactController@deletedata')->name('deletecontact');

        Route::get('/settings/general', 'SettingsController@editGeneral')->name('settings.general');
        Route::post('/settings/general', 'SettingsController@updateGeneral')->name('settings.general.update');
        Route::get('/settings/options', 'SettingsController@editOptions')->name('settings.options');
        Route::post('/settings/options', 'SettingsController@updateOptions')->name('settings.options.update');
        Route::get('/settings/mail_setting', 'SettingsController@editMail')->name('settings.mail');
        Route::post('/settings/mail_setting', 'SettingsController@updateMail')->name('settings.mail.update');
        Route::get('/settings/custom', 'SettingsController@editCustom')->name('settings.custom');
        Route::post('/settings/custom', 'SettingsController@updateCustom')->name('settings.custom.update');
        Route::get('/settings/social', 'SettingsController@editSocial')->name('settings.social');
        Route::post('/settings/social', 'SettingsController@updateSocial')->name('settings.social.update');
        Route::get('/settings/deletefile/{id}', 'SettingsController@deletefile')->name('settings.deletefile');

        Route::resource('template', 'TemplateController', ['except' => 'show', 'destroy']);
        Route::post('/template/deletetemplate', 'TemplateController@deletedata')->name('deletetemplate');

        Route::resource('customfield', 'CustomfieldController', ['except' =>  'destroy']);
        Route::post('/customfield/delete', 'CustomfieldController@deletedata')->name('deletecustomfield');

        Route::resource('customfield.grouptype', 'CustomfieldGrouptypeController', ['except' =>  'destroy']);
        Route::post('/customfield/grouptype/delete', 'CustomfieldGrouptypeController@deletedata')->name('deletecustomfieldgrouptype');
        Route::get('/customfield/grouptype/defaultoption/{field_type}', 'CustomfieldGrouptypeController@getDefaultOptionByFieldType')->name('customfield.grouptype.defaultoption');

        Route::resource('customfield.grouptype.classtemplate', 'CustomfieldGrouptypeClasstemplateController', ['except' =>  'destroy']);
        Route::post('/customfield/grouptype/classtemplate/delete', 'CustomfieldGrouptypeClasstemplateController@deletedata')->name('deletecustomfieldgrouptypeclasstemplate');
        Route::get('/customfield/grouptype/classtemplate/getclasstemplate/{class_id}', 'CustomfieldGrouptypeClasstemplateController@getTemplateByClassId')->name('customfield.grouptype.classtemplate.getclasstemplate');

        Route::resource('page', 'PageController', ['except' => 'show', 'destroy']);
        Route::get('/page/create/{tid?}', [
            'as' => 'page.create.custom',
            'uses' => 'PageController@create'
        ]);
        Route::get('/page/edit/{id?}/{tid?}', [
            'as' => 'page.edit.custom',
            'uses' => 'PageController@edit'
        ]);
        Route::post('/page/deletepage', 'PageController@deletedata')->name('deletepage');

        Route::resource('menu', 'MenuController', ['except' => 'show']);
        Route::get('/menu/{mtid?}', [
            'as' => 'menu.index.custom',
            'uses' => 'MenuController@index'
        ]);
        Route::get('/menu/delete/{mid}', [
            'as' => 'menu.destroy.custom',
            'uses' => 'MenuController@destroy'
        ]);
        Route::resource('menutype', 'MenutypeController', ['except' => 'index', 'show']);
        Route::get('/menutype/delete/{mid}', [
            'as' => 'menutype.destroy.custom',
            'uses' => 'MenutypeController@destroy'
        ]);

        Route::resource('banner', 'BannerController', ['except' => 'show', 'destroy']);
        Route::post('/banner/delete', 'BannerController@deletedata')->name('banner.delete');

        Route::resource('testimonial', 'TestimonialController', ['except' => 'show', 'destroy']);
        Route::post('/testimonial/delete', 'TestimonialController@deletedata')->name('testimonial.delete');

        Route::resource('faq', 'FAQController', ['except' => 'show', 'destroy']);
        Route::post('/faq/delete', 'FAQController@deletedata')->name('faq.delete');
        Route::resource('faq-category', 'FAQCategoryController', ['except' => 'show', 'destroy']);
        Route::post('/faq-category/delete', 'FAQCategoryController@deletedata')->name('faq-category.delete');

        Route::resource('currency', 'CurrencyMasterController', ['except' => 'show', 'destroy']);
        Route::post('/currency/delete', 'CurrencyMasterController@deletedata')->name('currency.delete');

        Route::resource('indices', 'IndicesMasterController', ['except' => 'show', 'destroy']);
        Route::get('indices/{time?}', [
            'as' => 'indicess.index',
            'uses' => 'IndicesMasterController@index'
        ]);
        Route::get('indices/download-deleted/{time?}', [
            'as' => 'indices.download-deleted',
            'uses' => 'IndicesMasterController@downloaddeleted'
        ]);
        Route::post('/indices/delete', 'IndicesMasterController@deletedata')->name('indices.delete');
        Route::get('indices/nocor', [
            'as' => 'indices.nocor',
            'uses' => 'IndicesMasterController@indexnocor'
        ]);

        Route::resource('fundtype', 'FundTypeController', ['except' => 'show', 'destroy']);
        Route::post('/fundtype/delete', 'FundTypeController@deletedata')->name('fundtype.delete');

        Route::resource('fundterm', 'FundTermController', ['except' => 'show', 'destroy']);
        Route::post('/fundterm/delete', 'FundTermController@deletedata')->name('fundterm.delete');

        Route::resource('fund', 'FundMasterController', ['except' => 'show', 'destroy']);
        Route::post('/fund/delete', 'FundMasterController@deletedata')->name('fund.delete');
        Route::get('fund/nocor', [
            'as' => 'fund.nocor',
            'uses' => 'FundMasterController@indexnocor'
        ]);
        Route::get('fund/corpus/{id}', [
            'as' => 'fund.corpus.edit',
            'uses' => 'FundMasterController@editcorpus'
        ]);
        Route::post('fund/corpus/{id}', [
            'as' => 'fund.corpus.update',
            'uses' => 'FundMasterController@updatecorpus'
        ]);

        Route::get('currency/values', [
            'as' => 'currency.values.edit',
            'uses' => 'DailyCurrenciesValueController@editvalues'
        ]);
        Route::post('currency/values', [
            'as' => 'currency.values.update',
            'uses' => 'DailyCurrenciesValueController@updatevalues'
        ]);

        Route::get('navs/values/upload', [
            'as' => 'navs.values.create',
            'uses' => 'DailyNavsValueController@create'
        ]);
        Route::post('navs/values/upload', [
            'as' => 'navs.values.store',
            'uses' => 'DailyNavsValueController@store'
        ]);
        Route::get('navs/values/uploaded-list/{type?}', [
            'as' => 'navs.values.edit',
            'uses' => 'DailyNavsValueController@edit'
        ]);
        Route::post('navs/values/upload-list/{type?}', [
            'as' => 'navs.values.update',
            'uses' => 'DailyNavsValueController@update'
        ]);

        Route::get('indices/values/upload', [
            'as' => 'indices.values.create',
            'uses' => 'DailyIndicesValueController@create'
        ]);
        Route::post('indices/values/upload', [
            'as' => 'indices.values.store',
            'uses' => 'DailyIndicesValueController@store'
        ]);
        Route::get('indices/values/uploaded-list/{type?}', [
            'as' => 'indices.values.edit',
            'uses' => 'DailyIndicesValueController@edit'
        ]);
        Route::post('indices/values/upload-list/{type?}', [
            'as' => 'indices.values.update',
            'uses' => 'DailyIndicesValueController@update'
        ]);

        Route::get('aums/values/upload', [
            'as' => 'aums.values.create',
            'uses' => 'MonthlyAUMsValueController@create'
        ]);
        Route::post('aums/values/upload', [
            'as' => 'aums.values.store',
            'uses' => 'MonthlyAUMsValueController@store'
        ]);
        Route::get('aums/values/uploaded-list/{date?}', [
            'as' => 'aums.values.edit',
            'uses' => 'MonthlyAUMsValueController@edit'
        ]);
        Route::post('aums/values/upload-list', [
            'as' => 'aums.values.update',
            'uses' => 'MonthlyAUMsValueController@update'
        ]);

        Route::get('mcap-eps/values/upload/{msg?}', [
            'as' => 'mcap-eps.values.create',
            'uses' => 'MonthlyMcapEpsValueController@create'
        ]);
        Route::post('mcap-eps/values/upload/{msg?}', [
            'as' => 'mcap-eps.values.store',
            'uses' => 'MonthlyMcapEpsValueController@store'
        ]);

        Route::get('indices-comp/values/upload/{msg?}', [
            'as' => 'indices-comp.values.create',
            'uses' => 'MonthlyIndicesCompValueController@create'
        ]);
        Route::post('indices-comp/values/upload/{msg?}', [
            'as' => 'indices-comp.values.store',
            'uses' => 'MonthlyIndicesCompValueController@store'
        ]);

        Route::get('fund-comp/values/upload/{msg?}', [
            'as' => 'fund-comp.values.create',
            'uses' => 'MonthlyFundCompValueController@create'
        ]);
        Route::post('fund-comp/values/upload/{msg?}', [
            'as' => 'fund-comp.values.store',
            'uses' => 'MonthlyFundCompValueController@store'
        ]);

        Route::get('navs/list', [
            'as' => 'navs.list',
            'uses' => 'NavsController@index'
        ]);
        Route::post('/navs/delete', 'NavsController@deletedata')->name('navs.delete');

        Route::get('indices/uploaded/list', [
            'as' => 'indices.list',
            'uses' => 'IndicesController@index'
        ]);
        Route::post('/indices/uploaded/list/delete', 'IndicesController@deletedata')->name('indices.list.delete');

        Route::get('currencies/list', [
            'as' => 'currencies.list',
            'uses' => 'CurrenciesController@index'
        ]);
        Route::post('/currencies/delete', 'CurrenciesController@deletedata')->name('currencies.delete');

        Route::get('aums/list', [
            'as' => 'aums.list',
            'uses' => 'AUMsController@index'
        ]);
        Route::post('/aums/delete', 'AUMsController@deletedata')->name('aums.delete');

        Route::get('mcap-eps/list', [
            'as' => 'mcap-eps.list',
            'uses' => 'McapEpsController@index'
        ]);
        Route::post('/mcap-eps/delete', 'McapEpsController@deletedata')->name('mcap-eps.delete');

        Route::get('indices-comp/list', [
            'as' => 'indices-comp.list',
            'uses' => 'IndicesCompController@index'
        ]);
        Route::post('/indices-comp/delete', 'IndicesCompController@deletedata')->name('indices-comp.delete');

        Route::get('fund-comp/list', [
            'as' => 'fund-comp.list',
            'uses' => 'FundCompController@index'
        ]);
        Route::post('/fund-comp/delete', 'FundCompController@deletedata')->name('fund-comp.delete');

        Route::get('navs/publish/create', [
            'as' => 'navs.publish.create',
            'uses' => 'NavsPublishController@create'
        ]);
        Route::post('navs/publish/create', [
            'as' => 'navs.publish.store',
            'uses' => 'NavsPublishController@store'
        ]);

        Route::get('indices/publish/create', [
            'as' => 'indices.publish.create',
            'uses' => 'IndicesPublishController@create'
        ]);
        Route::post('indices/publish/create', [
            'as' => 'indices.publish.store',
            'uses' => 'IndicesPublishController@store'
        ]);

        Route::get('currencies/publish/create', [
            'as' => 'currencies.publish.create',
            'uses' => 'CurrenciesPublishController@create'
        ]);
        Route::post('currencies/publish/create', [
            'as' => 'currencies.publish.store',
            'uses' => 'CurrenciesPublishController@store'
        ]);

        Route::get('aums/publish/create', [
            'as' => 'aums.publish.create',
            'uses' => 'AUMsPublishController@create'
        ]);
        Route::post('aums/publish/create', [
            'as' => 'aums.publish.store',
            'uses' => 'AUMsPublishController@store'
        ]);

        Route::get('mcap-eps/publish/create', [
            'as' => 'mcap-eps.publish.create',
            'uses' => 'McapEpsPublishController@create'
        ]);
        Route::post('mcap-eps/publish/create', [
            'as' => 'mcap-eps.publish.store',
            'uses' => 'McapEpsPublishController@store'
        ]);

        Route::get('indices-comp/publish/create', [
            'as' => 'indices-comp.publish.create',
            'uses' => 'IndicesCompPublishController@create'
        ]);
        Route::post('indices-comp/publish/create', [
            'as' => 'indices-comp.publish.store',
            'uses' => 'IndicesCompPublishController@store'
        ]);

        Route::get('fund-comp/publish/create', [
            'as' => 'fund-comp.publish.create',
            'uses' => 'FundCompPublishController@create'
        ]);
        Route::post('fund-comp/publish/create', [
            'as' => 'fund-comp.publish.store',
            'uses' => 'FundCompPublishController@store'
        ]);

        Route::resource('scrips', 'ScripsController', ['except' => 'show', 'destroy']);
        Route::post('/scrips/delete', 'ScripsController@deletedata')->name('scrips.delete');
        Route::get('/scrips/create-manual', 'ScripsController@createmanual')->name('scrips.createmanual');
        Route::post('/scrips/uploadfile', 'ScripsController@import')->name('scrips.uploadfile');

        Route::get('/clear-cache', 'DashboardController@cleardata')->name('clearcache');

        Route::resource('fund-watch', 'FundWatchController', ['except' => 'show', 'destroy']);
        Route::post('/fund-watch/delete', 'FundWatchController@deletedata')->name('fund-watch.delete');

        Route::resource('fund-dictionary', 'FundDictionaryController', ['except' => 'show', 'destroy']);
        Route::post('/fund-dictionary/delete', 'FundDictionaryController@deletedata')->name('fund-dictionary.delete');

        Route::resource('fund-classification', 'FundClassificationController', ['except' => 'show', 'destroy']);
        Route::post('/fund-classification/delete', 'FundClassificationController@deletedata')->name('fund-classification.delete');

        Route::resource('fund-taxation', 'FundTaxationController', ['except' => 'show', 'destroy']);
        Route::post('/fund-taxation/delete', 'FundTaxationController@deletedata')->name('fund-taxation.delete');

        Route::get('missing-nav/list', [
            'as' => 'missing-nav.index',
            'uses' => 'MissingNavController@index'
        ]);
        Route::get('/missing-nav/export/', 'MissingNavController@export')->name('missing-nav.export');
        Route::get('missing-nav/create', [
            'as' => 'missing-nav.create',
            'uses' => 'MissingNavController@create'
        ]);
        Route::post('missing-nav/store', [
            'as' => 'missing-nav.store',
            'uses' => 'MissingNavController@store'
        ]);

        Route::get('missing-indices/list', [
            'as' => 'missing-indices.index',
            'uses' => 'MissingIndicesController@index'
        ]);
        Route::get('/missing-indices/export/', 'MissingIndicesController@export')->name('missing-indices.export');
        Route::get('missing-indices/create', [
            'as' => 'missing-indices.create',
            'uses' => 'MissingIndicesController@create'
        ]);
        Route::post('missing-indices/store', [
            'as' => 'missing-indices.store',
            'uses' => 'MissingIndicesController@store'
        ]);

        Route::get('missing-currency/list', [
            'as' => 'missing-currency.index',
            'uses' => 'MissingCurrencyController@index'
        ]);
        Route::get('/missing-currency/export/', 'MissingCurrencyController@export')->name('missing-currency.export');
        Route::get('missing-currency/create', [
            'as' => 'missing-currency.create',
            'uses' => 'MissingCurrencyController@create'
        ]);
        Route::post('missing-currency/store', [
            'as' => 'missing-currency.store',
            'uses' => 'MissingCurrencyController@store'
        ]);

        Route::resource('fund-man', 'FundManController', ['except' => 'show', 'destroy']);
        Route::post('/fund-man/delete', 'FundManController@deletedata')->name('fund-man.delete');

        Route::resource('news', 'NewsController', ['except' => 'show', 'destroy']);
        Route::post('/news/delete', 'NewsController@deletedata')->name('news.delete');
        Route::get('/news/deletefile/{id}/{name}/{key}', 'NewsController@deletefile')->name('news.deletefile');

        Route::resource('plan', 'PlanController', ['except' => 'show', 'edit', 'update', 'destroy']);
        Route::post('/plan/delete', 'PlanController@deletedata')->name('plan.delete');

        Route::get('/newsletter/export/', 'NewsletterController@export')->name('newsletter.export');
        Route::resource('newsletter', 'NewsletterController', ['except' => 'create', 'store', 'show', 'edit', 'update', 'destroy']);
        Route::post('/newsletter/delete', 'NewsletterController@deletedata')->name('newsletter.delete');

        Route::resource('team', 'TeamsController', ['except' => 'show', 'destroy']);
        Route::post('/team/delete', 'TeamsController@deletedata')->name('team.delete');

        Route::resource('know-the-ratio', 'KnowTheRatioController', ['except' => 'show', 'destroy']);
        Route::post('/know-the-ratio/delete', 'KnowTheRatioController@deletedata')->name('know-the-ratio.delete');

        Route::resource('fund-suggestion', 'FundSuggestionController', ['except' => 'show', 'destroy']);
        Route::post('/fund-suggestion/delete', 'FundSuggestionController@deletedata')->name('fund-suggestion.delete');

        Route::resource('topic', 'AskExpertTopicController', ['except' => 'show', 'destroy']);
        Route::post('/topic/delete', 'AskExpertTopicController@deletedata')->name('topic.delete');
        Route::resource('question', 'AskExpertQuestionController', ['except' => 'create', 'store', 'show', 'destroy']);
        Route::post('/question/delete', 'AskExpertQuestionController@deletedata')->name('question.delete');
        Route::resource('answer', 'AskExpertQuestionAnswerController', ['except' => 'show', 'destroy', 'index', 'create', 'store']);
        Route::post('/answer/delete', 'AskExpertQuestionAnswerController@deletedata')->name('answer.delete');
        Route::get('answer/{aeq_id}', 'AskExpertQuestionAnswerController@index')->name('answer.list');

        Route::resource('nfo-monitor', 'NfoMonitorController', ['except' => 'show', 'destroy']);
        Route::post('/nfo-monitor/delete', 'NfoMonitorController@deletedata')->name('nfo-monitor.delete');
    });
});


/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
|
| Here is where you can register website routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('App\Http\Controllers\Web')->name('web.')->group(function () {
    Route::get('/storage/{img}/{folder}/{h?}/{w?}/{q?}', [
        'as' => 'storage',
        'uses' => 'ImageResizerController@show'
    ]);

    Route::get('/', 'PageController@homeData')->name('home');
    Route::post('newsletter-signup', 'NesletterController@StoreNewsLetter')->name('newsletter.save');

    Route::get('page/{slug?}', 'PageController@pageData')->name('page');
    Route::get('about', 'PageController@aboutData')->name('about');
    Route::get('thank-you/{slug?}', 'PageController@thankYouData')->name('thankyou');

    Route::get('know-your-scheme', 'PageController@knowYourSchemeData')->name('know.your.scheme');
    Route::get('fund-portfolio', 'PageController@fundPortfolioData')->name('fund.portfolio');
    Route::get('composition-snapshot', 'PageController@compositionSnapshotData')->name('composition.snapshot');
    Route::get('composition-snapshot-pdf/{type_id}', 'PDFDataController@compositionSnapshotPDF')->name('composition.snapshot.pdf');
    Route::get('weekly-snapshot', 'PageController@weeklySnapshotData')->name('weekly.snapshot');
    Route::get('monthly-snapshot', 'PageController@monthlySnapshotData')->name('monthly.snapshot');
    Route::get('monthly-ranking', 'PageController@monthlyRankingData')->name('monthly.ranking');
    Route::get('monthly-ranking-pdf/{type_id}', 'PDFDataController@monthlyRankingPDF')->name('monthly.ranking.pdf');
    Route::get('fund-performance', 'PageController@fundPerformanceData')->name('fund.performance');
    Route::get('compare-scheme', 'PageController@compareSchemeData')->name('compare.scheme');
    Route::get('performance-snapshot', 'PageController@performanceSnapshotData')->name('performance.snapshot');
    // Route::any('calculator', 'PageController@calculatorsPageData')->name('calculators');
    Route::any('calculator', 'CalculatorController@calculatorsPageData')->name('calculators');
    Route::any('objective-calculator', 'CalculatorController@ObjectiveCalculator')->name('calculators.objective');
    Route::any('inflation_calculator', 'CalculatorController@InflationCalculator')->name('calculators.inflation');
    Route::any('retirement_calualtor', 'CalculatorController@RetirementCalculator')->name('calculators.retirement');
    Route::any('risk_evaluation', 'CalculatorController@RiskCalculator')->name('calculators.risk');

    Route::get('calculator-login/{provider}', 'PageController@redirectCalculator')->name('calculators.social.login');
    Route::any('calculator-login/{provider}/callback', 'PageController@callbackCalculator')->name('calculators.social.login.callback');

    Route::get('contact', 'EnquiryController@contactData')->name('contact');
    Route::post('contact-process', 'EnquiryController@storeContact')->name('contact.save');

    Route::get('meet-the-fund-man/{slug?}', 'PageController@fundManData')->name('fundman');
    Route::get('founder', 'PageController@founder')->name('founder');

    Route::get('mutual-fund-dictionary', 'MutualFundDictionaryController@index')->name('mutualfunddictionary');
    Route::get('mutual-fund-dictionary-list', 'MutualFundDictionaryController@dataList')->name('mutualfunddictionary.list');

    Route::get('faq', 'PageController@faqData')->name('faq');
    Route::get('mutual-fund-classifications/{id?}', 'PageController@mutualFundClassificationsData')->name('mutualfundclassifications');
    Route::get('mutual-fund-taxation/{id?}', 'PageController@mutualFundTaxationData')->name('mutualfundtaxation');
    Route::get('know-the-ratio', 'PageController@knowTheRatioData')->name('knowtheratio');
    Route::get('thoughts-and-opinion-on-funds', 'PageController@thoughtsAndOpinionOnFundsData')->name('thoughtsandopiniononfunds');

    Route::get('nfo-monitor-list/{year?}', 'NfoMonitorController@index')->name('nfomonitor.list');
    Route::get('nfo-monitor/{id}', 'NfoMonitorController@show')->name('nfomonitor');
    // Route::get('nfo-monitor', 'NfoMonitorController@index')->name('nfomonitor.html');

    Route::get('ask-an-expert', 'AskExpertController@askExpertData')->name('ask-expert');
    Route::get('ask-an-expert/topic/{slug}', 'AskExpertController@askExpertTopicData')->name('ask-expert.topic');
    Route::post('like', 'LikeUnlikeController@captureLUData')->name('likeunlike');

    Route::get('in-the-news', 'PageController@newsData')->name('news');
    Route::get('pentatec-filter', 'PageController@pentatecData')->name('pentatec');

    Route::get('fund-watch-list/{year?}', 'FundWatchController@index')->name('fundwatch.list');
    Route::get('fund-watch/{id}', 'FundWatchController@show')->name('fundwatch');
    Route::get('fund-watch', 'FundWatchController@newIndex')->name('fundwatch.index');

    //  added by pixel
    Route::get('mf-taxation','MfTaxationController@index')->name('mf.index');
    Route::get('pentatech','MfTaxationController@pentatech')->name('pentatech.index');
    //  added by pixel end

    #== Start: Manage by AuthController only ==#
    Route::get('login', 'AuthController@loginForm')->name('login');
    Route::post('login-process', 'AuthController@login')->name('login.request');
    Route::get('logout', 'AuthController@logout')->name('logout');

    Route::get('signup', 'AuthController@signupData')->name('signup');
    Route::post('signup-process', 'AuthController@signup')->name('signup.save');

    Route::get('forgot-password', 'AuthController@forgotPassword')->name('forgot.password');
    Route::post('forgot-password-process', 'AuthController@forgotPasswordSendCode')->name('forgot.password.sendcode');

    Route::get('forgot-password-verification', 'AuthController@forgotPasswordVerificationCode')->name('forgot.password.verification.code');
    Route::post('forgot-password-verification-process', 'AuthController@forgotPasswordVerificationCodeCheck')->name('forgot.password.verification.codecheck');

    Route::get('forgot-reset-password/{code}', 'AuthController@forgotResetPassword')->name('forgot.reset.password');
    Route::post('forgot-reset-password-process/{code}', 'AuthController@forgotResetPasswordSave')->name('forgot.reset.password.save');
    #== END:Manage by AuthController only ==#

    Route::get('ask-question', 'AskExpertController@askQuestionData')->name('ask-question');
    #==Auth dependent pages ==#
    Route::group(['middleware' => ['auth']], function () {
        Route::get('myaccount', 'UserController@myAccountData')->name('myaccount');
        Route::get('edit-profile', 'UserController@editProfileData')->name('edit.profile');
        Route::post('edit-profile', 'UserController@updateProfile')->name('edit.profile.save');
        Route::get('reset-password', 'UserController@resetPasswordData')->name('reset.password');
        Route::post('reset-password', 'UserController@resetPassword')->name('reset.password.save');

        Route::post('ask-question', 'AskExpertController@askQuestionSave')->name('ask-question.save');
        Route::get('add-answer/{aeq_id}', 'AskExpertController@addAnswerData')->name('add-answer');
        Route::post('add-answer/{aeq_id}', 'AskExpertController@answerSave')->name('add-answer.save');
        Route::get('answer-drafts', 'AskExpertController@answerDraftData')->name('answer.drafts');
        Route::post('delete-draft/{id}', 'AskExpertController@deleteAnswerDraft')->name('answer.draft.delete');
        Route::get('draft-answer/{aeqa_id}', 'AskExpertController@draftAnswerData')->name('draft-answer');
        Route::post('draft-answer/{aeqa_id}', 'AskExpertController@draftAnswerSave')->name('draft-answer.save');
    });

    Route::get('money_seriously','BlogController@getBlogs')->name('get-blogs');
    Route::get('money_seriously/{unique_url}','BlogController@getBlogDetails')->name('get-blogs-detail');
    Route::post('money_seriously','BlogController@postBlogDetails')->name('post-blogs-detail');
    
});
