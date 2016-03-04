<?php
/**
 * Created by PhpStorm.
 * User: steve
 * Date: 8/5/2015
 * Time: 8:24 AM
 */

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Hash;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $account = $user->account;

        return view('settings.index', compact('user', 'account'));
    }

    protected function validator(array $data)
    {
        $messages = array(
            'password.regex' => 'Your new password must contain at least one number and one special character.',
        );

        return Validator::make($data, [
            'newPassword' => 'required|min:7|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*()-+]).*$/',
        ], $messages);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $validator = $this->validator($_REQUEST);
        if ($validator->fails()) {
            $data = "validation";
            return response()->json([ 'success' => true, 'status' => $data], 200);
        }

        if (Hash::check($request->currentPassword, $user->password))
        {
            $user->password = bcrypt($request->newPassword);
            $user->save();
            $data = "changed";
        } else {
            $data = "error";
        }

        return response()->json([ 'success' => true, 'status' => $data], 200);
    }

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        /*if ($request->newPassword)
        {
            if (Auth::user()->password == $request->currentPassword)
            {

            }
        }*/

        try
        {
            $user->save();
            $data = "success";
        }
        catch (\PDOException $e)
        {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062)
            {
                $data = "error";
            }
        }
        //header('Content-type: application/json');

        return response()->json([ 'success' => true, 'status' => $data], 200);
    }
}