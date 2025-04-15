<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptablePet extends Model
{
    use HasFactory;

    protected $table = 'adoptable_pets';

    protected $primaryKey = 'id'; // Ensure Laravel knows 'id' is the primary key
    public $incrementing = false; // Prevent Laravel from treating it as an auto-increment integer
    protected $keyType = 'string'; // Ensure ID is treated as a string

    protected $fillable = [
        'id',
        'name',
        'gender',
        'species',
        'breed',
        'weight',
        'bday',
        'remarks',
        'profile_pic',
    ];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'pet_id', 'id');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccinations::class, 'pet_id', 'id');
    }
}
