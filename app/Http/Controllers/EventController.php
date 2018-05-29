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
use DateTime;
use Auth;
use Session;

use App\Event;
use App\EventUser;


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


        $comments = DB::table('comments')
            ->select('comments.id','users.id AS user_id','users.name','comments.comment_content','comments.date','comments.id_event')
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->where('comments.id_event',$id)
            ->where('comments.replyto',0)
            ->orderBy('comments.date','DESC')
            ->get();

        $replies = DB::table('comments')
            ->select('comments.id','users.id AS user_id','users.name','comments.comment_content','comments.date','comments.id_event','comments.replyto')
            ->join('users', 'users.id', '=', 'comments.id_user')
            ->where('comments.id_event',$id)
            ->where('comments.replyto',"!=",0)
            ->orderBy('comments.date','ASC')
            ->get();

        $polls = DB::table('polls')
            ->select('polls.id','users.id AS user_id','users.name','polls.question', 'polls.id_event')
            ->join('users', 'users.id', '=', 'polls.id_user')
            ->where('polls.id_event',$id)
            ->orderBy('polls.id', 'ASC')
            ->get();

        $answers = DB::table('answers')
            ->select('answers.id','users.id AS user_id','users.name','answers.answer', 'answers.id_poll')
            ->join('answer_user', 'answer_user.id_answer', '=', 'answers.id' )
            ->join('users',  'users.id', '=', 'answer_user.id_user' )
            ->join('polls',  'polls.id', '=', 'answers.id_poll' )
            ->where('polls.id_event',$id)
            ->get();

        $invited = false;

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


          if (!$event_invited->isEmpty())
            $invited = $event_invited[0];

          if ($status == '')
            $status = 'Logged';

          if (!$event_status->isEmpty())
            $status = $event_status[0];
        }


        if ($event->event_visibility == 'Public'){
          if (Auth::check())
            return view('pages.event', ['user_id'=> Auth::id(),'event' => $event,'status' => $status,'going' => $going,'canBeInvited' => $users_canBeInvited,'comments' => $comments,'replies' => $replies, 'polls' => $polls, 'answers' => $answers]);
            else {
              return view('pages.event', ['event' => $event,'status' => $status,'going' => $going,'canBeInvited' => $users_canBeInvited,'comments' => $comments,'replies' => $replies, 'polls' => $polls, 'answers' => $answers]);
            }
        }else if($event->event_visibility == 'Private'){
          if (($status == 'Owner')  || ($status == 'Going') || ($invited == true) ){
            return view('pages.event', ['user_id'=> Auth::id(),'event' => $event,'status' => $status,'going' => $going,'canBeInvited' => $users_canBeInvited,'comments' => $comments,'replies' => $replies, 'polls' => $polls, 'answers' => $answers]);
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

            case 'SubmitComment':
              $response = 'noComment';

              if (Auth::check()){

                DB::table('comments')->insert(['id_event'=>$request->event_id,
                                                'id_user'=>Auth::id(),
                                                'comment_content'=>$request->comment_content,
                                                'replyto'=>$request->replyto,
                                                'date'=> date('Y-m-d H:i:s')]);
                $response = 'newComment';
              }
              return response()->json($response);

            break;

            case 'DeleteComment':
              $response = 'noDelete';

              if (Auth::check()){

                DB::table('comments')->where('id','=',$request->comment_id)
                                     ->update(['comment_content' => ' Comment deleted']);

                $response = 'commentDeleted';
              }
              return response()->json($response);

            break;

            case 'SubmitPoll':
                $response = 'noPoll';

                if (Auth::check()){

                    DB::table('polls')->insert(['id_event'=>$request->event_id,
                        'id_user'=>Auth::id(),
                        'question'=>$request->question,
                      ]);
                    $response = 'newPoll';
                }
                return response()->json($response);

                break;


            case 'SubmitPollAnswer':
                $response = 'noAnswer';

                if (Auth::check()){

                    DB::table('answers')->insert(['id_poll'=>$request->id_poll,
                        'answer'=>$request->pollAnswer,
                    ]);

                    DB::table('answer_user')->insert(['id_answer'=>$request->id_answer,
                        'id_user'=>Auth::id(),
                    ]);


                    $response = 'newAnswer';
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

            $event->gps = $request->input('gps');
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

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (Auth::check()) {
            if ($_POST['submitted'] == "Cancel") {
                return redirect()->route('event', [$event]);
            }

            $event->title = $request->input('title');
            $event->event_visibility = $request->input('event_visibility');
            $event->event_type = $request->input('event_type');
            $event->gps = $request->input('gps');
            $event->description = $request->input('event_description');

            $date_start = date_format(new DateTime($request->input('date_start')), 'Y-m-d');
            $time_start = date_format(new DateTime($request->input('time_start')), 'h:i:s');
            $event->event_start = $date_start . " " . $time_start;

            $date_end = date_format(new DateTime($request->input('date_end')), 'Y-m-d');
            $time_end = date_format(new DateTime($request->input('time_end')), 'h:i:s');
            $event->event_end = $date_end . " " . $time_end;
        }
        $event->save();

        return redirect()->route('event', [$event]);
    }

}
