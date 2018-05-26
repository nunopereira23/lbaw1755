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
            $now = new DateTime();
            $past = true;
            $events = $user->events()->where('event_start' ,'>=' ,$now)
                ->where('is_deleted', false)
                ->get();

            return view('pages.my_events', ['events' => $events, 'user' =>$user, 'past'=> $past]);
        }
        return view('pages.error');
    }

    public function showPast($id)
    {
        $id_auth = Auth::id();
        if ($id == $id_auth) {
            $user = User::findOrFail($id_auth);
            $now = new DateTime();
            $past = false;
            $events = $user->events()->where('event_start' ,'<' ,$now)
                ->where('is_deleted', false)
                ->get();
            return view('pages.my_events', ['events' => $events, 'user' =>$user, 'past'=> $past]);
        }
        return view('pages.error');
    }

    public function search(Request $request) {
        $past = true;
        $user = Auth::user();
        $title = $request->input('title');
        $startFrom = $request->input('startFrom');
        $startTo = $request->input('startTo');
        $location = $request->input('location');
        $type = $request->input('type');
        $order = $request->input('order');
        $orderDirection = $request->input('orderDirection');
        if (empty($startFrom)) {
            $startFrom = new DateTime('1000-00-00');
        }
        if (empty($startTo)) {
            $startTo = new DateTime('9999-00-00');
        }
        $events = $user->events()
            ->where('title', 'LIKE', '%'.$title.'%')
            ->where('gps', 'LIKE', '%'.$location.'%')
            ->where('is_deleted', false)
            ->whereBetween('event_start', [$startFrom, $startTo])
            ->orderBy($order, $orderDirection)
            ->get();
        if ($type != "All") {
            $events = $user->events()
                ->where('title', 'LIKE', '%'.$title.'%')
                ->where('gps', 'LIKE', '%'.$location.'%')
                ->where('is_deleted', false)
                ->whereBetween('event_start', [$startFrom, $startTo])
                ->where('event_type', $type)
                ->orderBy($order, $orderDirection)
                ->get();
        }
        return view('pages.my_events', ['events' => $events, 'user' =>$user, 'past'=> $past]);
    }

}
