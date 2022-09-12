<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class RoleModuleMethodRightsSeeder extends Seeder
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

    DB::table('role_module_method_rights')->truncate();

    $dataArr = array(
      array('role_id' => '1', 'module_id' => '1', 'method_id' => '1', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '2', 'method_id' => '2', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '3', 'method_id' => '3', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '4', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '5', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '6', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '7', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '8', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '9', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '3', 'method_id' => '10', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '4', 'method_id' => '11', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '4', 'method_id' => '12', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '4', 'method_id' => '13', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '4', 'method_id' => '14', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '4', 'method_id' => '15', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '4', 'method_id' => '16', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '5', 'method_id' => '17', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '18', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '19', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '20', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '21', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '22', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '23', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '6', 'method_id' => '24', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '25', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '26', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '27', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '28', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '29', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '30', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '31', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '32', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '33', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '6', 'method_id' => '34', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '7', 'method_id' => '35', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '7', 'method_id' => '36', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '7', 'method_id' => '37', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '7', 'method_id' => '38', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '7', 'method_id' => '39', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '7', 'method_id' => '40', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '11', 'method_id' => '57', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '11', 'method_id' => '58', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '11', 'method_id' => '59', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '13', 'method_id' => '64', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '65', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '66', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '67', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '68', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '69', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '70', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '71', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '13', 'method_id' => '72', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '14', 'method_id' => '73', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '14', 'method_id' => '74', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '14', 'method_id' => '75', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '14', 'method_id' => '76', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '14', 'method_id' => '77', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '14', 'method_id' => '78', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '15', 'method_id' => '79', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '15', 'method_id' => '80', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '15', 'method_id' => '81', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '15', 'method_id' => '82', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '15', 'method_id' => '83', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '15', 'method_id' => '84', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '18', 'method_id' => '97', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '18', 'method_id' => '98', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '18', 'method_id' => '99', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '18', 'method_id' => '100', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '18', 'method_id' => '101', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '18', 'method_id' => '102', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '36', 'method_id' => '193', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '36', 'method_id' => '194', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '36', 'method_id' => '195', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '36', 'method_id' => '196', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '36', 'method_id' => '197', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '36', 'method_id' => '198', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '37', 'method_id' => '199', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '37', 'method_id' => '200', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '37', 'method_id' => '201', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '37', 'method_id' => '202', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '37', 'method_id' => '203', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '37', 'method_id' => '204', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '40', 'method_id' => '217', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '40', 'method_id' => '218', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '40', 'method_id' => '219', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '40', 'method_id' => '220', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '40', 'method_id' => '221', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '40', 'method_id' => '222', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '44', 'method_id' => '241', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '44', 'method_id' => '242', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '44', 'method_id' => '243', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '44', 'method_id' => '244', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '44', 'method_id' => '245', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '44', 'method_id' => '246', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '45', 'method_id' => '247', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '45', 'method_id' => '248', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '45', 'method_id' => '249', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '45', 'method_id' => '250', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '45', 'method_id' => '251', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '45', 'method_id' => '252', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '5', 'method_id' => '253', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '254', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '5', 'method_id' => '271', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '5', 'method_id' => '272', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '63', 'method_id' => '351', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '352', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '353', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '354', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '355', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '356', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '63', 'method_id' => '357', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '64', 'method_id' => '358', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '64', 'method_id' => '359', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '64', 'method_id' => '360', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '64', 'method_id' => '361', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '64', 'method_id' => '362', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '64', 'method_id' => '363', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '65', 'method_id' => '364', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '365', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '366', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '367', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '368', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '369', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '65', 'method_id' => '370', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '66', 'method_id' => '371', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '66', 'method_id' => '372', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '66', 'method_id' => '373', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '66', 'method_id' => '374', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '66', 'method_id' => '375', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '66', 'method_id' => '376', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '67', 'method_id' => '377', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '67', 'method_id' => '378', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '67', 'method_id' => '379', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '67', 'method_id' => '380', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '67', 'method_id' => '381', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '67', 'method_id' => '382', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '68', 'method_id' => '383', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '384', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '385', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '386', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '387', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '388', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '389', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '390', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '68', 'method_id' => '391', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '69', 'method_id' => '392', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '69', 'method_id' => '393', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '70', 'method_id' => '394', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '70', 'method_id' => '395', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '70', 'method_id' => '396', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '70', 'method_id' => '397', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '71', 'method_id' => '398', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '71', 'method_id' => '399', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '71', 'method_id' => '400', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '71', 'method_id' => '401', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '72', 'method_id' => '402', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '72', 'method_id' => '403', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '72', 'method_id' => '404', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '72', 'method_id' => '405', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '73', 'method_id' => '406', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '73', 'method_id' => '407', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '74', 'method_id' => '408', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '74', 'method_id' => '409', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '75', 'method_id' => '410', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '75', 'method_id' => '411', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '76', 'method_id' => '412', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '76', 'method_id' => '413', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '77', 'method_id' => '414', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '77', 'method_id' => '415', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '78', 'method_id' => '416', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '78', 'method_id' => '417', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '79', 'method_id' => '418', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '79', 'method_id' => '419', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '80', 'method_id' => '420', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '80', 'method_id' => '421', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '81', 'method_id' => '422', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '81', 'method_id' => '423', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '82', 'method_id' => '424', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '82', 'method_id' => '425', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '83', 'method_id' => '426', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '83', 'method_id' => '427', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '84', 'method_id' => '428', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '84', 'method_id' => '429', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '85', 'method_id' => '430', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '85', 'method_id' => '431', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '86', 'method_id' => '432', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '86', 'method_id' => '433', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '87', 'method_id' => '434', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '87', 'method_id' => '435', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '88', 'method_id' => '436', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '88', 'method_id' => '437', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '89', 'method_id' => '438', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '89', 'method_id' => '439', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '90', 'method_id' => '440', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '441', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '442', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '443', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '444', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '445', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '446', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '90', 'method_id' => '447', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '91', 'method_id' => '448', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '91', 'method_id' => '449', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '91', 'method_id' => '450', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '91', 'method_id' => '451', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '91', 'method_id' => '452', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '91', 'method_id' => '453', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '92', 'method_id' => '454', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '92', 'method_id' => '455', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '92', 'method_id' => '456', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '92', 'method_id' => '457', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '92', 'method_id' => '458', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '92', 'method_id' => '459', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '93', 'method_id' => '460', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '93', 'method_id' => '461', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '93', 'method_id' => '462', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '93', 'method_id' => '463', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '93', 'method_id' => '464', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '93', 'method_id' => '465', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '94', 'method_id' => '466', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '94', 'method_id' => '467', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '94', 'method_id' => '468', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '94', 'method_id' => '469', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '94', 'method_id' => '470', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '94', 'method_id' => '471', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '95', 'method_id' => '472', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '95', 'method_id' => '473', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '95', 'method_id' => '474', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '96', 'method_id' => '475', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '96', 'method_id' => '476', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '96', 'method_id' => '477', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '96', 'method_id' => '478', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '96', 'method_id' => '479', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '96', 'method_id' => '480', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '97', 'method_id' => '481', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '97', 'method_id' => '482', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '97', 'method_id' => '483', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '97', 'method_id' => '484', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '97', 'method_id' => '485', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '97', 'method_id' => '486', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '98', 'method_id' => '487', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '98', 'method_id' => '488', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '98', 'method_id' => '489', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '98', 'method_id' => '490', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '98', 'method_id' => '491', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '98', 'method_id' => '492', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '99', 'method_id' => '493', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '99', 'method_id' => '494', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '100', 'method_id' => '495', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '100', 'method_id' => '496', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '100', 'method_id' => '497', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '100', 'method_id' => '498', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '100', 'method_id' => '499', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '100', 'method_id' => '500', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '101', 'method_id' => '501', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '101', 'method_id' => '502', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '101', 'method_id' => '503', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '101', 'method_id' => '504', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '101', 'method_id' => '505', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '101', 'method_id' => '506', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '102', 'method_id' => '507', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '102', 'method_id' => '508', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '102', 'method_id' => '509', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '102', 'method_id' => '510', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '102', 'method_id' => '511', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '102', 'method_id' => '512', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '103', 'method_id' => '513', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '103', 'method_id' => '514', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '103', 'method_id' => '515', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '103', 'method_id' => '516', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '104', 'method_id' => '517', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '104', 'method_id' => '518', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '104', 'method_id' => '519', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '104', 'method_id' => '520', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '104', 'method_id' => '521', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '104', 'method_id' => '522', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '105', 'method_id' => '523', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '105', 'method_id' => '524', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '105', 'method_id' => '525', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '105', 'method_id' => '526', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '106', 'method_id' => '527', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '106', 'method_id' => '528', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '106', 'method_id' => '529', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '106', 'method_id' => '530', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '106', 'method_id' => '531', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '106', 'method_id' => '532', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '107', 'method_id' => '533', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '107', 'method_id' => '534', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '107', 'method_id' => '535', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),

      array('role_id' => '1', 'module_id' => '108', 'method_id' => '536', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '108', 'method_id' => '537', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL),
      array('role_id' => '1', 'module_id' => '108', 'method_id' => '538', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => NULL)
    );

    DB::table('role_module_method_rights')->insert($dataArr);
    $this->command->info('Role module methods rights table seeded!');
  }
}
