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
use Auth;
use App\User;

class MyEventsController extends Controller
{

    public function show($id)
    {
        $id_auth = Auth::id();
        if ($id == $id_auth) {
            $loggedInUser = User::findOrFail($id_auth);
            return view('pages.my_events', ['user' => $loggedInUser]);
        }
        return view('pages.error');
    }

}