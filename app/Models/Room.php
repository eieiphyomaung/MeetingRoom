<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'room_id';

    protected $fillable = ['room_name', 'room_type', 'capacity', 'floor', 'equipment', 'is_active'];

    protected $casts = [
        'equipment' => 'array',
        'is_active' => 'boolean',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id', 'room_id');
    }
}
