<?php

namespace App\Http\Controllers;


use App\User;
use Auth;

class ProfileController extends Controller
{

    public function show($id)
    {
        $id_auth = Auth::id();

        $user = User::findOrFail($id);

        return view('pages.profile', ['user' => $user,'id_auth'=>$id_auth]);
    }

    public function showLoggedInUser()
    {
        $id_auth = Auth::id();

        $user = User::findOrFail($id_auth);

        return view('pages.profile', ['user' => $user,'id_auth'=>$id_auth]);
    }



}
