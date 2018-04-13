<?php
/**
 * Created by PhpStorm.
 * User: michaela
 * Date: 13.4.18
 * Time: 13:06
 */

namespace App\Http\Controllers;


class ContactController extends Controller
{

    public function show()
    {
        return view('pages.contact');
    }

}