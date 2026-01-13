<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $primaryKey = 'depart_id';  
    public $incrementing = true;
    protected $keyType = 'int';
    
protected $fillable = [
    'depart_name',
    'head_of_department',
    'badge_color',
    'badge_text',
];
}
