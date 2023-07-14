<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use JWTFactory;
use JWTAuth;
use App\ExaminationQuestion;
use App\QuestionSet;

class UserController extends Controller
{
    public function getAuthUser(Request $request)
    {
        try {
            if (!$user = JWTAuth::toUser($request->token)) {
                return response()->json([
                    'status'  => 'error',
                    'error'   => 'invalid.credentials',
                    'message' => 'User Not Found'
                ], 404);
            } else {
                $user = JWTAuth::toUser($request->token)->only(['id', 'email', 'username', 'registration_number']);

                return response()->json([
                    'status'       => 'success',
                    'user_details' => $user,
                    'sets'         => $this->getSetList()                   
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    private function getSetList()
    {
        $sets = QuestionSet::orderBy('order')
                            ->select('id', 'name', 'order', 'slug')
                            ->whereHas('questions')
                            ->get();

        return $sets;
    }
}