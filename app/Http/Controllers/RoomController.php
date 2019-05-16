<?php

namespace App\Http\Controllers;

use App\Room;
use App\User;
use App\RegForm;
/* use DB; */
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Notifications\AcceptedRequest;
use Illuminate\Support\Facades\Auth;


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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.reservation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                                ->where('stime_res', '<', $request->get('etime_res'))
                                ->where('etime_res', '>', $request->get('stime_res'))
                                ->where('isApproved', '1')
                                ->count();

        
        if($checkExisting>='1'){
            return redirect()->back()->with('existingErr', "The room you've chosen is not available on the selected period.");
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
                $form->isApproved = '1';
            }
            $form->save();
            
            if($request->get('specialReservation')=='0'){
                $autoApprove = Room::where('room_id',$request->get('room_id'))
                                    ->where('isSpecial',false)
                                    ->first();
                $autoApprove->load('regform');
                $autoApprove->regform->isApproved = '1';
                $autoApprove->isAvailable = false;
                $autoApprove->push();
            }

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

        $roomAvailability = Room::where('room_id', $specialRequest->room_id)->first();
        $roomAvailability->isAvailable = false;
        $roomAvailability->save();
        $specialRequest->save();

        $user = User::where('user_id', $specialRequest->user_id)->first();
        $user->notify(new AcceptedRequest($specialRequest));

        return redirect()->back()->with('approvedAlert', "The request has been approved and added to the scheduler! 
                                        Any pending requests for this room number with similar reservation period will 
                                        automatically be rejected.");
    }

    public function reject($id)
    {
        $specialRequest = RegForm::find($id);
        $specialRequest->isApproved = '2';
        $specialRequest->save();

        $user = User::where('user_id', $specialRequest->user_id)->first();
        $user->notify(new AcceptedRequest($specialRequest));

        return redirect()->back()->with('rejectedAlert', "The request has been rejected.");
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
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

    public function test()
    {
        echo "asd";
    
        $user = Auth::user();

        $user->notify(new AcceptedRequest(User::findOrFail(201701026)));
    }
}