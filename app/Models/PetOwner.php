<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class PetOwner extends Authenticatable implements JWTSubject
{
    protected $fillable = ['id', 'google_id', 'Fname', 'Lname', 'Mname', 'email', 'phone', 'address', 'password', 'no_pets', 'verified_at', 'profile_pic'];

    protected $keyType = 'string';
    public $incrementing = false;

    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'owner_id', 'id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
