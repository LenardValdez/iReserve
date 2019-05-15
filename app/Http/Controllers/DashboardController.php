<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegForm;
use App\User;
use App\Room;

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
            $pendingforms = RegForm::where('isApproved', 0)->get();
            $users = User::get();
            return view('pages.requests')->with("pendingforms", $pendingforms)
                                         ->with("users", $users);
        } elseif ($role == 1){
            return view('pages.history');
        } else {
            $forms = RegForm::where('isApproved', '1')->get();
            $rooms = Room::get();
            $users = User::where('isActive', true)->get();
            return view('pages.reservation')->with("forms", $forms)
                                            ->with("rooms", $rooms)
                                            ->with("users", $users);
        }
    }
}
