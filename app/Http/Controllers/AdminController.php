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
            $activeUsers = User::all()->where('is_banned',false);
            $bannedUsers = User::all()->where('is_banned',true);
            $reports = Report::all();
            return view('pages.admin_users', ['activeUsers' => $activeUsers, 'bannedUsers' => $bannedUsers,  'reports' => $reports]);
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

    public function warn()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            $user->nr_warnings += 1;
            $user->save();
            echo "User is successfully warned";
        }
    }

}