<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 13.4.18
 * Time: 15:35
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Event;

class EventController extends Controller
{

    public function show($id)
    {
        $event = Event::find($id);
        if ($event->event_visibility == 'Public'){
          return view('pages.event', ['event' => $event]);
        }else if($event->event_visibility == 'Private'){
          $user_id = Auth::id();
          $event_status = DB::table('event_user')
                                            ->where('id_event', '=', $id)
                                            ->where('id_user', '=', $user_id)
                                            ->pluck('event_user_state');
          $status = $event_status[0];
          //echo $status;
            if ($status == ('Owner' || 'Invited' || 'Going')){
              return view('pages.event', ['event' => $event]);
            }

        }

        return abort(404);
    }

    public function showCreateForm()
    {
        return view('pages.create_event');
    }

    public function create(Request $request)
    {
        $event = new Event();

        //$this->authorize('create', $event);

        // now working only like this!
        $event->title = $request->input('title');
        $event->event_visibility = $request->input('event_visibility', 'Public');
        $event->event_type = $request->input('event_type', 'Trip');
        $event->is_deleted = $request->input('is_deleted', false);
        $event->description = $request->input('event_decription');

        $event->save();

        return redirect()->route('event', [$event]);
    }

}
