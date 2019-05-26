<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Room;
use App\User;
use App\RegForm;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Notifications\RoomStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;


class RoomController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    public function store(RoomRequest $request)
    {
        Room::create($request->validated());
	    return redirect()->back()->with('roomAlert',"Room ".$request->room_id." has been successfully added to the database and scheduler!");
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'users_involved' => 'nullable',
            'stime_res' => 'required',
            'etime_res' => 'required',
            'purpose' => 'required'
        ]);

        if($request->has('users_involved')){
            $usersInvolved = $request->input('users_involved');
            $usersInvolved = implode(', ', $usersInvolved);
        }
        else {
            $usersInvolved = NULL;
        }

        $checkExisting = RegForm::where('room_id', $request->get('room_id'))
                                ->where('stime_res', '<',  $request->get('etime_res'))
                                ->where('etime_res', '>', $request->get('stime_res'))
                                ->where('isApproved', '1')
                                ->count();

        $checkAdminExisting = RegForm::where('user_id','admin')
                                     ->where('room_id', $request->get('room_id'))
                                     ->where('stime_res', '<',  $request->get('etime_res'))
                                     ->where('etime_res', '>', $request->get('stime_res'))
                                     ->where('isApproved', '1')
                                     ->count();
        //admin override
        if($checkExisting>='1' && Auth()->user()->roles != 0){ 
            return redirect()->back()->with('existingErr', "The room you've chosen is not available on the selected period.");
        }
        else if($request->get('stime_res')==$request->get('etime_res')){
            return redirect()->back()->with('existingErr', "The start and end of the reservation cannot be the same.");
        }
        else if($checkAdminExisting>='1' && Auth()->user()->roles == 0){
            return redirect()->back()->with('existingErr', "You have an existing reservation for the same room on the selected period.");
        }
        else {
            if($request->get('specialReservation')=='1'){
                $form = new RegForm([
                    'user_id' =>  Auth()->user()->user_id,
                    'room_id' => $request->get('room_id'),
                    'users_involved' => $usersInvolved,
                    'stime_res' => $request->get('stime_res'),
                    'etime_res' => $request->get('etime_res'),
                    'purpose' => $request->get('purpose')
                ]);

                if(Auth()->user()->roles == 0){

                    $rejectSameRange = RegForm::where('user_id', '!=', 'admin')
                                              ->where('room_id', $request->get('room_id'))
                                              ->where('stime_res', '<', $request->get('etime_res'))
                                              ->where('etime_res', '>', $request->get('stime_res'))
                                              ->where('isApproved', '0')
                                              ->update(['isApproved' => '2']);

                    $cancelSameRange = RegForm::where('user_id', '!=', 'admin')
                                              ->where('room_id', $request->get('room_id'))
                                              ->where('stime_res', '<', $request->get('etime_res'))
                                              ->where('etime_res', '>', $request->get('stime_res'))
                                              ->where('isApproved', '1')
                                              ->update(['isCancelled' => true]);

                    $form->isApproved = '1';
                    $form->save();

                    $container = $form;
                    $container->isCancelled = '1';
                    $reservedForm = RegForm::where('user_id', '!=', 'admin')
                                        ->where('room_id', $request->get('room_id'))
                                        ->where('stime_res', '<', $request->get('etime_res'))
                                        ->where('etime_res', '>', $request->get('stime_res'))
                                        ->get()->first();
                    $user = User::where('user_id', $reservedForm->user_id)->get()->first();
                    $user->notify(new RoomStatus($container));

                    return redirect()->back()->with('roomAlert',"Your reservation has been approved and added to the calendar and database! 
                                                    Requests for the same room with similar reservation period have been overriden.");
                }
                else{
                    $form->save();
                    $user = User::where('user_id', 'admin')->get()->first();
                    if($request->get('specialReservation')=='1'){
                        $user->notify(new RoomStatus($form));
                    }
                    return redirect()->back()->with('roomAlert',"Sit back and relax! Your reservation has been received and is subject for approval.");
                }
            }
            else {
                $form = new RegForm([
                    'user_id' =>  Auth()->user()->user_id,
                    'room_id' => $request->get('room_id'),
                    'users_involved' => $usersInvolved,
                    'stime_res' => $request->get('stime_res'),
                    'etime_res' => $request->get('etime_res'),
                    'purpose' => $request->get('purpose')
                ]);
                
                if(Auth()->user()->roles == 0){
                    $cancelSameRange = RegForm::where('user_id', '!=', 'admin')
                                            ->where('room_id', $request->get('room_id'))
                                            ->where('stime_res', '<', $request->get('etime_res'))
                                            ->where('etime_res', '>', $request->get('stime_res'))
                                            ->where('isApproved', '1')
                                            ->update(['isCancelled' => true]);
                }
                $form->isApproved = '1';
                $form->save();

                $container = $form;
                $container->isCancelled = '1';
                if(Auth()->user()->roles == 0){
                    $reservedForm = RegForm::where('user_id', '!=', 'admin')
                                        ->where('room_id', $request->get('room_id'))
                                        ->where('stime_res', '<', $request->get('etime_res'))
                                        ->where('etime_res', '>', $request->get('stime_res'))
                                        ->get()->first();
                    $user = User::where('user_id', $reservedForm->user_id)->get()->first();
                    $user->notify(new RoomStatus($container));

                    return redirect()->back()->with('roomAlert',"Your reservation has been approved and added to the calendar and database!
                                                    Requests for the same room with similar reservation period have been overriden.");
                }
                else{
                    return redirect()->back()->with('roomAlert',"Your reservation has been approved and added to the calendar and database!");
                }
            }
        }
    }

    public function approve($id)
    {
        $specialRequest = RegForm::find($id);
        
        $specialRequest->isApproved = '1';
        $rejectSameRange = RegForm::where('form_id', '!=', $id)
                                  ->where('room_id', $specialRequest->room_id)
                                  ->where('stime_res', '<', $specialRequest->etime_res)
                                  ->where('etime_res', '>', $specialRequest->stime_res)
                                  ->where('isApproved', '0')
                                  ->update(['isApproved' => '2']);
        $specialRequest->save();

        $user = User::where('user_id', $specialRequest->user_id)->get()->first();
        $user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('approvedAlert', "The request has been approved and added to the scheduler! 
                                        Any pending requests for this room number with similar reservation period will 
                                        automatically be rejected.");
    }

    public function reject($id)
    {
        $specialRequest = RegForm::find($id);
        $specialRequest->isApproved = '2';
        $specialRequest->save();

        $user = User::where('user_id', $specialRequest->user_id)->get()->first();
        $user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('rejectedAlert', "The request has been rejected.");
    }

    public function historyList()
    {
        $reservations = RegForm::get();
        $users = User::get();
        $rooms = Room::get();
        $studentReservations = RegForm::where('user_id', Auth()->User()->user_id)->get();

        return view('pages.history')->with("reservations", $reservations)
                                    ->with("users", $users)
                                    ->with("rooms", $rooms)
                                    ->with("studentReservations", $studentReservations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    public function cancel($id)
    {
        $cancelRequest = RegForm::find($id);
        $cancelRequest->isCancelled = '1';
        $cancelRequest->save();

        if (Auth()->user()->roles == 0 and Auth()->user()->user_id != $cancelRequest->user_id){
            $user = User::where('user_id', $cancelRequest->user_id)->get()->first();
            $user->notify(new RoomStatus($cancelRequest));
        }

        return redirect()->back()->with('cancelledAlert', "The request/reservation has been cancelled.");

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete = Room::where('room_id',$request->room_id)->first();
        $delete->delete();
        return redirect()->back()->with('roomDelAlert','Room '.$request->room_id.' has been successfully deleted from the database and scheduler.');
    }

    public function list()
    {
        $forms = RegForm::where('isApproved', '1')->get();
        $rooms = Room::get();
        $descriptions = Room::groupBy('room_desc')->pluck('room_desc');
        $users = User::orderBy('name','asc')
                     ->where('isActive', true)
                     ->get();
        return view('pages.reservation')->with("forms", $forms)
                                        ->with("rooms", $rooms)
                                        ->with("descriptions", $descriptions)
                                        ->with("users", $users);
    }

    public function readNotif($id)
    {
        $notification = DatabaseNotification::where('id',$id)->first();
        $notification->markAsRead();

        return redirect()->route('Dashboard');
    }
}
