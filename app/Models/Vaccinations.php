<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Vaccinations extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'pet_id', 'pet_type', 'vaccine_name', 'date_administered', 'next_due_date', 'administered_by', 'notes'];

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vaccination) {
            if (empty($vaccination->id)) {
                $vaccination->id = (string) Str::uuid();
            }
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
        return $this->belongsTo(Admin::class, 'administered_by', 'id');
    }
}
