<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('Dashboard');
        $role = Auth::role();
    
        if ($role == '0'){
            return view('pages.reservation');
        } elseif ($role == '1'){
            return 'dashboards.user_dash';
        } else {
            return 'dashboards.security_dash';
        }
    }
}
