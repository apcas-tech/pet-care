<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'verifications';

    // The primary key for the model (optional if using default 'id')
    protected $primaryKey = 'id';

    // Set the attributes that are mass assignable
    protected $fillable = ['token', 'user_id'];

    // Set the attributes that are not mass assignable (optional)
    // protected $guarded = [];

    // Define the relationship with the PetOwner model (User)
    public function petOwner()
    {
        return $this->belongsTo(PetOwner::class, 'user_id', 'id');
    }

    // Define the timestamps if needed (Laravel does this by default)
    public $timestamps = true;
}
