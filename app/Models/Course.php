<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code','name','description','credits','hours','price',
        'start_date','end_date','published','user_id','options'
    ];

    protected $casts = [
        'published'   => 'boolean',
        'start_date'  => 'date',
        'end_date'    => 'date',
        'options'     => 'array',
    ];
}
