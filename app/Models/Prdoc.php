<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prdoc extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'number',
        'mode',
        'desc',
        'purpose',
        'event_need',
        'event_start',
        'event_end',
        'event_loc',
        'office',
        'user',
        'status',
        'value',
        'archived',
        'starred',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}

