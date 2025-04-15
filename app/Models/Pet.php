<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = ['id', 'owner_id', 'name', 'weight', 'species', 'breed', 'bday', 'gender', 'special_char', 'profile_pic'];

    protected $primaryKey = 'id'; // Specify the primary key
    public $incrementing = false; // Set to false since you are using a string ID
    protected $keyType = 'string'; // Specify that the key type is a string

    public function owner()
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'pet_id', 'id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'pet_id', 'id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccinations::class, 'pet_id');
    }
}
