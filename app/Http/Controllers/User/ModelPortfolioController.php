<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ModelPortfolioController extends Controller
{
    public function index()
    {
        $data = RatioController::loggedInUserData();
        $data['browser_title'] = 'Model Portfolio';
        $data['active_menu'] = 'model_portfolio';

        return view('web.model_portfolio.index', $data);
    }
}
