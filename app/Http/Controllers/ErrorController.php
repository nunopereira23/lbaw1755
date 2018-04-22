<?php
/**
 * Created by PhpStorm.
 * User: nunopereira23
 * Date: 18.4.18
 * Time: 13:06
 */

namespace App\Http\Controllers;


class ErrorController extends Controller
{

    public function show()
    {
        return view('pages.error');
    }

}
