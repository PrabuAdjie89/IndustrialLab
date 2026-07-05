<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable //implements MustVerifyEmail // <-- WAJIB
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isAsisten()
    {
        return $this->role === 'asisten';
    }

    public function isLaboran()
    {
        return $this->role === 'laboran';
    }

    public function isKalab()
    {
        return $this->role === 'kalab';
    }
    public function isKaprodi()
    {
        return $this->role === 'kaprodi';
    }

}
