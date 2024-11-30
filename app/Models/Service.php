<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Table name (if different from the default 'services')
    protected $table = 'services';

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'created_at',
        'updated_at',
    ];

    // Relationships

    /**
     * Define the relationship with the Appointment model.
     * One service can be associated with many appointments.
     */
    public function appointments()
    {
        return $this->hasMany(App\Models\Appointment, 'service_id');
    }
}
