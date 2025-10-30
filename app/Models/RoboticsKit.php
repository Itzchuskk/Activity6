<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoboticsKit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','description','sku','price'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'robotics_kit_id');
    }
}
