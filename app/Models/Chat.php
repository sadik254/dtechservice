<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    // Table name (if different from the default 'chats')
    protected $table = 'chats';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'created_at',
    ];

    // Relationships

    /**
     * Define the relationship with the User model for the sender.
     */
    // public function sender()
    // {
    //     return $this->belongsTo(App\Models\User, 'sender_id');
    // }

    /**
     * Define the relationship with the Admin model for the receiver.
     */
    // public function receiver()
    // {
    //     return $this->belongsTo(App\Models\Admin, 'receiver_id');
    // }
}
