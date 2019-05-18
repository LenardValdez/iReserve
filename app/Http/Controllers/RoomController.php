<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Room;
use App\User;
use App\RegForm;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;


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
	    return redirect()->back()->with('status',"The room is now saved.");
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

        if($checkExisting>='1' || $request->get('stime_res')==$request->get('etime_res')){
            return redirect()->back()->with('existingErr', "The room you've chosen is not available on the selected period.");
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
                }

                $form->isApproved = '1';
            }
            $form->save();

            return redirect()->back();
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

        return redirect()->back()->with('approvedAlert', "The request has been approved and added to the scheduler! 
                                        Any pending requests for this room number with similar reservation period will 
                                        automatically be rejected.");
    }

    public function reject($id)
    {
        $specialRequest = RegForm::find($id);
        $specialRequest->isApproved = '2';
        $specialRequest->save();

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
        return redirect()->back();
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
}
