<?php

namespace App\Actions\Auth;

use App\Models\User;
use Exception;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ResetPasswordAction
{
    public function resetPassword($jwt, $password)
    {
        $payload = (array)JWT::decode($jwt, new Key(env('APP_JWT'), 'HS256'));

        if($payload['iss'] == 'passwordreset') {
            $user = User::find($payload['sub']);
            if(!$user) {
                throw new Exception('User not found');
            }
            $user->password = bcrypt($password);
            $user->save();
            return [
                'success' => true,
                'message' => 'Password reset successfully'
            ];
        } else {
            throw new Exception('Invalid token');
        }
    }
}