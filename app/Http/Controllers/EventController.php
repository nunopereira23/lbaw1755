<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 13.4.18
 * Time: 15:35
 */

namespace App\Http\Controllers;


use App\Event;

class EventController extends Controller
{

    public function show($id)
    {
        $event = Event::find($id);

        return view('pages.event', ['event' => $event]);
    }

}