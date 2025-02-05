<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prdoc extends Model
{
    use HasFactory, SoftDeletes;

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
        'event_end',
        'event_loc',
        'office_id',
        'user_id',
        'status',
        'value',
        'archived',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stageactions()
    {
        return $this->hasMany(StageAction::class);
    }
}

