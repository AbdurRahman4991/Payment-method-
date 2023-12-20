<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\lession;
use App\Models\User;
use App\Notifications\NewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postPage()
    {
        return view('post');
    }

    public function newLession(Request $request)
    {
        // event(new NotificationEvent('msssage from ertyuioertyu'));
        $newLession = new lession();
        $newLession->user_id = auth()->user()->id;
        $newLession->title = $request->title;
        $newLession->body = $request->description;
        $newLession->save();
        $AuthId = Auth::user()->id;
        $userData = User::where('id', $AuthId)->get();

        if ($userData) {
            Notification::send($userData, new NewNotification(lession::latest('id')->first()));
            event(new NotificationEvent($request->title));
            return back();
        } else {
            return 'error';
        }
    }

    public function markRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect('home');
    }
}
