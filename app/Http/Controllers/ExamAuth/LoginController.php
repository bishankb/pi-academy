<?php

namespace App\Http\Controllers\ExamAuth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function authenticated(Request $request, $client)
    {
        if($client->verified == false) {
            \Auth::guard('exam')->logout();
            return redirect('/confirm-email?old_user=yes&email='.$client->email)
                ->with('error_login', 'You have not verified your account.');
        } else {
            return redirect(route('exam.home'));
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:exam')->except('logout');
    }


    public function showLoginForm()
    {
        
        return view('exam-auth.login');    
    }

    protected function guard()
    {
        return Auth::guard('exam');
    }

    public function logout(Request $request) {
        Auth::guard('exam')->logout();
        return redirect(route('exam.login'));
    }

    /**
     * Overwriting the core function
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['active' => 1]);
    }
}
