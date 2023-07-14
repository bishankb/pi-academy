<?php

namespace App\Http\Controllers\ExamAuth;

use App\OnlineExaminationCredential;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\ExamSignUpVerificationNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('exam-auth.register');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:exam');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return false;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validate(
            $request,
            [
                'username'      => 'required|string|min:2|max:255',
                'email'         => 'required|string|email|max:255|unique:online_examination_credentials,email,NULL,id,deleted_at,NULL',
                'password'      => 'required|string|min:6|confirmed'
            ]
        );

        $client = OnlineExaminationCredential::create(
            [
                'username' => request('username'),
                'email'    => request('email'),
                'password' => Hash::make(request('password')),
                'verification_token' => base64_encode(request('email').'exam'),
                'is_client' => 1,
                'active' => 1
            ]
        );

        $client->notify(new ExamSignUpVerificationNotification($client));

        return $this->registered($request, $client)
                        ?: redirect('/confirm-email?email='.$client->email);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return false;
    }
}
