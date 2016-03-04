<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
use DB;
use Illuminate\Contracts\Auth\Guard;
use App\Traits\CaptchaTrait;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\Account;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins, CaptchaTrait;

    /*
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->auth  = $auth;
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required', 'password' => 'required']);

        $username = $request->input('email');
        $pass = $request->input('password');

        $user = User::where('username', '=', $username)->first();

        if ($user != null && $user->dealer_id == Session::get('dealerId') && $this->auth->attempt(['username' => $username, 'password' => $pass]))
        {
            return redirect('account');
        }

        return redirect()->back()->withErrors('Invalid username/password.')->withInput();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = array(
            'password.regex' => 'Your password must be at least seven characters long, and contain at least one number and one special character.',
        );

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|max:12',
            'username' => 'required|min:6|max:255|unique:users',
            'password' => 'required|confirmed|min:7|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!@$#%^&*()-+]).*$/',
            'g-recaptcha-response' => 'required',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        // Find or create the account
        $account = Account::firstOrNew([
            'dealer_id' => Session::get('dealerId'),
            'name' => $data['inetpro_username'],
            'code' => $data['inetpro_account'],
            'password' => 'builderlinksn'
        ]);
        $account->save();


        // Create the user
        $user = new User();
        $user->dealer_id = Session::get('dealerId');
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->username = $data['username'];
        $user->password = bcrypt($data['password']);

        // Link the user to their account
        $account->users()->save($user);

        return $user;
    }

    protected $redirectPath = '/settings';

    protected $loginPath = '/login';

    /**
     * Custom registration handler to attach created user accounts to their appropriate dealer and iNet Pro account
     */

    public function postRegister()
    {

        $input = $_REQUEST;
        $validator = $this->validator($input);
        if ($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator);
        }

        if ($this->captchaCheck() == false)
        {
            return redirect()->back()
                ->withErrors(['Wrong Captcha']);
        }

        /**
         * Run check to see if iNet Pro account is included
         */
        $inetProUser = $input['inetpro_username'];
        $inetProAccount = $input['inetpro_account'];

        $accountInfo = DB::table('accounts')
            ->where('dealer_id', Session::get('dealerId'))
            ->where('name', $inetProUser)
            ->where('code', $inetProAccount)
            ->first();

        if (!$accountInfo)
        {
            return redirect()->back()
                ->withErrors(['iNetPro account does not match']);
        }


        $this->create($input);

        return redirect('/')
            ->with('message', 'Registration successful.  Please login.');
    }

}
