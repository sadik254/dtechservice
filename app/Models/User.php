<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

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
        return $this->hasMany(App\Models\Appointment, 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(App\Models\Chat, 'sender_id');
    }
}
