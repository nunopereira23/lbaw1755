<?php

namespace App\Http\Controllers;
use App\User;
use App\Report;
use Auth;

class AdminController extends Controller
{

    public function show()
    {
        $id_auth = Auth::id();
        $loggedInUser = User::findOrFail($id_auth);
        if ($loggedInUser->is_admin == true) {
            $activeUsers = User::all()->where('is_banned',false);
            $bannedUsers = User::all()->where('is_banned',true);
            $reports = Report::all();
            return view('pages.admin_users', ['users' => $activeUsers, 'bannedUsers' => $bannedUsers,  'reports' => $reports]);
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