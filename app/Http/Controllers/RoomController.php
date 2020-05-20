<?php

namespace App\Http\Controllers;

use Response;
use Carbon\Carbon;
use App\User;
use App\Room;
use App\RegForm;
use App\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\RoomRequest;
use App\Notifications\RoomStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RoomController extends Controller
{
    /**
     * Displays the listings needed for the reservation page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * Stores new room entry to the room database
     *
     * @param  \App\Http\Requests\RoomRequest $room
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        if($request->validated()) {
            // restores soft-deleted entry if room number previously exists
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

    /**
     * Processes the room reservation request submitted
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

        $roomSelected = Room::where('room_id', $request->get('room_id'))->first();

        // checks for similar existing confirmed requests for the room
        $checkExisting = RegForm::where('room_id', $request->get('room_id'))
                                ->where('stime_res', '<',  $request->get('etime_res'))
                                ->where('etime_res', '>', $request->get('stime_res'))
                                ->where('isApproved', '1')
                                ->where('isCancelled', '0')
                                ->count();

        $days = ["SUN", "M", "T", "W", "TH", "F", "S"];

        // checks if a class schedule is in place for the selected room and reservation period
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

        // checks for duplicate request
        $checkSameUserPending = RegForm::where('user_id', Auth()->user()->user_id)
                                        ->where('room_id', $request->get('room_id'))
                                        ->where('stime_res', '<',  $request->get('etime_res'))
                                        ->where('etime_res', '>', $request->get('stime_res'))
                                        ->where('isApproved', '0')
                                        ->count();

        // checks if an admin-hosted reservation is in place for the selected room and reservation period
        $checkAdminExisting = RegForm::where('user_id','admin')
                                     ->where('room_id', $request->get('room_id'))
                                     ->where('stime_res', '<',  $request->get('etime_res'))
                                     ->where('etime_res', '>', $request->get('stime_res'))
                                     ->where('isApproved', '1')
                                     ->where('isCancelled', '0')
                                     ->count();

        // checks if the user has reached the maximum number of submissions per day (5)
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
            // validates form differently if room selected is tagged as special room (i.e. requires approval)
            if($roomSelected->isSpecial=='1'){
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

                    // overrides requests for the same room with similar reservation period if admin-hosted
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
                    // sends a site notification to the admin if a request has been submitted
                    $admin = User::where('user_id', 'admin')->first();
                    if($roomSelected->isSpecial=='1') {
                        $admin->notify(new RoomStatus($form));
                    }
                    else {
                        // sends an email notification to the user if a request has been received by the admin
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
                
                // overrides confirmed reservation for the same room with similar reservation period if admin-hosted
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

    /**
     * Approves a pending special room request
     *
     * @param  id form_id assigned to the request
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $specialRequest = RegForm::find($id);
        
        $specialRequest->isApproved = '1';
        $sameRange = RegForm::where('user_id', '!=', 'admin')
                            ->where('room_id', $specialRequest->room_id)
                            ->where('stime_res', '<', $specialRequest->etime_res)
                            ->where('etime_res', '>', $specialRequest->stime_res)
                            ->where('isApproved', '0')
                            ->get();
        $specialRequest->save();

        // automatically rejects other pending requests for the same room with similar reservation period
        if(!empty($sameRange)){
            foreach($sameRange as $same){
                if($same->user_id != $specialRequest->user_id){
                    $same->isApproved = '2';
                    $same->save();
                    // sends an email and site notification to the user upon rejection of request
                    $same->user->notify(new RoomStatus($same));
                }
            }
        }

        // sends an email and site notification to the user upon approval of request
        $specialRequest->user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('approvedAlert', ["The request has been approved and added to the scheduler!", 
        "Any pending requests for this room number with similar reservation period will 
        automatically be rejected and notified."]);
    }

    /**
     * Rejects a pending special room request
     *
     * @param  id form_id assigned to the request
     * @return \Illuminate\Http\Response
     */
    public function reject($id)
    {
        $specialRequest = RegForm::find($id);
        $specialRequest->isApproved = '2';
        $specialRequest->save();
        // sends an email and site notification to the user upon rejection of request
        $specialRequest->user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('rejectedAlert', ["The request has been rejected.", "User affected will be notified."]);
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
     * Cancels a pending or confirmed room reservation
     *
     * @param  id form_id assigned to the request
     * @return \Illuminate\Http\Response
     */
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

        $cancelRequest = RegForm::find($request->get('form_id'));
        $cancelRequest->reasonCancelled = $request->get('reason');
        $cancelRequest->isCancelled = '1';
        $cancelRequest->save();

        // sends an email and site notification to the user if cancellation was done by the admin
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
    /**
     * Soft deletes the room selected
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // creates a custom validator to check if the password entered is correct
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,room_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        // returns errors to the AJAX request if password entered is incorrect
        if ($validator->errors()->has('password')) {
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            $existingForms = RegForm::where('room_id', $request->room_id)
                                    ->where('isCancelled', 0)
                                    ->where('etime_res', '>=', Carbon::today())
                                    ->where('isApproved', '!=', 2)
                                    ->get();
            
            // automatically cancels existing requests and reservations for the room to be removed
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

            // returns success boolean variable to the AJAX request along with the room number removed for the display message
            return Response::json(['success' => true, 'idRemoved' => $request->room_id]);
        }
    }
}
