<?php

namespace App\Http\Controllers;


class HomepageController extends Controller
{

    public function show()
    {
        return view('pages.homepage');
    }

}
