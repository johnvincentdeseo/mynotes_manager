<?php

namespace App\Models;

// Correct import to fix image_92a3c0.png
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'gender',
    'address',
    'profile_image', 
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationship to fix image_92a77d.png
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
    
}