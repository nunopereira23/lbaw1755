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

use App\Event;

class EventsController extends Controller
{

    public function show()
    {
        $events = Event::where('event_visibility','Public')->get();
        $count = $events->count();
        return view('pages.events', ['events' => $events, 'count' => $count]);
    }

    public function search(Request $request)
    {
        $title = $request->input('title');
        $startFrom = $request->input('startFrom');
        $startTo = $request->input('startTo');
        $km = $request->input('km');
        $type = $request->input('type');
        $order = $request->input('order');
        $orderDirection = $request->input('orderDirection');
        $events = Event::where('event_visibility','Public')
            ->where('title', 'LIKE', '%'.$title.'%')
            ->orderBy($order, $orderDirection)
            ->get();
        if ($type != "All" && !(empty($startFrom)) && !(empty($startTo)) ) {
            $events = Event::where('event_visibility','Public')
                ->where('title', 'LIKE', '%'.$title.'%')
                ->whereBetween('event_start', [$startFrom, $startTo])
                ->where('event_type', $type)
                ->orderBy($order, $orderDirection)
                ->get();
        }
        if ($type != "All" && empty($startFrom) && empty($startTo) ) {
            $events = Event::where('event_visibility','Public')
                ->where('title', 'LIKE', '%'.$title.'%')
                ->where('event_type', $type)
                ->orderBy($order, $orderDirection)
                ->get();
        }
        $count = $events->count();
        //if count == 0, echo NO RESULTS
        return view('pages.events', ['events' => $events, 'count' => $count]);
    }

}