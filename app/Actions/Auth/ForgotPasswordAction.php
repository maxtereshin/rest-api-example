<?php

namespace App\Actions\Auth;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAction
{

    public function sendEmail($email) {
        $email = trim(strtolower($email));
        $user = User::where('email', $email)->first();
        if(!$user) {
            throw new Exception('User not found');
        }
        Mail::to($user->email)->send(new ForgotPasswordMail($user));
        return [
            'success' => true,
            'message' => 'Email sent successfully'
        ];
    }
}