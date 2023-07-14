<?php

namespace App\Http\Controllers\ExamAuth;

use App\Http\Controllers\Controller;
use App\OnlineExaminationCredential;
use Illuminate\Http\Request;
use App\Notifications\ExamSignUpVerificationNotification;

class EmailConfirmController extends Controller
{
    /**
     * Show the pending page.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        return view('exam-auth.confirm-page');
    }

    /**
     * Verify the email.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $client = OnlineExaminationCredential::where('verified', 0)->where('verification_token', $token)->first();
        if($client) {
            $client->update([
                    'verified' => 1,
                    'verification_token' => null,
            ]);

            return view('exam-auth.email-verified');
        }

        return view('exam-auth.email-verified');
    }

    /**
     * Verify the email.
     *
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationToken(Request $request)
    {
        $email = $request->email;
        $client = OnlineExaminationCredential::where('email', $email)->where('verified', 0)->first();
        if($client) {
            $client->notify(new ExamSignUpVerificationNotification($client));
        }

        $notification = array(
            'message'    => 'Confirmation mail has been again sent to your email. Please wait for the mail.',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}