<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassSchedule;
use Carbon\Carbon;
use App\RegForm;
use App\Division;
use App\User;
use App\Room;

class PagesController extends Controller
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
            $pendingforms = RegForm::where('isApproved', 0)->orderBy('created_at', 'asc')->get();
            $upcomingReservations = RegForm::where('isApproved', 1)
                                            ->where('isCancelled', 0)
                                            ->where('stime_res', '>=', Carbon::now())
                                            ->where('stime_res', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'))
                                            ->where('etime_res', '<', Carbon::now())
                                            ->orderBy('stime_res', 'asc')
                                            ->get();
            $formStats = Self::getFormStats();
            $userStats = Self::getUserTrafficStats();

            return view('pages.requests')->with('pendingforms', $pendingforms)
                                         ->with('upcomingReservations', $upcomingReservations)
                                         ->with('formStats', $formStats)
                                         ->with('userStats', $userStats);
        } elseif ($role == 1){
            $studentReservations = RegForm::where('user_id', Auth()->user()->user_id)->get();
            $upcomingReservations = RegForm::where('user_id', Auth()->user()->user_id)
                                            ->where('isApproved', 1)
                                            ->where('isCancelled', 0)
                                            ->whereDate('stime_res', '>=', Carbon::now())
                                            ->whereDate('stime_res', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'))
                                            ->orderBy('stime_res', 'asc')
                                            ->get();
            $pendingCount = RegForm::where('user_id', Auth()->user()->user_id)
                                    ->where('isApproved', 0)
                                    ->where('isCancelled', 0)
                                    ->count();
            $approvedCount = RegForm::where('user_id', Auth()->user()->user_id)
                                    ->where('isApproved', 1)
                                    ->count();
            $cancelledCount = RegForm::where('user_id', Auth()->user()->user_id)
                                    ->where('isCancelled', 1)
                                    ->count();

            return view('pages.history')->with('studentReservations', $studentReservations)
                                        ->with('upcomingReservations', $upcomingReservations)
                                        ->with('pendingCount', $pendingCount)
                                        ->with('approvedCount', $approvedCount)
                                        ->with('cancelledCount', $cancelledCount);
        } else {
            $forms = RegForm::where('isApproved', '1')->get();
            $rooms = Room::orderByRaw('LENGTH(room_desc)', 'asc')
                    ->orderBy('room_desc', 'asc')
                    ->get();
            $classSchedules = ClassSchedule::get();
            $users = User::get(); //User::where('isActive', true)->get();
            return view('pages.reservation')->with('classSchedules', $classSchedules)
                                            ->with('forms', $forms)
                                            ->with('rooms', $rooms)
                                            ->with('users', $users);
        }
    }

    /**
    * Calculates the percentage change between an old and new value
    * 
    * @param oldNumber The initial value
    * @param newNumber The value that changed
    */
    private function getPercentageChange($oldNumber, $newNumber){
        return ($oldNumber == 0) ? 0 : (int)(($oldNumber - $newNumber) / $oldNumber) * 100;
    }

    private function getUserTrafficStats() {
        //0=staff, 1=faculty, 2=college, 3=SHS
        $userTypes = Division::pluck('division_name')->toArray();
        $userTrafficStats = [];

        for ($userType = 2; $userType <= 4; $userType++) {
            for ($month = 3; $month >= 0; $month--) {
                $week1 = RegForm::whereHas('user', function($q) use($userType) {
                                    $q->where('user_type', $userType);
                                })
                                ->whereDate('created_at', '>=', Carbon::now()->subMonths($month)->firstOfMonth()->format('Y-m-d'))
                                ->whereDate('created_at', '<', Carbon::now()->subMonths($month)->firstOfMonth()->addWeek()->format('Y-m-d'))
                                ->whereMonth('created_at', Carbon::now()->subMonths($month)->firstOfMonth()->month)
                                ->count();

                $week2 = RegForm::whereHas('user', function($q) use($userType) {
                                    $q->where('user_type', $userType);
                                })
                                ->whereDate('created_at', '>=', Carbon::now()->subMonths($month)->firstOfMonth()->addWeek()->format('Y-m-d'))
                                ->whereDate('created_at', '<', Carbon::now()->subMonths($month)->firstOfMonth()->addWeeks(2)->format('Y-m-d'))
                                ->whereMonth('created_at', Carbon::now()->subMonths($month)->firstOfMonth()->month)
                                ->count();
                
                $week3 = RegForm::whereHas('user', function($q) use($userType) {
                                    $q->where('user_type', $userType);
                                })
                                ->whereDate('created_at', '>', Carbon::now()->subMonths($month)->firstOfMonth()->addWeeks(2)->format('Y-m-d'))
                                ->whereDate('created_at', '<', Carbon::now()->subMonths($month)->firstOfMonth()->addWeeks(3)->format('Y-m-d'))
                                ->whereMonth('created_at', Carbon::now()->subMonths($month)->firstOfMonth()->month)
                                ->count();

                $week4 = RegForm::whereHas('user', function($q) use($userType) {
                                    $q->where('user_type', $userType);
                                })
                                ->whereDate('created_at', '>=', Carbon::now()->subMonths($month)->firstOfMonth()->addWeeks(3)->format('Y-m-d'))
                                ->whereDate('created_at', '<', Carbon::now()->subMonths($month)->firstOfMonth()->addWeeks(5)->format('Y-m-d'))
                                ->whereMonth('created_at', Carbon::now()->subMonths($month)->firstOfMonth()->month)
                                ->count();
                $userTrafficStats[$userTypes[$userType-1]][Carbon::now()->subMonths($month)->firstOfMonth()->shortLocaleMonth] = [$week1, $week2, $week3, $week4];
            }
        }

        return $userTrafficStats;
    }

    private function getFormStats() {
        $receivedCountAll = RegForm::count();
        $approvedCountAll = RegForm::where('isApproved', 1)
                                    ->count();
        $rejectedCountAll = RegForm::where('user_id', '!=', 'admin')
                                    ->where('isApproved', 2)
                                    ->count();
        $cancelledCountAll = RegForm::where('isCancelled', 1)
                                    ->count();
        $receivedCountNow = RegForm::whereDate('created_at', '>=', Carbon::now()->subMonth())
                                    ->count();
        $approvedCountNow = RegForm::where('isApproved', 1)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonth())
                                    ->count();
        $rejectedCountNow = RegForm::where('user_id', '!=', 'admin')
                                    ->where('isApproved', 2)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonth())
                                    ->count();
        $cancelledCountNow = RegForm::where('isCancelled', 1)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonth())
                                    ->count();
        $receivedCountFormer = RegForm::whereDate('created_at', '>=', Carbon::now()->subMonths(2))
                                    ->whereDate('created_at', '<', Carbon::now()->subMonth())
                                    ->count();
        $approvedCountFormer = RegForm::where('isApproved', 1)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
                                    ->whereDate('created_at', '<', Carbon::now()->subMonth())
                                    ->count();
        $rejectedCountFormer = RegForm::where('user_id', '!=', 'admin')
                                    ->where('isApproved', 2)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
                                    ->whereDate('created_at', '<', Carbon::now()->subMonth())
                                    ->count();
        $cancelledCountFormer = RegForm::where('isCancelled', 1)
                                    ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
                                    ->whereDate('created_at', '<', Carbon::now()->subMonth())
                                    ->count();
        
        $formStats = [
            'received' => [$receivedCountAll, Self::getPercentageChange($receivedCountFormer, $receivedCountNow)],
            'confirmed' => [$approvedCountAll, Self::getPercentageChange($approvedCountFormer, $approvedCountNow)],
            'rejected' => [$rejectedCountAll, Self::getPercentageChange($rejectedCountFormer, $rejectedCountNow)],
            'cancelled' => [$cancelledCountAll, Self::getPercentageChange($cancelledCountFormer, $cancelledCountNow)],
        ];

        return $formStats;
    }
}