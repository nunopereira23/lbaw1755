<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\PasswordEmailSender;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * It should redirect to the user profile
     *
     * @var string
     */
    protected $redirectTo = '/my_profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request)
    {
        if (Auth::user()->is_banned == 1) {
            $message = 'This account has been blocked, please contact us for more information @ RealLexi.com';
            Auth::logout($request);
            Session::flash('Error', $message);
            return View::make('auth.login')->withMessage($message);
        }
    }

    public function showEmailForm()
    {
        return view('pages.password_email');
    }

    public function resetPasswordPage()
    {
      $error_type = 'Generate_Code';
      return view('pages.error', ['error_type' => $error_type]);
    }

    public function sendResetPasswordCode(Request $request, \Illuminate\Mail\Mailer $mailer)
    {
      $user = User::where('email', '=', $request->input('email'))->first();
      if (isset($user))
      {
        $code = str_random(15);

        $user->confirmation_code = $code;
        $user->save();

        $mailer->to($request->input('email'))->send(new PasswordEmailSender($code));

        return view('pages.email_sended', ['email' => $user->email]);
      } else{
        $error_type = 'Email_Not_Found';
        return view('pages.error', ['error_type' => $error_type]);
      }
    }

    public function confirmPasswordPage(){
      return view('pages.error');
    }

    public function confirmNewPassword(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();

        if ($request->input('code') == $user->confirmation_code) {
            $user->password = bcrypt($request->input('password'));
            $user->save();

            $message = 'The password has been successfully changed.';
            Session::flash('Success', $message);

            return redirect()->route('login');
        }
        $error_type = 'Wrong_Confirmation_Code';

        return view('pages.error', ['error_type' => $error_type]);
    }

}
