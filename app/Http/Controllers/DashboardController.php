<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        $role = auth()->user()->roles;
    
        if ($role == 0){
            return view('pages.requests')->with($role);
        } elseif ($role == 1){
            return view('pages.history')->with($role);
        } else {
            return view('pages.securityoverview')->with($role);
        }
    }
}
