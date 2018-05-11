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
            $user = User::find($_POST['id']);
            if ($user == null) {
                return view('pages.user_404');
            }
            $user->is_banned = true;
            if($user->save()) {
                $page = "banned";
                return view('pages.admin_message', ['page' => $page]);
            }
            return view('pages.server_error');
        }
    }

    public function reinstate()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            if ($user == null) {
                return view('pages.user_404');
            }
            $user->is_banned = false;
            if($user->save()) {
                $page = "reinstated";
                return view('pages.admin_message', ['page' => $page]);
            }
            return view('pages.server_error');
        }
    }

    public function warn()
    {
        if ($_POST['action'] && $_POST['id']) {
            $user= User::findOrFail($_POST['id']);
            if ($user == null) {
                return view('pages.user_404');
            }
            $user->nr_warnings += 1;
            if($user->save()) {
                $page = "warned";
                return view('pages.admin_message', ['page' => $page]);
            }
            return view('pages.server_error');
        }
    }

}