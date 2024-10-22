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
use App\Notifications\RoomStatus;
use App\Http\Requests\StoreNewRoom;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CancelReservation;
use App\Http\Requests\ProcessReservation;
use App\Http\Requests\ReceiveReservation;
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

        Log::info('Updating room data in JSON files for Select2Cascade.');
        foreach($descriptions as $description){
            $roomListJson = json_encode($roomList[$description], JSON_PRETTY_PRINT);
            file_put_contents(public_path(preg_replace('/\s+/', '-', strtolower($description)).'.json'), stripslashes($roomListJson));
        }

        Log::info('Displaying reservation page for '.Auth()->user()->user_id.'.');
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
     * @param  \App\Http\Requests\StoreNewRoom $room
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewRoom $request)
    {
        Log::info('Request to store room entry received from '.Auth()->user()->user_id.'.');
        $validatedRequest = $request->validated();
        Log::info('Initial request validation passed.');

        // restores soft-deleted entry if room number previously exists
        if(Room::onlyTrashed()->where('room_id', $validatedRequest['room_id'])->exists()) {
            Room::onlyTrashed()->where('room_id', $validatedRequest['room_id'])->restore();
            Log::info('Soft-deleted entry detected and restored. Room ID: '.$validatedRequest['room_id']);
        }

        // details will get updated if the entry was restored, and will be created if the entry is new
        Room::updateOrCreate($validatedRequest);
        Log::info('Entry successfully stored to the database. Room ID: '.$validatedRequest['room_id']);
        return redirect()->back()->with('roomAlert',["Room ".$validatedRequest['room_id']." has been successfully added!", 
        "This room will be now available for reservation."]);
    }

    /**
     * Processes the room reservation request submitted
     *
     * @param  \App\Http\Requests\ReceiveReservation $request
     * @return \Illuminate\Http\Response
     */
    public function reserve(ReceiveReservation $request)
    {
        Log::info('Request to reserve room received from '.Auth()->user()->user_id.'.');
        $validatedRequest = $request->validated();
        Log::info('Initial request validation passed.');

        if(isset($validatedRequest['users_involved'])){
            $usersInvolved = $validatedRequest['users_involved'];
            $usersInvolved = implode(', ', $usersInvolved);
        }
        else {
            $usersInvolved = NULL;
        }

        $roomSelected = Room::where('room_id', $validatedRequest['room_id'])->first();

        // checks for similar existing confirmed requests for the room
        $checkExisting = RegForm::where('room_id', $validatedRequest['room_id'])
                                ->where('stime_res', '<',  $validatedRequest['etime_res'])
                                ->where('etime_res', '>', $validatedRequest['stime_res'])
                                ->where('isApproved', '1')
                                ->where('isCancelled', '0')
                                ->count();

        $days = ["SUN", "M", "T", "W", "TH", "F", "S"];

        // checks if a class schedule is in place for the selected room and reservation period
        $checkClassExisting = ClassSchedule::where('room_id', $validatedRequest['room_id'])
                                            ->where(function ($query) use($validatedRequest, $days) {
                                                $query->where('day', $days[Carbon::parse($validatedRequest['stime_res'])->dayOfWeek])
                                                      ->where('stime_class', '<', Carbon::parse($validatedRequest['etime_res'])->format('H:i:s'))
                                                      ->where('etime_class', '>', Carbon::parse($validatedRequest['stime_res'])->format('H:i:s'))
                                                      ->orWhere(function ($query2) use($validatedRequest, $days) {
                                                        $query2->where('day', $days[Carbon::parse($validatedRequest['etime_res'])->dayOfWeek])
                                                                ->where('stime_class', '<', Carbon::parse($validatedRequest['etime_res'])->format('H:i:s'))
                                                                ->where('etime_class', '>', Carbon::parse($validatedRequest['stime_res'])->format('H:i:s'));
                                                        });
                                            })
                                            ->count();

        // checks for duplicate request
        $checkSameUserPending = RegForm::where('user_id', $validatedRequest['user_id'])
                                        ->where('room_id', $validatedRequest['room_id'])
                                        ->where('stime_res', '<',  $validatedRequest['etime_res'])
                                        ->where('etime_res', '>', $validatedRequest['stime_res'])
                                        ->where('isApproved', '0')
                                        ->count();

        // checks if an admin-hosted reservation is in place for the selected room and reservation period
        $checkAdminExisting = RegForm::where('user_id','admin')
                                     ->where('room_id', $validatedRequest['room_id'])
                                     ->where('stime_res', '<',  $validatedRequest['etime_res'])
                                     ->where('etime_res', '>', $validatedRequest['stime_res'])
                                     ->where('isApproved', '1')
                                     ->where('isCancelled', '0')
                                     ->count();

        // checks if the user has reached the maximum number of submissions per day (5)
        $checkMaxReserve = RegForm::where('user_id', $validatedRequest['user_id'])
                                  ->whereDate('created_at', Carbon::today())
                                  ->where('isApproved', '!=', '-1')
                                  ->count();


        if($checkMaxReserve>=5 && auth()->user()->roles == 1){
            Log::info('Checking for the user\'s submission count.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Oops! You have reached your maximum daily requests.",
            "As a precautionary measure against spam, please try again tomorrow or book under another user."]);
        }
        elseif($checkExisting>='1' && Auth()->user()->roles == 1){ 
            Log::info('Checking for similar existing confirmed requests.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["The room you've selected is taken!", 
            "The room you've chosen is not available on the selected period."]);
        }
        elseif($checkSameUserPending>='1' && Auth()->user()->roles == 1){
            Log::info('Checking for duplicate pending request.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Duplicate submission detected!",
                "You've already submitted a request for the same room on the selected period! Please wait for the admin to confirm your request."]);
        }
        else if($validatedRequest['stime_res']==$validatedRequest['etime_res']){
            Log::info('Checking for validity of daterange input.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Invalid reservation period!", "The start and end of the reservation cannot be the same."]);
        }
        else if(auth()->user()->roles == 1 && (Carbon::parse($validatedRequest['etime_res'])->toDateString() > Carbon::parse($validatedRequest['stime_res'])->addDays(5)->toDateString())){
            Log::info('Checking for validity of daterange span.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Maximum number of days per reservation surpassed!", "Users can only reserve for up to 5 days per submission."]);
        }
        else if(Carbon::parse($validatedRequest['stime_res'])->isPast() || Carbon::parse($validatedRequest['etime_res'])->isPast()){
            Log::info('Checking for validity of daterange input.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Invalid reservation period!", "Date and time entered cannot be from the past."]);
        }
        else if($checkAdminExisting>='1' && Auth()->user()->roles == 0){
            Log::info('Checking for any admin-hosted reservation in place for the selected room and reservation period.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Same confirmed reservation already exists!", 
            "You have an existing reservation for the same room on the selected period."]);
        }
        else if($checkClassExisting>='1'){
            Log::info('Checking if a class schedule is in place for the selected room and reservation period.');
            Log::info('Validation detected conflict in the request. Action aborted.');
            return redirect()->back()->with('roomErr', ["Class schedule exists!", 
            "Sorry, a class schedule already exists within the reservation period you've provided. Please select a different room and/or period 
            and book again. For room availability, feel free to check the scheduler below."]);
        }
        else {
            // validates form differently if room selected is tagged as special room (i.e. requires approval)
            if($roomSelected->isSpecial=='1'){
                $form = new RegForm([
                    'user_id' =>  $validatedRequest['user_id'],
                    'room_id' => $validatedRequest['room_id'],
                    'users_involved' => $usersInvolved,
                    'stime_res' => $validatedRequest['stime_res'],
                    'etime_res' => $validatedRequest['etime_res'],
                    'purpose' => $validatedRequest['purpose']
                ]);

                if(Auth()->user()->roles == 0){
                    Log::info('Admin-hosted request acknowledged. Room ID: '.$validatedRequest['room_id']);
                    $sameRange = RegForm::where('user_id', '!=', 'admin')
                                        ->where('room_id', $validatedRequest['room_id'])
                                        ->where('stime_res', '<', $validatedRequest['etime_res'])
                                        ->where('etime_res', '>', $validatedRequest['stime_res'])
                                        ->where('isApproved', '0')
                                        ->get();
                    $cancelSameRange = RegForm::where('user_id', '!=', 'admin')
                                              ->where('room_id', $validatedRequest['room_id'])
                                              ->where('stime_res', '<', $validatedRequest['etime_res'])
                                              ->where('etime_res', '>', $validatedRequest['stime_res'])
                                              ->where('isApproved', '1')
                                              ->first();

                    // overrides requests for the same room with similar reservation period if admin-hosted
                    if(!empty($cancelSameRange)){
                        Log::info('Overriding confirmed reservations for the same room with similar reservation period.');
                        $cancelSameRange->isCancelled = '1';
                        $cancelSameRange->save();
                        $cancelSameRange->user->notify(new RoomStatus($cancelSameRange));
                    }

                    if(!empty($sameRange)){
                        Log::info('Autorejecting pending requests for the same room with similar reservation period.');
                        foreach($sameRange as $same){
                            $same->isApproved = '2';
                            $same->save();
                            $same->user->notify(new RoomStatus($same));
                        }
                    }
                    $form->isApproved = '1';
                    $form->save();

                    Log::info('Reservation accepted and confirmed. Request ID: '.$form->form_id);
                    return redirect()->back()->with('roomAlert', ["Your reservation is now confirmed!",
                    "Requests for the same room with similar reservation period have been overriden. User/s affected will be notified. 
                    To cancel this reservation, just click on your reservation in the dashboard or scheduler."]);
                }
                else{
                    $form->save();
                    Log::info('Reservation accepted for approval. Request ID: '.$form->form_id);

                    // sends a site notification to the admin if a request has been submitted
                    if($form->user_id != 'admin') {
                        $admin = User::where('user_id', 'admin')->first();
                        Log::info('Sending notification of new request to admin. Request ID: '.$form->form_id);
                        $admin->notify(new RoomStatus($form));

                        // sends an email notification to the user once the request has been received
                        Log::info('Sending notification of request creation to user. Request ID: '.$form->form_id);
                        $form->user->notify(new RoomStatus($form));
                    }
                    
                    return redirect()->back()->with('roomAlert',["Your special room request has been received.",
                    "Sit back and relax! Your request is now subject for approval. You will receive a notification once its status has been updated."]);
                }
            }
            else {
                $form = new RegForm([
                    'user_id' =>  $validatedRequest['user_id'],
                    'room_id' => $validatedRequest['room_id'],
                    'users_involved' => $usersInvolved,
                    'stime_res' => $validatedRequest['stime_res'],
                    'etime_res' => $validatedRequest['etime_res'],
                    'purpose' => $validatedRequest['purpose']
                ]);
                
                // overrides confirmed reservation for the same room with similar reservation period if admin-hosted
                if(Auth()->user()->roles == 0){
                    Log::info('Admin-hosted request acknowledged. Room ID: '.$validatedRequest['room_id']);
                    $cancelSameRange = RegForm::where('user_id', '!=', 'admin')
                                                ->where('room_id', $validatedRequest['room_id'])
                                                ->where('stime_res', '<', $validatedRequest['etime_res'])
                                                ->where('etime_res', '>', $validatedRequest['stime_res'])
                                                ->where('isApproved', '1')
                                                ->first();
                    if(!empty($cancelSameRange)){
                        Log::info('Overriding confirmed reservations for the same room with similar reservation period.');
                        $cancelSameRange->isCancelled = '1';
                        $cancelSameRange->save();
                        $cancelSameRange->user->notify(new RoomStatus($cancelSameRange));
                    }
                }

                $form->isApproved = '1';
                $form->save();

                Log::info('Reservation accepted and confirmed. Request ID: '.$form->form_id);

                if(Auth()->user()->roles == 0){
                    return redirect()->back()->with('roomAlert', ["Your reservation is now confirmed!",
                    "Requests for the same room with similar reservation period have been overriden. User/s affected will be notified. 
                    To cancel this reservation, just click on your reservation in the dashboard or scheduler."]);
                }
                else {
                    Log::info('Sending notification of request creation to user. Request ID: '.$form->form_id);
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
     * @param  \App\Http\Requests\ProcessReservation $request
     * @return \Illuminate\Http\Response
     */
    public function approve(ProcessReservation $request)
    {
        Log::info('Request to store room entry received from admin.');
        $specialRequest = RegForm::find($request->validated()['form_id']);
        Log::info('Initial request validation passed.');

        $specialRequest->isApproved = '1';
        $sameRange = RegForm::where('user_id', '!=', 'admin')
                            ->where('room_id', $specialRequest->room_id)
                            ->where('stime_res', '<', $specialRequest->etime_res)
                            ->where('etime_res', '>', $specialRequest->stime_res)
                            ->where('isApproved', '0')
                            ->get();
        $specialRequest->save();
        Log::info('Reservation approved and updated. Request ID: '.$specialRequest->form_id);

        // automatically rejects other pending requests for the same room with similar reservation period
        if(!empty($sameRange)){
            Log::info('Autorejecting pending requests for the same room with similar reservation period.');
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
        Log::info('Sending notification of request approval to user. Request ID: '.$specialRequest->form_id);
        $specialRequest->user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('approvedAlert', ["The request has been approved and added to the scheduler!", 
        "Any pending requests for this room number with similar reservation period will 
        automatically be rejected and notified."]);
    }

    /**
     * Rejects a pending special room request
     *
     * @param  \App\Http\Requests\ProcessReservation $request
     * @return \Illuminate\Http\Response
     */
    public function reject(ProcessReservation $request)
    {
        Log::info('Request to store room entry received from admin.');
        $specialRequest = RegForm::find($request->validated()['form_id']);
        Log::info('Initial request validation passed.');
        $specialRequest->isApproved = '2';
        $specialRequest->save();
        Log::info('Reservation rejected and updated. Request ID: '.$specialRequest->form_id);

        // sends an email and site notification to the user upon rejection of request
        Log::info('Sending notification of request rejection to user. Request ID: '.$specialRequest->form_id);
        $specialRequest->user->notify(new RoomStatus($specialRequest));

        return redirect()->back()->with('rejectedAlert', ["The request has been rejected.", "Schedule booked will remain open for requests. User affected will be notified."]);
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
     * @param  \App\Http\Requests\CancelReservation $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(CancelReservation $request)
    {
        Log::info('Request to store room entry received from '.Auth()->user()->user_id.'.');
        $validatedRequest = $request->validated();
        Log::info('Initial request validation passed.');
        $cancelRequest = RegForm::find($validatedRequest['form_id']);

        // automatically rejects the request if still pending to allow same user rebooking
        if($cancelRequest->isApproved == 0) {
            Log::info('Pending request automatically rejected. Request ID: '.$cancelRequest->form_id);
            $cancelRequest->isApproved = '2';
        }

        $cancelRequest->reasonCancelled = $validatedRequest['reason'];
        $cancelRequest->isCancelled = '1';
        $cancelRequest->save();
        Log::info('Reservation cancelled and updated. Request ID: '.$cancelRequest->form_id);

        // sends an email and site notification to the user if cancellation was done by the admin
        if (Auth()->user()->user_id != $cancelRequest->user_id){
            Log::info('Sending notification of admin\'s request cancellation to user. Request ID: '.$cancelRequest->form_id);
            $cancelRequest->user->notify(new RoomStatus($cancelRequest));
        }
        else {
            // sends a site notification to the admin if a user has cancelled a confirmed reservation
            if($cancelRequest->user_id != 'admin' && $cancelRequest->isApproved == 1) {
                $admin = User::where('user_id', 'admin')->first();
                Log::info('Sending notification of user\'s request cancellation to admin. Request ID: '.$cancelRequest->form_id);
                $admin->notify(new RoomStatus($cancelRequest));
            }
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
        Log::info('Request to delete room received from admin.');
        // creates a custom validator to check if the password entered is correct
        Validator::extend('passwordMatches', function($attribute, $value, $parameters)
        {
            return (Hash::check($value, $parameters[0])) ? true : false;
        });

        Log::info('Validating admin request to delete Room ID '.$request->room_id.'.');
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,room_id',
            'password' => 'required|passwordMatches:'.Auth()->user()->password
        ]);

        // returns errors to the AJAX request if password entered is incorrect
        if ($validator->errors()->has('password')) {
            Log::notice('Validation detected failure. Sending response to AJAX call.');
            return Response::json(['errors' => $validator->errors()]);
        } 
        else {
            Log::info('Initial request validation passed.');
            // automatically deletes class schedules for the room to be removed
            if(ClassSchedule::where('room_id', $request->room_id)->exists()){
                Log::info('Autodeleting class schedules for the room.');
                ClassSchedule::where('room_id', $request->room_id)->delete();
            }

            $existingForms = RegForm::where('room_id', $request->room_id)
                                    ->where('isCancelled', 0)
                                    ->where('etime_res', '>=', Carbon::today())
                                    ->where('isApproved', '!=', 2)
                                    ->get();

            // automatically cancels existing requests and reservations for the room to be removed
            if(!empty($existingForms)){
                Log::info('Autocancelling existing requests for the room.');
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
            Log::notice('Room soft deletion success. Sending response to AJAX call.');

            // returns success boolean variable to the AJAX request along with the room number removed for the display message
            return Response::json(['success' => true, 'idRemoved' => $request->room_id]);
        }
    }
}
