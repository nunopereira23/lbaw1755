<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.profile', ['user' => $user]);
    }

    public function showFirst()
    {
        $user = User::findOrFail(1);

        return view('pages.profile', ['user' => $user]);
    }

}
