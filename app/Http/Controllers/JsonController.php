<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    /**
     * Returns the room ids and room names for the 6th floor
     *
     * @return \Illuminate\Http\Response
     */
    public function flr6()
    {
        return response()->file(public_path('6th-floor.json'));
    }

    /**
     * Returns the room ids and room names for the 7th floor
     *
     * @return \Illuminate\Http\Response
     */
    public function flr7()
    {
        return response()->file(public_path('7th-floor.json'));
    }

    /**
     * Returns the room ids and room names for the 8th floor
     *
     * @return \Illuminate\Http\Response
     */
    public function flr8()
    {
        return response()->file(public_path('8th-floor.json'));
    }

    /**
     * Returns the room ids and room names for the 9th floor
     *
     * @return \Illuminate\Http\Response
     */
    public function flr9()
    {   
        return response()->file(public_path('9th-floor.json'));
    }

    /**
     * Returns the room ids and room names for the 10th floor
     *
     * @return \Illuminate\Http\Response
     */
    public function flr10()
    {
        return response()->file(public_path('10th-floor.json'));
    }

    /**
     * Returns the room ids and room names for the ground floor
     *
     * @return \Illuminate\Http\Response
     */
    public function grdflr()
    {
        return response()->file(public_path('ground-floor.json'));
    }
}
