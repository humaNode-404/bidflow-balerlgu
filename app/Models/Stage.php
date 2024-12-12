<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stage extends Model
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
        'status',
        'user_id',
        'main_proc',
        'proc',
        'desc',
        'received_at',
        'completed_at',
    ];

    public function prdoc()
    {
        return $this->belongsTo(Prdoc::class, 'prdoc_id');
    }
}

