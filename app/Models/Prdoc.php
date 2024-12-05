<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prdoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'mode',
        'desc',
        'purpose',
        'event_need',
        'event_start',
        'event_end',
        'event_loc',
        'end_office',
        'end_user',
        'status',
        'value',
        'archived',
        'starred',
    ];
}

