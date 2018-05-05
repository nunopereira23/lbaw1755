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
use Session;

use App\Event;

class EventController extends Controller
{

    public function show($id)
    {
        $event = Event::find($id);
        $status = '';

        if (!isset($event))
        {
          $error_type = 'Event_Not_Found';
          return view('pages.error',['error_type'=>$error_type]);
        }

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


        $users_canBeInvited = DB::table("users")
            ->select('id','name')
            ->whereNotIn('id',function($query) use(&$id) {
              $query->select('id_user')
                    ->from('event_user')
                    ->where('id_event','=',$id);
            })->get();

        $users_canBeInvited = json_decode($users_canBeInvited);

        $going = array_merge(json_decode($event_owner),json_decode($users_going));


        if (Auth::check()){
          $user_id = Auth::id();
          $i = 0;
          foreach($users_canBeInvited as $user_tbi)//user can't invite himself
          {
            if ($user_tbi->id == $user_id){
               unset($users_canBeInvited[$i]);
            }
            $i++;
          }

          $event_status = DB::table('event_user')
		                        ->where('id_event', '=', $id)
		                        ->where('id_user', '=', $user_id)
		                        ->pluck('event_user_state');
          $event_invited = DB::table('event_user')
		                        ->where('id_event', '=', $id)
		                        ->where('id_user', '=', $user_id)
		                        ->pluck('is_invited');
          $invited = false;

          if (!$event_invited->isEmpty())
            $invited = $event_invited[0];

          if ($status == '')
            $status = 'Logged';

          if (!$event_status->isEmpty())
            $status = $event_status[0];
        }


        if ($event->event_visibility == 'Public'){
          return view('pages.event', ['event' => $event,'status' => $status,'going' => $going,'canBeInvited' => $users_canBeInvited]);
        }else if($event->event_visibility == 'Private'){
          if (($status == 'Owner')  || ($status == 'Going') || ($invited == true) ){
            return view('pages.event', ['event' => $event,'status' => $status,'going' =>$going,'canBeInvited' => $users_canBeInvited]);
          }
        }

        $error_type = 'Event_No_Permission';
        return view('pages.error',['error_type'=>$error_type]);
    }

    public function request(Request $request, $id)
    {
      if (Auth::check()){
        $user_id = Auth::id();
        $event_status = DB::table('event_user')
                          ->where('id_event', '=', $id)
                          ->where('id_user', '=', $user_id)
                          ->pluck('event_user_state');

        $invited_status = DB::table('event_user')
		                      ->where('id_event', '=', $id)
		                      ->where('id_user', '=', $user_id)
		                      ->pluck('is_invited');


        switch ($request->type) {

          case 'AcceptEvent':

            $response = 'noAction';

            if ($event_status->isEmpty())
            {
              DB::table('event_user')->insert(['id_event'=>$request->event_id,
                  'id_user'=>$user_id,
                  'event_user_state'=>'Going',
                  'is_invited' => false]);
              $response = 'AcceptSuccess';

            }else if (!$event_status->isEmpty()){

              if ($event_status[0] == 'Deciding'){
                DB::table('event_user')->where('id_event','=',$request->event_id)
                   ->where('id_user','=',$user_id)
                   ->update(['event_user_state' => 'Going']);
                   $response = 'InviteAcceptSuccess';
              }

              if ($event_status[0] == 'Going')
              {
                if ($invited_status[0] == false){
                  DB::table('event_user')->where('id_event','=',$request->event_id)
		             ->where('id_user','=',$user_id)
		             ->where('event_user_state','=','Going')->delete();
                  $response = 'UnacceptSuccess';
                } elseif ($invited_status[0] == true) {
                  DB::table('event_user')->where('id_event','=',$request->event_id)
                     ->where('id_user','=',$user_id)
                     ->update(['event_user_state' => 'Deciding']);
                  $response = 'InviteUnacceptSuccess';
                }
              }


            }

            return response()->json($response);

          break;

          case 'IgnoreEvent':

            $response = 'noAction';

            if ($event_status->isEmpty())
            {
              DB::table('event_user')->insert(['id_event'=>$request->event_id,
                  'id_user'=>$user_id,
                  'event_user_state'=>'Ignoring',
                  'is_invited' => false]);
              $response = 'IgnoreSuccess';
            }else if (!$event_status->isEmpty()){

              if ($event_status[0] == 'Deciding'){
                DB::table('event_user')->where('id_event','=',$request->event_id)
                   ->where('id_user','=',$user_id)
                   ->update(['event_user_state' => 'Ignoring']);
                $response = 'InviteIgnoreSuccess';
              }

              if ($event_status[0] == 'Ignoring')
              {
                if ($invited_status[0] == false){
                  DB::table('event_user')->where('id_event','=',$request->event_id)
                     ->where('id_user','=',$user_id)
                     ->where('event_user_state','=','Ignoring')->delete();
                  $response = 'UnignoringSuccess';
                } elseif ($invited_status[0] == true) {
                  DB::table('event_user')->where('id_event','=',$request->event_id)
		             ->where('id_user','=',$user_id)
		             ->update(['event_user_state' => 'Deciding']);
                  $response = 'InviteUnignoringSuccess';
                }
              }


            }

            return response()->json($response);

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

            case 'ShareEvent':
              $response = 'noInvite';

              $invited = $request->invited;
              if (count($invited) > 0){
                $response = 'Invited';
                foreach ($invited as $invited_id) {
                    DB::table('event_user')->insert(['id_event'=>$request->event_id,
                                                    'id_user'=>$invited_id,
                                                    'event_user_state'=>'Deciding',
                                                    'is_invited'=>true]);
                }
              }

              return response()->json($response);
            break;

          default:

            break;
        }
      }
    }

    public function showCreateForm()
    {
        if (!Auth::check()) {
            return abort(404);
        }
        return view('pages.create_event');
    }

    public function create(Request $request)
    {
        $event = new Event();
        $user_event = new EventUser();

        if (Auth::check()) {
            $user_event->id_user = Auth::id();
            $user_event->event_user_state = "Owner";

            $event->title = $request->input('title');
            $event->event_visibility = $request->input('event_visibility');
            $event->event_type = $request->input('event_type');
            $event->is_deleted = $request->input('is_deleted', false);
            $event->description = $request->input('event_description');

            $date_start = date_format(new DateTime($request->input('date_start')), 'Y-m-d');
            $time_start = date_format(new DateTime($request->input('time_start')), 'h:i:s');
            $event->event_start = $date_start . " " . $time_start;

            $date_end = date_format(new DateTime($request->input('date_end')), 'Y-m-d');
            $time_end = date_format(new DateTime($request->input('time_end')), 'h:i:s');
            $event->event_end = $date_end . " " . $time_end;

            if (isset($_GET['gps'])) {
                $event->gps = $_GET['gps'];
            }
        }
        $event->save();
        $user_event->id_event = $event->id;

        $user_event->save();

        return redirect()->route('event', [$event]);
    }

    public function showEditForm($id)
    {
        if (!Auth::check()) {
            return abort(404);
        }
        $event = Event::findOrFail($id);

        return view('pages.edit_event', ['event' => $event]);
    }

    public function edit(Request $request, $id)
    {
        $event = new Event();

        return redirect()->route('event', [$event]);

    }

}
