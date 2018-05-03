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
        $user = User::findOrFail($id);
        $user->reports()->save($report);

        echo "user is reported";
    }


}