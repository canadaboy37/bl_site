<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use DB;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*
     * Create a new password controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset()
    {
        return view('auth.password');
    }

    public function username(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user)
            $data = "Your username is: " . $user->username;
        else
            $data = "Could not find email address.";

        return response()->json(['success' => true, 'status' => $data], 200);
    }

}
