<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
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

    DB::table('modules')->truncate();

    $dataArr = array(
      array('module_id' => '1', 'class_id' => '1', 'has_templates' => '', 'title' => 'Dashboard', 'label' => 'Dashboard', 'info' => NULL, 'class_name' => 'DashboardController', 'is_menu' => '1', 'c_order' => '1', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '2', 'class_id' => '2', 'has_templates' => '', 'title' => 'Common', 'label' => 'Common', 'info' => NULL, 'class_name' => 'BaseController', 'is_menu' => '0', 'c_order' => '0', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '3', 'class_id' => '3', 'has_templates' => '', 'title' => 'Admin Users', 'label' => 'Admin Users', 'info' => NULL, 'class_name' => 'AdminController', 'is_menu' => '1', 'c_order' => '20', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '4', 'class_id' => '4', 'has_templates' => '', 'title' => 'Admin Users Roles', 'label' => 'Roles', 'info' => NULL, 'class_name' => 'AdminroleController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '3', 'status' => '1'),
      array('module_id' => '5', 'class_id' => '5', 'has_templates' => '', 'title' => 'Settings', 'label' => 'Settings', 'info' => NULL, 'class_name' => 'SettingsController', 'is_menu' => '1', 'c_order' => '19', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '6', 'class_id' => '6', 'has_templates' => '', 'title' => 'Media', 'label' => 'Media', 'info' => NULL, 'class_name' => 'MediaController', 'is_menu' => '1', 'c_order' => '16', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '7', 'class_id' => '7', 'has_templates' => 'y', 'title' => 'Pages', 'label' => 'Pages', 'info' => NULL, 'class_name' => 'PageController', 'is_menu' => '1', 'c_order' => '15', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '11', 'class_id' => '11', 'has_templates' => '', 'title' => 'Contact Enquiry', 'label' => 'Contact Enquiry', 'info' => NULL, 'class_name' => 'ContactController', 'is_menu' => '1', 'c_order' => '2', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '13', 'class_id' => '13', 'has_templates' => '', 'title' => 'Subscribed Users', 'label' => 'Subscribed Users', 'info' => NULL, 'class_name' => 'SubscribeduserController', 'is_menu' => '1', 'c_order' => '5', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '14', 'class_id' => '14', 'has_templates' => '', 'title' => 'Subscribed Users Group', 'label' => 'All User Group', 'info' => NULL, 'class_name' => 'UserGroupController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '13', 'status' => '1'),
      array('module_id' => '15', 'class_id' => '15', 'has_templates' => '', 'title' => 'Banner', 'label' => 'Banner', 'info' => NULL, 'class_name' => 'BannerController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),
      array('module_id' => '18', 'class_id' => '18', 'has_templates' => '', 'title' => 'Testimonials', 'label' => 'Testimonials', 'info' => NULL, 'class_name' => 'TestimonialController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),
      array('module_id' => '36', 'class_id' => '36', 'has_templates' => '', 'title' => 'FAQ', 'label' => 'FAQ', 'info' => NULL, 'class_name' => 'FAQController', 'is_menu' => '1', 'c_order' => '17', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '37', 'class_id' => '37', 'has_templates' => '', 'title' => 'FAQ Category', 'label' => 'FAQ Category', 'info' => NULL, 'class_name' => 'FAQCategoryController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '36', 'status' => '1'),
      array('module_id' => '40', 'class_id' => '40', 'has_templates' => '', 'title' => 'Templates', 'label' => 'Templates', 'info' => NULL, 'class_name' => 'TemplateController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),
      array('module_id' => '44', 'class_id' => '44', 'has_templates' => '', 'title' => 'Website Menu Type', 'label' => 'Website Menu Type', 'info' => "Hidden module", 'class_name' => 'MenutypeController', 'is_menu' => '0', 'c_order' => '0', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '45', 'class_id' => '45', 'has_templates' => '', 'title' => 'Website Menus', 'label' => 'Website Menus', 'info' => NULL, 'class_name' => 'MenuController', 'is_menu' => '1', 'c_order' => '14', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '63', 'class_id' => '61', 'has_templates' => '', 'title' => 'Custom Fields', 'label' => 'Custom Fields', 'info' => NULL, 'class_name' => 'CustomfieldController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '64', 'class_id' => '62', 'has_templates' => '', 'title' => 'Currency', 'label' => 'Currency', 'info' => NULL, 'class_name' => 'CurrencyMasterController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),
      array('module_id' => '65', 'class_id' => '63', 'has_templates' => '', 'title' => 'Indices', 'label' => 'Indices', 'info' => NULL, 'class_name' => 'IndicesMasterController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),

      array('module_id' => '66', 'class_id' => '64', 'has_templates' => '', 'title' => 'Fund Type', 'label' => 'System', 'info' => NULL, 'class_name' => 'FundTypeController', 'is_menu' => '1', 'c_order' => '18', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '67', 'class_id' => '65', 'has_templates' => '', 'title' => 'Fund Term', 'label' => 'Fund Term', 'info' => NULL, 'class_name' => 'FundTermController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '68', 'class_id' => '66', 'has_templates' => '', 'title' => 'Fund Master', 'label' => 'Masters', 'info' => NULL, 'class_name' => 'FundMasterController', 'is_menu' => '1', 'c_order' => '8', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '69', 'class_id' => '67', 'has_templates' => '', 'title' => 'Upload Daily Currencies Value', 'label' => 'Daily Currencies', 'info' => NULL, 'class_name' => 'DailyCurrenciesValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),
      array('module_id' => '70', 'class_id' => '68', 'has_templates' => '', 'title' => 'Upload Daily NAVs Value', 'label' => 'Upload Values', 'info' => NULL, 'class_name' => 'DailyNavsValueController', 'is_menu' => '1', 'c_order' => '9', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '71', 'class_id' => '69', 'has_templates' => '', 'title' => 'Upload Daily Indices Value', 'label' => 'Daily Indices', 'info' => NULL, 'class_name' => 'DailyIndicesValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),
      array('module_id' => '72', 'class_id' => '70', 'has_templates' => '', 'title' => 'Upload Monthly AUMs Value', 'label' => 'Monthly AUMs', 'info' => NULL, 'class_name' => 'MonthlyAUMsValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),
      array('module_id' => '73', 'class_id' => '71', 'has_templates' => '', 'title' => 'Upload Monthly MCAP EPS Value', 'label' => 'Monthly MCAP EPS', 'info' => NULL, 'class_name' => 'MonthlyMcapEpsValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),
      array('module_id' => '74', 'class_id' => '72', 'has_templates' => '', 'title' => 'Upload Monthly Indices Comp Value', 'label' => 'Monthly Indices Comp', 'info' => NULL, 'class_name' => 'MonthlyIndicesCompValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),
      array('module_id' => '75', 'class_id' => '73', 'has_templates' => '', 'title' => 'Upload Monthly Fund Comp Value', 'label' => 'Monthly Fund Comp', 'info' => NULL, 'class_name' => 'MonthlyFundCompValueController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '70', 'status' => '1'),

      array('module_id' => '76', 'class_id' => '74', 'has_templates' => '', 'title' => 'Manage Daily NAVs Value', 'label' => 'Uploaded Data List', 'info' => NULL, 'class_name' => 'NavsController', 'is_menu' => '1', 'c_order' => '10', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '77', 'class_id' => '75', 'has_templates' => '', 'title' => 'Manage Daily Indices Value', 'label' => 'Daily Indices', 'info' => NULL, 'class_name' => 'IndicesController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),
      array('module_id' => '78', 'class_id' => '76', 'has_templates' => '', 'title' => 'Manage Daily Currencies Value', 'label' => 'Daily Currencies', 'info' => NULL, 'class_name' => 'CurrenciesController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),
      array('module_id' => '79', 'class_id' => '77', 'has_templates' => '', 'title' => 'Manage Monthly AUMs Value', 'label' => 'Monthly AUMs', 'info' => NULL, 'class_name' => 'AUMsController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),
      array('module_id' => '80', 'class_id' => '78', 'has_templates' => '', 'title' => 'Manage Monthly MCAP EPS Value', 'label' => 'Monthly MCAP EPS', 'info' => NULL, 'class_name' => 'McapEpsController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),
      array('module_id' => '81', 'class_id' => '79', 'has_templates' => '', 'title' => 'Manage Monthly Indices Comp Value', 'label' => 'Monthly Indices Comp', 'info' => NULL, 'class_name' => 'IndicesCompController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),
      array('module_id' => '82', 'class_id' => '80', 'has_templates' => '', 'title' => 'Manage Monthly Fund Comp Value', 'label' => 'Monthly Fund Comp', 'info' => NULL, 'class_name' => 'FundCompController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '76', 'status' => '1'),

      array('module_id' => '83', 'class_id' => '81', 'has_templates' => '', 'title' => 'Publish Daily NAVs Value', 'label' => 'Publish Data', 'info' => NULL, 'class_name' => 'NavsPublishController', 'is_menu' => '1', 'c_order' => '11', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '84', 'class_id' => '82', 'has_templates' => '', 'title' => 'Publish Daily Indices Value', 'label' => 'Daily Indices', 'info' => NULL, 'class_name' => 'IndicesPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),
      array('module_id' => '85', 'class_id' => '83', 'has_templates' => '', 'title' => 'Publish Daily Currencies Value', 'label' => 'Daily Currencies', 'info' => NULL, 'class_name' => 'CurrenciesPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),
      array('module_id' => '86', 'class_id' => '84', 'has_templates' => '', 'title' => 'Publish Monthly AUMs Value', 'label' => 'Monthly AUMs', 'info' => NULL, 'class_name' => 'AUMsPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),
      array('module_id' => '87', 'class_id' => '85', 'has_templates' => '', 'title' => 'Publish Monthly MCAP EPS Value', 'label' => 'Monthly MCAP EPS', 'info' => NULL, 'class_name' => 'McapEpsPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),
      array('module_id' => '88', 'class_id' => '86', 'has_templates' => '', 'title' => 'Publish Monthly Indices Comp Value', 'label' => 'Monthly Indices Comp', 'info' => NULL, 'class_name' => 'IndicesCompPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),
      array('module_id' => '89', 'class_id' => '87', 'has_templates' => '', 'title' => 'Publish Monthly Fund Comp Value', 'label' => 'Monthly Fund Comp', 'info' => NULL, 'class_name' => 'FundCompPublishController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '83', 'status' => '1'),

      array('module_id' => '90', 'class_id' => '88', 'has_templates' => '', 'title' => 'Manage Scrips', 'label' => 'Scrips ', 'info' => NULL, 'class_name' => 'ScripsController', 'is_menu' => '0', 'c_order' => '0', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '91', 'class_id' => '89', 'has_templates' => '', 'title' => 'Fund Watch', 'label' => 'Fund Watch', 'info' => NULL, 'class_name' => 'FundWatchController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),

      array('module_id' => '92', 'class_id' => '90', 'has_templates' => '', 'title' => 'Fund Dictionary', 'label' => 'Fund Dictionary', 'info' => NULL, 'class_name' => 'FundDictionaryController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),

      array('module_id' => '93', 'class_id' => '91', 'has_templates' => '', 'title' => 'Fund Classification', 'label' => 'Fund Classification', 'info' => NULL, 'class_name' => 'FundClassificationController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),

      array('module_id' => '94', 'class_id' => '92', 'has_templates' => '', 'title' => 'Fund Taxation', 'label' => 'Fund Taxation', 'info' => NULL, 'class_name' => 'FundTaxationController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '68', 'status' => '1'),

      array('module_id' => '95', 'class_id' => '93', 'has_templates' => '', 'title' => 'Missing NAV', 'label' => 'Data Consolidation', 'info' => NULL, 'class_name' => 'MissingNavController', 'is_menu' => '1', 'c_order' => '12', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '96', 'class_id' => '94', 'has_templates' => '', 'title' => 'Fund Man', 'label' => 'Fund Man', 'info' => NULL, 'class_name' => 'FundManController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '97', 'class_id' => '95', 'has_templates' => '', 'title' => 'News', 'label' => 'News', 'info' => NULL, 'class_name' => 'NewsController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '98', 'class_id' => '96', 'has_templates' => '', 'title' => 'Plans', 'label' => 'Plans', 'info' => NULL, 'class_name' => 'PlanController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '99', 'class_id' => '97', 'has_templates' => '', 'title' => 'Newsletter Data', 'label' => 'Newsletter Data', 'info' => NULL, 'class_name' => 'NewsletterController', 'is_menu' => '1', 'c_order' => '3', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '100', 'class_id' => '98', 'has_templates' => '', 'title' => 'Teams', 'label' => 'Teams', 'info' => "", 'class_name' => 'TeamsController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),
      array('module_id' => '101', 'class_id' => '99', 'has_templates' => '', 'title' => 'Know The Ratio', 'label' => 'Know The Ratio', 'info' => "", 'class_name' => 'KnowTheRatioController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),
      array('module_id' => '102', 'class_id' => '100', 'has_templates' => '', 'title' => 'Fund Suggestion', 'label' => 'Fund Suggestion', 'info' => "", 'class_name' => 'FundSuggestionController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '103', 'class_id' => '101', 'has_templates' => '', 'title' => 'Ask Expert', 'label' => 'Ask Expert', 'info' => NULL, 'class_name' => 'AskExpertQuestionController', 'is_menu' => '1', 'c_order' => '4', 'parent_module_id' => '0', 'status' => '1'),
      array('module_id' => '104', 'class_id' => '102', 'has_templates' => '', 'title' => 'Ask Expert Topics', 'label' => 'All Topics', 'info' => NULL, 'class_name' => 'AskExpertTopicController', 'is_menu' => '1', 'c_order' => '1', 'parent_module_id' => '103', 'status' => '1'),
      array('module_id' => '105', 'class_id' => '103', 'has_templates' => '', 'title' => 'Ask Expert Answer', 'label' => 'Ask Expert Answer', 'info' => NULL, 'class_name' => 'AskExpertQuestionAnswerController', 'is_menu' => '0', 'c_order' => '0', 'parent_module_id' => '0', 'status' => '1'),

      array('module_id' => '106', 'class_id' => '104', 'has_templates' => '', 'title' => 'NFO Monitor', 'label' => 'NFO Monitor', 'info' => NULL, 'class_name' => 'NfoMonitorController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '66', 'status' => '1'),

      array('module_id' => '107', 'class_id' => '105', 'has_templates' => '', 'title' => 'Missing Indices', 'label' => 'Missing Indices', 'info' => NULL, 'class_name' => 'MissingIndicesController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '95', 'status' => '1'),
      array('module_id' => '108', 'class_id' => '106', 'has_templates' => '', 'title' => 'Missing Currency', 'label' => 'Missing Currency', 'info' => NULL, 'class_name' => 'MissingCurrencyController', 'is_menu' => '1', 'c_order' => '0', 'parent_module_id' => '95', 'status' => '1')
    );

    DB::table('modules')->insert($dataArr);
    $this->command->info('modules table seeded!');
  }
}
