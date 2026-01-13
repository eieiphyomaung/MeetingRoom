<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'reserve_id','admin_user_id','decision_status','decision_note','decided_at'
    ];

    protected $casts = ['decided_at' => 'datetime'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reserve_id', 'reserve_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id', 'user_id');
    }
}
