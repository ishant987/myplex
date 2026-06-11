<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController as BaseController;
use Illuminate\Http\Request;

class MfTaxationController extends BaseController
{
    
    
    public function index(){
        return view($this->page_path.'.mf-taxation');
    }
    public function pentatech(){
        return view($this->page_path.'.pentatech');
    }
}
