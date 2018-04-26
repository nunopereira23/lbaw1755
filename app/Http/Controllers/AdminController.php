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

    public function banUser()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            if ($_POST['action'] == 'Ban') {
                $user->is_banned = true;
                $user->save();
                echo "User is successfully banned";
            }
            if ($_POST['action'] == 'Unban') {
                $user->is_banned = false;
                $user->save();
                echo "User is successfully unbanned";
            }
        }

    }

}