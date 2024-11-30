<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    // Your existing relationships
    public function chats()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'admin_id');
    }
}