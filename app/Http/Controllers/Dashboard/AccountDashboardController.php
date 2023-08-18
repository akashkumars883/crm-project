<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountDashboardController extends Controller
{
    public function index()
    {
        return view('crm.dashboards.accounts');
    }
}
