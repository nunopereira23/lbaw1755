<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\User;
use App\Report;
use Auth;

class ReportController extends Controller
{
    public function report($id, Request $request)
    {
        $report = new Report();
        $report->description = $request->input('description');
        $user = User::find($id);
        if ($user == null) {
            return view('pages.user_404');
        }
        else {
            if ($user->reports()->save($report)) {
                $page = "reported";
                return view('pages.admin_message', ['page' => $page]);
            }
            return view('pages.server_error');
        }

    }


}