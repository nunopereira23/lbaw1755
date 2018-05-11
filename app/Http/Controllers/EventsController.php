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
        if (empty($startFrom)) {
            $startFrom = new DateTime('1000-00-00');
        }
        if (empty($startTo)) {
            $startTo = new DateTime('9999-00-00');
        }
        $events = Event::where('event_visibility','Public')
            ->where('title', 'LIKE', '%'.$title.'%')
            ->whereBetween('event_start', [$startFrom, $startTo])
            ->orderBy($order, $orderDirection)
            ->get();
        if ($type != "All") {
            $events = Event::where('event_visibility','Public')
                ->where('title', 'LIKE', '%'.$title.'%')
                ->whereBetween('event_start', [$startFrom, $startTo])
                ->where('event_type', $type)
                ->orderBy($order, $orderDirection)
                ->get();
        }
        $count = $events->count();
        //if count == 0, echo NO RESULTS
        return view('pages.events', ['events' => $events, 'count' => $count]);
    }

}