<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VetContact extends Model
{
    use HasFactory;

    protected $table = 'vet_contacts';

    protected $fillable = [
        'id',
        'name',
        'phone_number',
    ];

    public $incrementing = false; // 👈 Prevent auto-incrementing since it's a UUID
    protected $keyType = 'string'; // 👈 Define primary key as a string

    protected static function boot()
    {
        parent::boot();

        // Generate UUID automatically on creation
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(VetContact::class, 'branch_id');
    }
}
