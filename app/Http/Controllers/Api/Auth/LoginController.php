<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use JWTFactory;
use JWTAuth;
use App\OnlineExaminationCredential;
use App\QuestionSet;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only' => 'logout']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = array_merge($request->only('email', 'password'), ['active' => 1]);

        try {
            config()->set( 'auth.defaults.guard', 'exam' );

            if ( ! $token = JWTAuth::attempt($credentials)) {
	            return response()->json([
	                'status' => 'error',
	                'error'  => 'invalid.credentials',
	                'message'    => 'These credentials do not match our records. Please contact front-desk at PI Academy.'
	            ], 401);
		    }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user_details' => Auth::user()->only(['id', 'email', 'username', 'registration_number']),
            'sets' => $this->getSetList()
        ], 200);
    }

    private function getSetList()
    {
        $sets = QuestionSet::orderBy('order')
                            ->select('id', 'name', 'order', 'slug')
                            ->whereHas('questions')
                            ->get();

        return $sets;
    }

	public function logout(Request $request)
    {
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
}