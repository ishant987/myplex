<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ModuleClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment(['production'])) {
            print "\nOpps! you are in production environment. You are not authorized to run.\n";
            die();
        }

        DB::table('module_class')->truncate();

        $dataArr = array(
            array('class_id' => '1', 'class_name' => 'DashboardController', 'model_name' => 'DashboardModel', 'slug' => 'dashboard', 'info' => NULL, 'status' => '1'),
            array('class_id' => '2', 'class_name' => 'BaseController', 'model_name' => 'BaseModel', 'slug' => 'base', 'info' => NULL, 'status' => '1'),
            array('class_id' => '3', 'class_name' => 'AdminController', 'model_name' => 'AdminModel', 'slug' => 'admin', 'info' => NULL, 'status' => '1'),
            array('class_id' => '4', 'class_name' => 'AdminroleController', 'model_name' => 'AdminroleModel', 'slug' => 'adminrole', 'info' => NULL, 'status' => '1'),
            array('class_id' => '5', 'class_name' => 'SettingsController', 'model_name' => 'SettingsModel', 'slug' => 'settings', 'info' => NULL, 'status' => '1'),
            array('class_id' => '6', 'class_name' => 'MediaController', 'model_name' => 'MediaModel', 'slug' => 'media', 'info' => NULL, 'status' => '1'),
            array('class_id' => '7', 'class_name' => 'PageController', 'model_name' => 'PageModel', 'slug' => 'page', 'info' => NULL, 'status' => '1'),
            array('class_id' => '11', 'class_name' => 'ContactController', 'model_name' => 'EnquiryModel', 'slug' => 'contact', 'info' => NULL, 'status' => '1'),

            array('class_id' => '13', 'class_name' => 'SubscribeduserController', 'model_name' => 'User', 'slug' => 'subscribeduser', 'info' => NULL, 'status' => '1'),
            array('class_id' => '14', 'class_name' => 'UserGroupController', 'model_name' => 'UserGroupModel', 'slug' => 'usergroup', 'info' => NULL, 'status' => '1'),
            array('class_id' => '15', 'class_name' => 'BannerController', 'model_name' => 'BannerModel', 'slug' => 'banner', 'info' => NULL, 'status' => '1'),
            array('class_id' => '18', 'class_name' => 'TestimonialController', 'model_name' => 'TestimonialModel', 'slug' => 'testimonial', 'info' => NULL, 'status' => '1'),
            array('class_id' => '36', 'class_name' => 'FAQController', 'model_name' => 'FAQModel', 'slug' => 'faq', 'info' => NULL, 'status' => '1'),
            array('class_id' => '37', 'class_name' => 'FAQCategoryController', 'model_name' => 'CommonCategory', 'slug' => 'faq-category', 'info' => NULL, 'status' => '1'),
            array('class_id' => '40', 'class_name' => 'TemplateController', 'model_name' => 'TemplateModel', 'slug' => 'template', 'info' => NULL, 'status' => '0'),
            array('class_id' => '44', 'class_name' => 'MenutypeController', 'model_name' => 'MenutypeModel', 'slug' => 'menutype', 'info' => NULL, 'status' => '0'),
            array('class_id' => '45', 'class_name' => 'MenuController', 'model_name' => 'MenuModel', 'slug' => 'menu', 'info' => NULL, 'status' => '1'),

            array('class_id' => '61', 'class_name' => 'CustomfieldController', 'model_name' => 'CustomfieldModel', 'slug' => 'customfield', 'info' => NULL, 'status' => '1'),

            array('class_id' => '62', 'class_name' => 'CurrencyMasterController', 'model_name' => 'CurrencyMaster', 'slug' => 'currency', 'info' => NULL, 'status' => '1'),
            array('class_id' => '63', 'class_name' => 'IndicesMasterController', 'model_name' => 'IndicesMaster', 'slug' => 'indices', 'info' => NULL, 'status' => '1'),

            array('class_id' => '64', 'class_name' => 'FundTypeController', 'model_name' => 'FundType', 'slug' => 'fundtype', 'info' => NULL, 'status' => '1'),
            array('class_id' => '65', 'class_name' => 'FundTermController', 'model_name' => 'FundTerm', 'slug' => 'fundterm', 'info' => NULL, 'status' => '1'),

            array('class_id' => '66', 'class_name' => 'FundMasterController', 'model_name' => 'FundMaster', 'slug' => 'fundmaster', 'info' => NULL, 'status' => '1'),

            array('class_id' => '67', 'class_name' => 'DailyCurrenciesValueController', 'model_name' => 'CurrencyDetail', 'slug' => 'currency-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '68', 'class_name' => 'DailyNavsValueController', 'model_name' => 'FundDetail', 'slug' => 'nav-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '69', 'class_name' => 'DailyIndicesValueController', 'model_name' => 'IndicesDetail', 'slug' => 'indices-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '70', 'class_name' => 'MonthlyAUMsValueController', 'model_name' => 'CorpusEntry', 'slug' => 'aums-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '71', 'class_name' => 'MonthlyMcapEpsValueController', 'model_name' => 'McapEps', 'slug' => 'mcap-eps-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '72', 'class_name' => 'MonthlyIndicesCompValueController', 'model_name' => 'IndicesComposition', 'slug' => 'indices-comp-values', 'info' => NULL, 'status' => '1'),
            array('class_id' => '73', 'class_name' => 'MonthlyFundCompValueController', 'model_name' => 'FundComposition', 'slug' => 'fund-comp-values', 'info' => NULL, 'status' => '1'),

            array('class_id' => '74', 'class_name' => 'NavsController', 'model_name' => 'FundDetail', 'slug' => 'nav-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '75', 'class_name' => 'IndicesController', 'model_name' => 'IndicesDetail', 'slug' => 'indices-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '76', 'class_name' => 'CurrenciesController', 'model_name' => 'CurrencyDetail', 'slug' => 'currencies-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '77', 'class_name' => 'AUMsController', 'model_name' => 'CorpusEntry', 'slug' => 'aums-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '78', 'class_name' => 'McapEpsController', 'model_name' => 'McapEps', 'slug' => 'mcap-eps-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '79', 'class_name' => 'IndicesCompController', 'model_name' => 'IndicesComposition', 'slug' => 'indices-comp-list', 'info' => NULL, 'status' => '1'),
            array('class_id' => '80', 'class_name' => 'FundCompController', 'model_name' => 'FundComposition', 'slug' => 'fund-comp-list', 'info' => NULL, 'status' => '1'),

            array('class_id' => '81', 'class_name' => 'NavsPublishController', 'model_name' => 'FundDetail', 'slug' => 'nav-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '82', 'class_name' => 'IndicesPublishController', 'model_name' => 'IndicesDetail', 'slug' => 'indices-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '83', 'class_name' => 'CurrenciesPublishController', 'model_name' => 'CurrencyDetail', 'slug' => 'currencies-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '84', 'class_name' => 'AUMsPublishController', 'model_name' => 'CorpusEntry', 'slug' => 'aums-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '85', 'class_name' => 'McapEpsPublishController', 'model_name' => 'McapEps', 'slug' => 'mcap-eps-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '86', 'class_name' => 'IndicesCompPublishController', 'model_name' => 'IndicesComposition', 'slug' => 'indices-comp-publish', 'info' => NULL, 'status' => '1'),
            array('class_id' => '87', 'class_name' => 'FundCompPublishController', 'model_name' => 'FundComposition', 'slug' => 'fund-comp-publish', 'info' => NULL, 'status' => '1'),

            array('class_id' => '88', 'class_name' => 'ScripsController', 'model_name' => 'Scrips', 'slug' => 'scrips', 'info' => NULL, 'status' => '1'),

            array('class_id' => '89', 'class_name' => 'FundWatchController', 'model_name' => 'FundWatch', 'slug' => 'fund-watch', 'info' => NULL, 'status' => '1'),

            array('class_id' => '90', 'class_name' => 'FundDictionaryController', 'model_name' => 'FundDictionary', 'slug' => 'fund-dictionary', 'info' => NULL, 'status' => '1'),

            array('class_id' => '91', 'class_name' => 'FundClassificationController', 'model_name' => 'FundClassification', 'slug' => 'fund-classification', 'info' => NULL, 'status' => '1'),

            array('class_id' => '92', 'class_name' => 'FundTaxationController', 'model_name' => 'FundTaxation', 'slug' => 'fund-taxation', 'info' => NULL, 'status' => '1'),

            array('class_id' => '93', 'class_name' => 'MissingNavController', 'model_name' => 'FundDetail', 'slug' => 'missing-nav', 'info' => NULL, 'status' => '1'),

            array('class_id' => '94', 'class_name' => 'FundManController', 'model_name' => 'FundMan', 'slug' => 'fund-man', 'info' => NULL, 'status' => '1'),

            array('class_id' => '95', 'class_name' => 'NewsController', 'model_name' => 'News', 'slug' => 'news', 'info' => NULL, 'status' => '1'),

            array('class_id' => '96', 'class_name' => 'PlanController', 'model_name' => 'Plans', 'slug' => 'plan', 'info' => NULL, 'status' => '1'),

            array('class_id' => '97', 'class_name' => 'NewsletterController', 'model_name' => 'Newsletter', 'slug' => 'newsletter', 'info' => NULL, 'status' => '1'),

            array('class_id' => '98', 'class_name' => 'TeamsController', 'model_name' => 'Team', 'slug' => 'team', 'info' => NULL, 'status' => '1'),
            array('class_id' => '99', 'class_name' => 'KnowTheRatioController', 'model_name' => 'KnowTheRatio', 'slug' => 'know-the-ratio', 'info' => NULL, 'status' => '1'),
            array('class_id' => '100', 'class_name' => 'FundSuggestionController', 'model_name' => 'FundSuggestion', 'slug' => 'fund-suggestion', 'info' => NULL, 'status' => '1'),

            array('class_id' => '101', 'class_name' => 'AskExpertQuestionController', 'model_name' => 'AskExpertQuestion', 'slug' => 'question', 'info' => NULL, 'status' => '1'),
            array('class_id' => '102', 'class_name' => 'AskExpertTopicController', 'model_name' => 'AskExpertTopic', 'slug' => 'topic', 'info' => NULL, 'status' => '1'),
            array('class_id' => '103', 'class_name' => 'AskExpertQuestionAnswerController', 'model_name' => 'AskExpertQuestionAnswer', 'slug' => 'answer', 'info' => NULL, 'status' => '1'),

            array('class_id' => '104', 'class_name' => 'NfoMonitorController', 'model_name' => 'NfoOffer', 'slug' => 'nfo-monitor', 'info' => NULL, 'status' => '1'),

            array('class_id' => '105', 'class_name' => 'MissingIndicesController', 'model_name' => 'IndicesDetail', 'slug' => 'missing-indices', 'info' => NULL, 'status' => '1'),
            array('class_id' => '106', 'class_name' => 'MissingCurrencyController', 'model_name' => 'CurrencyDetail', 'slug' => 'missing-currency', 'info' => NULL, 'status' => '1')
        );

        DB::table('module_class')->insert($dataArr);
        $this->command->info('module class table seeded!');
    }
}
