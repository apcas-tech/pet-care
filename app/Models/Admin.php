<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'admin_users';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'Fname',
        'Mname',
        'Lname',
        'email',
        'password',
        'role',
        'capabilities',
        'pages',
        'profile_pic',
        'branch_id',
    ];

    protected $casts = [
        'capabilities' => 'array',
        'pages' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid()->toString();
        });
    }

    public function branch()
    {
        return $this->belongsTo(VetContact::class, 'branch_id');
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
