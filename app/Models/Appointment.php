<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Table name (if different from the default 'appointments')
    protected $table = 'appointments';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'service_id',
        'admin_id',
        'status',
        'appointment_date',
        'created_at',
        'updated_at',
    ];

    // Relationships

    /**
     * Define the relationship with the User model.
     * An appointment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(App\Models\User, 'user_id');
    }

    /**
     * Define the relationship with the Service model.
     * An appointment belongs to a service.
     */
    public function service()
    {
        return $this->belongsTo(App\Models\Service, 'service_id');
    }

    /**
     * Define the relationship with the Admin model.
     * An appointment can be confirmed or managed by an admin.
     */
    public function admin()
    {
        return $this->belongsTo(App\Models\Admin, 'admin_id');
    }
}
