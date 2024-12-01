<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Appointment;
use App\Models\Chat;

class User extends Model
{
    use HasFactory, HasApiTokens; // Add the HasApiTokens trait

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'created_at', 'updated_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }
}
