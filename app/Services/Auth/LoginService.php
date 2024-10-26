<?php

namespace App\Services\Auth;

use App\Models\User;

use Carbon\Carbon;
use Exception;

use Illuminate\Support\Facades\Auth;

class LoginService
{

    protected bool $is_admin = false;
    public function __construct(protected string $email, protected string $password)
    {

    }

    public function login(): array
    {
        try {
            $this->checkUser();
            return $this->generateToken();
        } catch (Exception $e) {
            return [
                'success' => false,
                'status' => 422,
                'message' => $e->getMessage()
            ];
        }
    }

    public function checkUser(): void
    {
        $user = User::where('email', $this->email)->first();
        if(!$user) {
            throw new Exception('User not found');
        }
        if($this->is_admin) {
            $this->checkIsAdmin($user);
        }
    }

    public function generateToken(): array
    {
        if(Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            $data = [
                'success' => true,
                'token' => $user->createToken('RestAPI', ['*'], Carbon::now()->addDay())->plainTextToken,
                'name' => $user->name,
            ];
            return $data;
        } else {
            throw new Exception('Wrong login or password');
        }
    }

    public function setIsAdmin(): void
    {
        $this->is_admin = true;
    }
    public function checkIsAdmin($user): void
    {
        if(!$user->isAdmin()) {
            throw new Exception('User is not admin');
        }
    }
}
