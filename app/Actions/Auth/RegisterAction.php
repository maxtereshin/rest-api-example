<?php

namespace App\Actions\Auth;

use App\Models\Role;
use App\Models\User;

class RegisterAction
{

    public function handle($email, $password, $name)
    {
        $user = User::create([
            'name' => $name,
            'email' => trim(strtolower($email)),
            'password' => bcrypt($password),
        ]);
        $role = Role::where('name', 'user')->first();
        $user->roles()->attach($role);
        return [
            'id' => $user->id,
            "name" => $user->name,
            "email" => $user->email
        ];
    }
}