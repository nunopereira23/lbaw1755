<?php

namespace App\Http\Controllers;
use App\User;
use App\Report;
use Auth;

class AdminController extends Controller
{

    public function showActiveUsers()
    {
        $activeUsers = User::all()->where('is_banned',false);
        return view('pages.admin_users', ['activeUsers' => $activeUsers]);
    }

    public function showBannedUsers()
    {
        $bannedUsers = User::all()->where('is_banned',true);
        return view('pages.admin_bannedUsers', ['bannedUsers' => $bannedUsers]);
    }

    public function showReports()
    {
        $reports = Report::all();
        return view('pages.admin_reports', ['reports' => $reports]);
    }

    public function ban()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user = User::findOrFail($_POST['id']);
            $user->is_banned = true;
            $user->save();
            $page = "banned";
            return view('pages.admin_message', ['page' => $page]);
        }
    }

    public function reinstate()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            $user->is_banned = false;
            $user->save();
            $page = "reinstated";
            return view('pages.admin_message', ['page' => $page]);
        }
    }

    public function warn()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            $user->nr_warnings += 1;
            $user->save();
            $page = "warned";
            return view('pages.admin_message', ['page' => $page]);
        }
    }

}