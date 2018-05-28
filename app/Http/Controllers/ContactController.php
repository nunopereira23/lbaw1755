<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 13.4.18
 * Time: 13:06
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;


class ContactController extends Controller
{

    public function show()
    {
        return view('pages.contact');
    }



    public function request(Request $request){

      if($request != null)
      {
        $admin = DB::table('users')
            ->select('users.name','users.email')
            ->where('is_admin', '=', true)
            ->first();

        $toSend = ['name'=>$request->name,'email'=>$request->email,
        'phonenumber'=>$request->phoneNumber,'comment'=>$request->comment];

        Mail::send('emails.contact',$toSend, function($message) use (&$admin) {
           $message->to($admin->email, $admin->name)->subject
              ('Feedback on IAmIn');
           $message->from('iaminwebsite@gmail.com','IAmInWebsite');
        });

        $response = "Submited";
        return response()->json($response);
      }

      $response = "NotSubmited";
      return response()->json($response);
    }




}
