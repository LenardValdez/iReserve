<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\Room;
use App\User;
use App\RegForm;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\RoomRequest;
use App\Notifications\RoomStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        if($request->validated()) {
            if(Room::withTrashed()->find($request->get('room_id'))->trashed()) {
                $softDeletedRoom = Room::onlyTrashed()
                                        ->where('room_id', $request->get('room_id'))
                                        ->restore();
            }
            $room = Room::where('room_id', $request->get('room_id'))->first();
            $room->room_name = $request->get('room_name');
            $room->room_desc = $request->get('room_desc');
            $room->isSpecial = $request->get('isSpecial');
            $room->save();
            }
        return redirect()->back()->with('roomAlert',["Room ".$request->room_id." has been successfully added!", 
        "This room will be now available for reservation."]);
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'users_involved' => 'nullable',
            'stime_res' => 'required',
            'etime_res' => 'required',
            'purpose' => 'required|max:255'
        ]);

        if($request->has('users_involved')){
            $usersInvolved = $request->input('users_involved');
            $usersInvolved = implode(', ', $usersInvolved);
        }
        else {
            $usersInvolved = NULL;
        }

        $roomType = Room::where('room_id', $request->get('room_id'))->first();

        $checkExisting = RegForm::where('room_id', $request->get('room_id'))
                                ->where('stime_res', '<',  $request->get('etime_res'))
                                ->where('etime_res', '>', $request->get('stime_res'))
                                ->where('isApproved', '1')
                                ->where('isCancelled', '0')
                                ->count();

        $days = ["SUN", "M", "T", "W", "TH", "F", "S"];

        $checkClassExisting = ClassSchedule::where('room_id', $request->get('room_id'))
                                            ->where(function ($query) use($request, $days) {
                                                $query->where('day', $days[Carbon::parse($request->get('stime_res'))->dayOfWeek])
                                                      ->where('stime_class', '<', Carbon::parse($request->get('etime_res'))->format('H:i:s'))
                                                      ->orWhere(function ($query2) use($request, $days) {
                                                        $query2->where('day', $days[Carbon::parse($request->get('etime_res'))->dayOfWeek])
                                                                ->where('etime_class', '>', Carbon::parse($request->get('stime_res'))->format('H:i:s'));
                                                        });
                                            })
                                            ->count();

        $checkSameUserPending = RegForm::where('user_id', Auth()->user()->user_id)
                                        ->where('room_id', $request->get('room_id'))
                                        ->where('stime_res', '<',  $request->get('etime_res'))
                                        ->where('etime_res', '>', $request->get('stime_res'))
                                        ->where('isApproved', '0')
                                        ->count();

        $checkAdminExisting = RegForm::where('user_id','admin')
                                     ->where('room_id', $request->get('room_id'))
                                     ->where('stime_res', '<',  $request->get('etime_res'))
                                     ->where('etime_res', '>', $request->get('stime_res'))
                                     ->where('isApproved', '1')
                                     ->where('isCancelled', '0')
                                     ->count();

        //max. requests a day = 5
        $checkMaxReserve = RegForm::where('user_id', auth()->user()->user_id)
                                  ->whereDate('created_at', Carbon::today())
                                  ->where('isApproved', '!=', '-1')
                                  ->count();

        if($checkMaxReserve>=5 && auth()->user()->roles == 1){
            return redirect()->back()->with('roomErr', ["Oops! You have reached your maximum daily requests.",
            "As a precautionary measure against spam, please try again tomorrow or book under another user."]);
        }
        elseif($checkExisting>='1' && Auth()->user()->roles == 1){ 
            return redirect()->back()->with('roomErr', ["The room you've selected is taken!", 
            "The room you've chosen is not available on the selected period."]);
        }
        elseif($checkSameUserPending>='1' && Auth()->user()->roles == 1){
            return redirect()->back()->with('roomErr', ["Duplicate submission detected!",
                "You've already submitted a request for the same room on the selected period! Please wait for the admin to confirm your request."]);
        }
        else if($request->get('stime_res')==$request->get('etime_res')){
            return redirect()->back()->with('roomErr', ["Invalid reservation period!", "The start and end of the reservation cannot be the same."]);
        }
        else if($checkAdminExisting>='1' && Auth()->user()->roles == 0){
            return redirect()->back()->with('roomErr', ["Same confirmed reservation already exists!", 
            "You have an existing reservation for the same room on the selected period."]);
        }
        else if($checkClassExisting>='1'){
            return redirect()->back()->with('roomErr', ["Class schedule exists!", 
            "Sorry, a class schedule already exists within the reservation period you've provided. Please select a different room and/or period 
            and book again. For room availability, feel free to check the scheduler below."]);
        }
        else {
            if($roomType->isSpecial=='1'){
                $form = new RegForm([
                    'user_id' =>  Auth()->user()->user_id,
                    'room_id' => $request->get('room_id'),
                    'users_involved' => $usersInvolved,
                    'stime_res' => $request->get('stime_res'),
                    'etime_res' => $request->get('etime_res'),
                    'purpose' => $request->get('purpose')
                ]);

                if(Auth()->user()->roles == 0){
                    $sameRange = RegForm::where('user_id', '!=', 'admin')
                                        ->where('room_id', $request->get('room_id'))
                                        ->where('stime_res', '<', $request->get('etime_res'))
                                        ->where('etime_res', '>', $request->get('stime_res'))
                                        ->where('isApproved', '0')
                                        ->get();
                    $cancelSameRange = RegForm::where('user_id', '!=', 'admin')
                                              ->where('room_id', $request->get('room_id'))
                                              ->where('stime_res', '<', $request->get('etime_res'))
                                              ->where('etime_res', '>', $request->get('stime_res'))
                                              ->where('isApproved', '1')
                                              ->first();

                    if(!empty($cancelSameRange)){
                        $cancelSameRange->isCancelled = '1';
                        $cancelSameRange->save();
                        $cancelSameRange->user->notify(new RoomStatus($cancelSameRange));
                    }

                    if(!empty($sameRange)){
                        foreach($sameRange as $same){
                            $same->isApproved = '2';
                            $same->save();
                            $same->user->notify(new RoomStatus($same));
                        }
                    }
                    $form->isApproved = '1';
                    $form->save();

                    return redirect()->back()->with('roomAlert', ["Your reservation is now confirmed!",
                    "Requests for the same room with similar reservation period have been overriden. User/s affected will be notified. 
                    To cancel this reservation, just click on your reservation in the dashboard or scheduler."]);
                }
                else{
                    $form->save();
                    $admin = User::where('user_id', 'admin')->first();
                    if($roomType->isSpecial=='1') {
                        $admin->notify(new RoomStatus($form));
                    }
                    else {
                        $form->user->notify(new RoomStatus($form));
                    }
                    return redirect()->back()->with('roomAlert',["Your special room request has been received.",
                    "Sit back and relax! Your request is now subject for approval. You will receive a notification once its status has been updated."]);
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
                                                ->first();
                    if(!empty($cancelSameRange)){
                        $cancelSameRange->isCancelled = '1';
                        $cancelSameRange->save();
                        $cancelSameRange->user->notify(new RoomStatus($cancelSameRange));
                    }
                }

                $form->isApproved = '1';
                $form->save();

                if(Auth()->user()->roles == 0){
                    return redirect()->back()->with('roomAlert', ["Your reservation is now confirmed!",
                    "Requests for the same room with similar reservation period have been overriden. User/s affected will be notified. 
                    To cancel this reservation, just click on your reservation in the dashboard or scheduler."]);
                }
                else {
                    $form->user->notify(new RoomStatus($form));
                    return redirect()->back()->with('roomAlert',["Your reservation is now confirmed!",
                    "Your reservation has been approved and added to the calendar! To cancel this reservation, 
                    just click on your reservation in the dashboard or scheduler."]);
                }
            }
        }
    }

    public function approve($id)
    {
        if(Auth()->user()->roles == 0){
            $specialRequest = RegForm::find($id);
            
            $specialRequest->isApproved = '1';
            $sameRange = RegForm::where('user_id', '!=', 'admin')
                                ->where('room_id', $specialRequest->room_id)
                                ->where('stime_res', '<', $specialRequest->etime_res)
                                ->where('etime_res', '>', $specialRequest->stime_res)
                                ->where('isApproved', '0')
                                ->get();
            $specialRequest->save();

            if(!empty($sameRange)){
                foreach($sameRange as $same){
                    if($same->user_id != $specialRequest->user_id){
                        $same->isApproved = '2';
                        $same->save();
                        $same->user->notify(new RoomStatus($same));
                    }
                }
            }

            $specialRequest->user->notify(new RoomStatus($specialRequest));

            return redirect()->back()->with('approvedAlert', ["The request has been approved and added to the scheduler!", 
            "Any pending requests for this room number with similar reservation period will 
            automatically be rejected and notified."]);
        }
        else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function reject($id)
    {
        if(Auth()->user()->roles == 0){
            $specialRequest = RegForm::find($id);
            $specialRequest->isApproved = '2';
            $specialRequest->save();
            $specialRequest->user->notify(new RoomStatus($specialRequest));

            return redirect()->back()->with('rejectedAlert', ["The request has been rejected.", "User affected will be notified."]);
        }
        else {
            abort(403, 'Unauthorized action.');
        }
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

    public function cancel(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::in([Auth()->user()->user_id, 'admin'])
            ],
            'form_id' => 'required|exists:reg_forms,form_id',
            'reason' => 'required|max:255',
        ]);

        if(Auth()->user()->user_id == $request->get('user_id') || Auth()->user()->roles == 0){
            $cancelRequest = RegForm::find($request->get('form_id'));
            $cancelRequest->reasonCancelled = $request->get('reason');
            $cancelRequest->isCancelled = '1';
            $cancelRequest->save();

            if (Auth()->user()->user_id != $cancelRequest->user_id){
                $cancelRequest->user->notify(new RoomStatus($cancelRequest));
            }

            if(Auth()->user()->roles == 0) {
                return redirect()->back()->with('cancelledAlert', ["The request/reservation is now cancelled.", 
                "User affected will be notified. Reservation details may still be accessed through the over-all reservation history."]);
            }
            else {
                return redirect()->back()->with('cancelledAlert', ["Your request/reservation is now cancelled.", 
                "Reservation details may still be accessed through your reservation history."]);
            }
        }
        else {
            abort(403, 'Unauthorized action.');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,room_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        if ($validator->errors()->has('password')) {
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            $existingForms = RegForm::where('room_id', $request->room_id)
                                    ->where('isCancelled', 0)
                                    ->where('etime_res', '>=', Carbon::today())
                                    ->where('isApproved', '!=', 2)
                                    ->get();
            
            if(!empty($existingForms)){
                foreach($existingForms as $form){
                    $form->isCancelled = 1;
                    $form->reasonCancelled = "Room has been removed from the system.";
                    $form->save();

                    if (Auth()->user()->user_id != $cancelRequest->user_id) {
                        $form->user->notify(new RoomStatus($form));
                    }
                }
            }

            $delete = Room::where('room_id',$request->room_id)->first();
            $delete->delete();

            // return redirect()->back()->with('roomAlert',["Room ".$request->room_id." has been successfully deleted.",
            // "Any confirmed and pending reservations are now automatically cancelled."]);
            return Response::json(['success' => true, 'idRemoved' => $request->room_id]);
        }
    }

    public function list()
    {
        $classSchedules = ClassSchedule::get();
        $classrooms = ClassSchedule::groupBy('room_id')
                                    ->orderBy('room_id', 'asc')
                                    ->pluck('room_id');
        $forms = RegForm::where('isApproved', '1')->get();
        $rooms = Room::orderByRaw('LENGTH(room_desc)', 'asc')
                    ->orderBy('room_desc', 'asc')
                    ->get();
        $descriptions = Room::groupBy('room_desc')
                            ->orderByRaw('LENGTH(room_desc)', 'asc')
                            ->orderBy('room_desc', 'asc')
                            ->pluck('room_desc');
        $users = User::orderBy('name','asc')
                     ->where('isActive', true)
                     ->get();

        $roomList = [];
        foreach($descriptions as $description){
            $roomList[] = [
                $description => []
            ];
        }

        foreach($rooms as $room){
            if(isset($room->room_name)) {
                $roomList[$room->room_desc][$room->room_id] = $room->room_id." (".$room->room_name.")";
            }
            else {
                $roomList[$room->room_desc][$room->room_id] = $room->room_id;
            }
        }

        foreach($descriptions as $description){
            $roomListJson = json_encode($roomList[$description], JSON_PRETTY_PRINT);
            file_put_contents(public_path(preg_replace('/\s+/', '-', strtolower($description)).'.json'), stripslashes($roomListJson));
        }

        return view('pages.reservation')->with("forms", $forms)
                                        ->with("rooms", $rooms)
                                        ->with("descriptions", $descriptions)
                                        ->with("classSchedules", $classSchedules)
                                        ->with("classrooms", $classrooms)
                                        ->with("users", $users);
    }

    public function readNotif($id)
    {
        $notification = DatabaseNotification::where('id',$id)->first();
        $notification->markAsRead();

        return redirect()->route('Dashboard');
    }

    public function readAllNotif()
    {
        $user = User::where('user_id', Auth()->user()->user_id)->first();
        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
