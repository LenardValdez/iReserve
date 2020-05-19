<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Clears the selected notification in the tab
     *
     * @param  id id of selected notification
     * @return \Illuminate\Http\Response
     */
    public function readNotif($id)
    {
        $notification = DatabaseNotification::where('id',$id)->first();
        $notification->markAsRead();

        return redirect()->back();
    }

    /**
     * Clears all the notifications in the tab
     *
     * @return \Illuminate\Http\Response
     */
    public function readAllNotif()
    {
        $user = User::where('user_id', Auth()->user()->user_id)->first();
        $user->unreadNotifications->markAsRead();

        return redirect()->back();
    }
}
