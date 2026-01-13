<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Custom primary key
     */
    protected $primaryKey = 'user_id';

    /**
     * Auto-incrementing BIGINT primary key
     */
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Mass assignable columns (match your DB)
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'depart_id',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* -----------------------
     | Relationships
     |------------------------
     */

    public function department()
    {
         return $this->belongsTo(Department::class, 'depart_id', 'depart_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'user_id');
    }

    public function approvalsMade()
    {
        return $this->hasMany(Approval::class, 'admin_user_id', 'user_id');
    }

    /* -----------------------
     | Helpers
     |------------------------
     */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
