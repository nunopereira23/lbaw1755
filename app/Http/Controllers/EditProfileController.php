<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{

  public function show($id)
  {
      $user = User::findOrFail($id);

      return view('pages.edit_profile', ['user' => $user]);
  }

  public function update(Request $request, $id)
  {

    $input = $request->all();

    $user= User::findOrFail($id);
    $user->name = $input['name'];
    $user->birthdate = $input['birthdate'];
    $user->save();

    return redirect()->route('profile', [$user]);
  }

}
