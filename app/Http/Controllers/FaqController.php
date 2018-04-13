<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 13.4.18
 * Time: 13:42
 */

namespace App\Http\Controllers;


class FaqController extends Controller
{

    public function show()
    {
        return view('pages.faq');
    }

}