<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;
use App\Models\Admin;

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
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with the Service model.
     * An appointment belongs to a service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Define the relationship with the Admin model.
     * An appointment can be confirmed or managed by an admin.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
