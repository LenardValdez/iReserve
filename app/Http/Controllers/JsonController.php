<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function flr6()
    {
        return response()->file(public_path('6th-floor.json'));
    }

    public function flr7()
    {
        return response()->file(public_path('7th-floor.json'));
    }

    public function flr8()
    {
        return response()->file(public_path('8th-floor.json'));
    }

    public function flr9()
    {
        /* $rooms = Room::select('room_id')
                        ->where('room_desc', '9th Floor')
                        ->get();

        $roomList = [];

        foreach($rooms as $room){
            $roomList[$room->room_id] = $room->room_id;
        }

        return json_encode($roomList, JSON_PRETTY_PRINT); */
        
        return response()->file(public_path('9th-floor.json'));
    }

    public function flr10()
    {
        return response()->file(public_path('10th-floor.json'));
    }

    public function grdflr()
    {
        return response()->file(public_path('ground-floor.json'));
    }

}
