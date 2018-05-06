<?php
/**
 * Created by PhpStorm.
 * User: nunopereira23
 * Date: 24.4.18
 * Time: 15:36
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DateTime;

use App\Event;
use Auth;
use App\User;

class MyEventsController extends Controller
{

    public function show($id)
    {
        $id_auth = Auth::id();
        if ($id == $id_auth) {
            $user = User::findOrFail($id_auth);
            $eventsArray = array();
            $now = new DateTime();
            $past = true;
            foreach ($user->events as $event) {
                if($now <= new DateTime($event->event_start)) {
                    $eventsArray[] = $event;
                }
            }
            return view('pages.my_events', ['events' => $eventsArray, 'user' =>$user, 'past'=> $past]);
        }
        return view('pages.error');
    }

    public function showPast($id)
    {
        $id_auth = Auth::id();
        if ($id == $id_auth) {
            $user = User::findOrFail($id_auth);
            $eventsArray = array();
            $now = new DateTime();
            $past = false;
            foreach ($user->events as $event) {
                if($now > new DateTime($event->event_start)) {
                    $eventsArray[] = $event;
                }
            }
            return view('pages.my_events', ['events' => $eventsArray, 'user' =>$user, 'past'=> $past]);
        }
        return view('pages.error');
    }

}
