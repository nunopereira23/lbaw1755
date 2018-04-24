<?php

namespace App\Http\Controllers;
use App\User;

class AdminController extends Controller
{

    public function show()
    {
        $users = User::all();
        return view('pages.admin_users', ['users' => $users]);
    }

}