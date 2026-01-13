<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    
    protected $primaryKey = 'reserve_id';

    public $incrementing = true;

    protected $keyType = 'int';

   protected $fillable = [
    'user_id',
    'room_id',
    'depart_id',
    'reserve_date',
    'start_time',
    'end_time',
    'title',
    'description',
    'purpose',
    'status',
    'reject_reason',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'depart_id', 'depart_id');
    }

    public function approval()
    {
        return $this->hasOne(Approval::class, 'reserve_id', 'reserve_id');
    }
}
