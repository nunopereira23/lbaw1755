<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function getSocialRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function getSocialHandle()
    {
        $user = Socialite::driver('google')->stateless()->user();

        if (User::where('email', '=', $user->email)->first() != null) {
            $checkUser = User::where('email', '=', $user->email)->first();
            Auth::login($checkUser, true);

        } else {
            $row = new User;
            $row->email = $user->email;
            $row->name = $user->name;
            //$row->password = '123456;';
            $row->save();
            Auth::login($row, true);
        }

        return view('pages.homepage');
    }

    public function storePicture()
    {
        $file = Input::file('file');
        Storage::disk('local')->put('first.jpg', $file);
    }

}
