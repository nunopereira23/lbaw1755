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

        if ($event->is_deleted == true)
        {
          $error_type = 'Event_Canceled';
          return view('pages.error',['error_type'=>$error_type]);
        }

        $event_owner = DB::table('users')
            ->select('users.id', 'users.name')
            ->join('event_user', 'event_user.id_user', '=', 'users.id')
            ->where('event_user.id_event',$id)
            ->where('event_user.event_user_state','=','Owner')
            ->get();

        $users_going = DB::table('users')
            ->select('users.id', 'users.name')
            ->join('event_user', 'event_user.id_user', '=', 'users.id')
            ->where('event_user.id_event',$id)
            ->where('event_user.event_user_state','=','Going')
            ->get();

        $going = array_merge(json_decode($event_owner),json_decode($users_going));


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
          return view('pages.event', ['event' => $event,'status' => $status,'going' =>$going]);
        }else if($event->event_visibility == 'Private'){
          if ($status == ('Owner' || 'Invited' || 'Going')){
            return view('pages.event', ['event' => $event,'status' => $status,'going' =>$going]);
          }
        }

        return view('pages.error');
    }

    public function request(Request $request, $id)
    {
      if (Auth::check()){
        $user_id = Auth::id();
        $event_status = DB::table('event_user')
                                          ->where('id_event', '=', $id)
                                          ->where('id_user', '=', $user_id)
                                          ->pluck('event_user_state');
        switch ($request->type) {

          case 'AcceptEvent':

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

          case 'IgnoreEvent':

              if ($event_status->isEmpty())
              {
                DB::table('event_user')->insert(['id_event'=>$request->event_id,
                                                'id_user'=>$user_id,
                                                'event_user_state'=>'Ignoring']);

              }else if (!$event_status->isEmpty()){

                if ($event_status[0] == 'Ignoring')
                {
                  DB::table('event_user')->where('id_event','=',$request->event_id)
                                         ->where('id_user','=',$user_id)
                                         ->where('event_user_state','=','Ignoring')->delete();
                }
              }

              return redirect()->route('event', ['id' => $request->event_id]);

            break;

            case 'CancelEvent':
              if (Auth::check()){

                $event= Event::findOrFail($id);
                if ($event_status[0] == 'Owner'){
                  $event->is_deleted = 'true';
                  $event->save();
                }

                return redirect()->route('event', ['id' => $request->event_id]);
              }

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
