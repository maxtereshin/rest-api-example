<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function generateJWT($iss, $exp = null)
    {
        $params = [
            'iss' => $iss,
            'iat' => time(),
            'sub' => $this->id,
        ];
        if($exp) {
            $params['exp'] = $exp;
        }

        return JWT::encode($params, env('APP_JWT'), 'HS256');
    }

    public function hasRole($role): bool
    {
        $role = $this->roles()->where('name', $role)->first();
        return $role != null;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
