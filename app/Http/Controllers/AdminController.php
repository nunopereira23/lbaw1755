<?php

namespace App\Http\Controllers;
use App\User;
use Auth;

class AdminController extends Controller
{

    public function show()
    {
        $id_auth = Auth::id();
        $loggedInUser = User::findOrFail($id_auth);
        if ($loggedInUser->is_admin == true) {
            $users = User::all();
            return view('pages.admin_users', ['users' => $users]);
        }
        else {
            return view('pages.error');
        }

    }

    public function ban()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user = User::findOrFail($_POST['id']);
            $user->is_banned = true;
            $user->save();
            echo "User is successfully banned";
        }
    }

    public function reinstate()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            $user->is_banned = false;
            $user->save();
            echo "User is successfully reinstated";
        }
    }

}