<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class SignInController extends Controller
{

    public function show()
    {
        return view('auth.signIn');
    }

}