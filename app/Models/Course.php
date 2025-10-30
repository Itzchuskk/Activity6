<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'robotics_kit_id',
        'code','name','description','credits','hours','price',
        'start_date','end_date','published','user_id','options',
        'image_path',
    ];

    protected $casts = [
        'published' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'options' => 'array',
    ];

    public function roboticsKit()
    {
        return $this->belongsTo(RoboticsKit::class, 'robotics_kit_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) return null;
        return Storage::disk('public')->url($this->image_path);
    }
}
