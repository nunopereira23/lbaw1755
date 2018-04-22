<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use Auth;

class EditProfileController extends Controller
{

  public function show($id)
  {
    if (Auth::check()){
      if (Auth::id() == $id){
        $user = User::findOrFail($id);

        return view('pages.edit_profile', ['user' => $user]);
      }
    }
  }

  public function update(Request $request, $id)
  {
    if (Auth::check()){
      $input = $request->all();

      $user= User::findOrFail($id);
      if ($id == Auth::id()){
        $user->name = $input['name'];
        $user->birthdate = $input['birthdate'];
        $user->save();
      }

      return redirect()->route('my_profile', [$user]);
    }
  }

}
