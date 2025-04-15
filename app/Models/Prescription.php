<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prescription extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'pet_id', 'pet_type', 'vet_id', 'description', 'tx_given', 'prescription', 'record_date'];
    protected $casts = [
        'prescription' => 'array', // Convert JSON field to array automatically
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid(); // Generate UUID for ID
        });
    }

    public function pet()
    {
        if ($this->pet_type === 'Pet') {
            return $this->belongsTo(Pet::class);
        } elseif ($this->pet_type === 'AdoptablePet') {
            return $this->belongsTo(AdoptablePet::class, 'pet_id', 'id');
        }
        return null; // This should not happen if pet_type is validated correctly
    }

    public function veterinarian()
    {
        return $this->belongsTo(Admin::class, 'vet_id', 'id');
    }
}
