<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;

use App\User;

class ProfileController extends Controller
{

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.profile', ['user' => $user]);
    }


    public function showLoggedInUserProfile()
    {
        //$id = Auth::id();
        $user = User::findOrFail(1);

        return view('pages.profile', ['user' => $user]);
    }


}
