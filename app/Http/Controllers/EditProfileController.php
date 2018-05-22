<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
      }else {
        return abort(404);
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
        if ($request->hasFile('image')) {
            echo "file";
            $file = $request->file('image');
            Storage::disk('public')->putFile('images/user', $file);
            $user->profile_picture_path = 'storage/images/user/'.$file->hashName();
        }
        $user->save();
      }

      return redirect()->route('my_profile', [$user]);
    }
  }

}
