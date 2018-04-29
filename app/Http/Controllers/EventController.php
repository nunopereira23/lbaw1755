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
        $status = '';

        if (Auth::check()){
          $user_id = Auth::id();
          $event_status = DB::table('event_user')
                                            ->where('id_event', '=', $id)
                                            ->where('id_user', '=', $user_id)
                                            ->pluck('event_user_state');
          if (!$event_status->isEmpty())
            $status = $event_status[0];

          if ($status == '')
            $status = 'Logged';
        }

        if ($event->event_visibility == 'Public'){
          return view('pages.event', ['event' => $event,'status' => $status]);
        }else if($event->event_visibility == 'Private'){
          if ($status == ('Owner' || 'Invited' || 'Going')){
            return view('pages.event', ['event' => $event,'status' => $status]);
          }
        }

        return view('pages.error');
    }

    public function request(Request $request, $id)
    {
      if (Auth::check()){
        switch ($request->type) {
          case 'AcceptEvent':
            $user_id = Auth::id();
            $event_status = DB::table('event_user')
                                              ->where('id_event', '=', $id)
                                              ->where('id_user', '=', $user_id)
                                              ->pluck('event_user_state');
            if ($event_status->isEmpty())
            {
              DB::table('event_user')->insert(['id_event'=>$request->event_id,
                                              'id_user'=>$user_id,
                                              'event_user_state'=>'Going']);

            }else if (!$event_status->isEmpty()){

              if ($event_status[0] == 'Going')
              {
                DB::table('event_user')->where('id_event','=',$request->event_id)
                                       ->where('id_user','=',$user_id)
                                       ->where('event_user_state','=','Going')->delete();
              }
            }

            return redirect()->route('event', ['id' => $request->event_id]);

            break;

          default:

            break;
        }
      }
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
