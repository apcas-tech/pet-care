<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // Allow mass assignment for the following fields
    protected $fillable = ['id', 'pet_id', 'owner_id', 'service_id', 'branch_id', 'appt_date', 'appt_time', 'status', 'notes'];

    protected $primaryKey = 'id'; // Use the string ID as the primary key
    public $incrementing = false; // Set to false since the ID is a string
    protected $keyType = 'string'; // Specify that the key is a string

    // Define relationships
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(VetContact::class, 'branch_id', 'id');
    }
}
