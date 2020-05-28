<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\ClassSchedule;
use Carbon\Carbon;
use App\RegForm;
use App\Division;
use App\User;
use App\Room;

class PageController extends Controller
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
            $pendingforms = RegForm::where('isApproved', 0)
                                    ->where('isCancelled', 0)
                                    ->orderBy('created_at', 'asc')
                                    ->get();
            $upcomingReservations = RegForm::where('isApproved', 1)
                                            ->where('isCancelled', 0)
                                            ->whereDate('stime_res', '>=', Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString())
                                            ->whereDate('stime_res', '<=', Carbon::now()->endOfWeek(Carbon::SATURDAY)->toDateString())
                                            ->orderBy('stime_res', 'asc')
                                            ->get();

            $pastEntries = [];
            foreach ($upcomingReservations as $reservation) {
                if(Carbon::parse($reservation->etime_res)->isPast()) {
                    $pastEntries[] = $reservation->form_id;
                }
            }

            if(!empty($pastEntries)) {
                $upcomingReservations = $upcomingReservations->except($pastEntries);
            }
            
            Log::info('Rendering results for data visualization.');
            $formStats = Self::getFormStats();
            $userStats = Self::getUserTrafficStats();
            Log::info('Displaying admin dashboard for '.Auth()->user()->user_id.'.');
            return view('pages.requests')->with('pendingforms', $pendingforms)
                                         ->with('upcomingReservations', $upcomingReservations)
                                         ->with('formStats', $formStats)
                                         ->with('userStats', $userStats);
        } elseif ($role == 1){
            $studentReservations = RegForm::where('user_id', Auth()->user()->user_id)->get();
            $upcomingReservations = RegForm::where('user_id', Auth()->user()->user_id)
                                            ->where('isApproved', 1)
                                            ->where('isCancelled', 0)
                                            ->whereDate('stime_res', '>=', Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString())
                                            ->whereDate('stime_res', '<=', Carbon::now()->endOfWeek(Carbon::SATURDAY)->toDateString())
                                            ->orderBy('stime_res', 'asc')
                                            ->get();
                                            
            $pastEntries = [];
            foreach ($upcomingReservations as $reservation) {
                if(Carbon::parse($reservation->etime_res)->isPast()) {
                    $pastEntries[] = $reservation->form_id;
                }
            }

            if(!empty($pastEntries)) {
                $upcomingReservations = $upcomingReservations->except($pastEntries);
            }

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

            Log::info('Displaying faculty/student dashboard for '.Auth()->user()->user_id.'.');
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

            Log::info('Displaying security dashboard for '.Auth()->user()->user_id.'.');
            return view('pages.reservation')->with('classSchedules', $classSchedules)
                                            ->with('forms', $forms)
                                            ->with('rooms', $rooms);
        }
    }

    /**
     * Returns reservation history
     *
     * @param  id form_id assigned to the request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function historyList()
    {
        $reservations = RegForm::get();
        $rooms = Room::get();
        $studentReservations = RegForm::where('user_id', Auth()->User()->user_id)->get();

        Log::info('Displaying history page for '.Auth()->user()->user_id.'. Rendering entries to DataTables.');
        return view('pages.history')->with("reservations", $reservations)
                                    ->with("rooms", $rooms)
                                    ->with("studentReservations", $studentReservations);
    }

    /**
    * Calculates the percentage of the number of requests this month out of the total
    * 
    * @param total The total count of requests
    * @param thisMonth The total count of requests for the last 30 days
    */
    private function getPercentage($total, $thisMonth){
        return ($total == 0) ? 0 : $thisMonth * (100/$total);
    }

    /**
    * Counts the number of requests made in the last 4 months based on the users' division
    * 
    * @return userTrafficStats array to be rendered by ChartJS
    */
    private function getUserTrafficStats() {
        //0=staff, 1=faculty, 2=college, 3=SHS
        $userTypes = Division::orderBy('division_id', 'asc')->pluck('division_name')->toArray();
        $userTypes[0] = "Admin";
        $userTrafficStats = [];

        for ($userType = 1; $userType <= 4; $userType++) {
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

    /**
    * Counts the number of requests made since launch and a month ago based on status
    * 
    * @return formStats array to be rendered by ChartJS
    */
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
        // $receivedCountFormer = RegForm::whereDate('created_at', '>=', Carbon::now()->subMonths(2))
        //                             ->whereDate('created_at', '<', Carbon::now()->subMonth())
        //                             ->count();
        // $approvedCountFormer = RegForm::where('isApproved', 1)
        //                             ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
        //                             ->whereDate('created_at', '<', Carbon::now()->subMonth())
        //                             ->count();
        // $rejectedCountFormer = RegForm::where('user_id', '!=', 'admin')
        //                             ->where('isApproved', 2)
        //                             ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
        //                             ->whereDate('created_at', '<', Carbon::now()->subMonth())
        //                             ->count();
        // $cancelledCountFormer = RegForm::where('isCancelled', 1)
        //                             ->whereDate('created_at', '>=', Carbon::now()->subMonths(2))
        //                             ->whereDate('created_at', '<', Carbon::now()->subMonth())
        //                             ->count();
        
        $formStats = [
            'received' => [$receivedCountAll, $receivedCountNow, Self::getPercentage($receivedCountAll, $receivedCountNow)],
            'confirmed' => [$approvedCountAll, $approvedCountNow, Self::getPercentage($approvedCountAll, $approvedCountNow)],
            'rejected' => [$rejectedCountAll, $rejectedCountNow, Self::getPercentage($rejectedCountAll, $rejectedCountNow)],
            'cancelled' => [$cancelledCountAll, $cancelledCountNow, Self::getPercentage($cancelledCountAll, $cancelledCountNow)]
        ];

        return $formStats;
    }
}