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

}