<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Observers\StageActionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([StageActionObserver::class])]
class StageAction extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    // Fields that can be mass-assigned
    protected $fillable = [
        'uuid',
        'prdoc_id',
        'user_group',
        'user_id',
        'incharge',
        'proc_no',
        'main_proc',
        'proc',
        'desc',
        'attachment',
        'status',
        'action_taken_at',
    ];

    protected $appends = [
        'is_received',
        'is_completed',
    ];

    public function getIsReceivedAttribute()
    {
        return !is_null($this->received_at);
    }

    public function getIsCompletedAttribute()
    {
        return !is_null($this->completed_at);
    }

    // Relationships
    public function prdoc()
    {
        return $this->belongsTo(Prdoc::class)->withTrashed();
    }

    public function user_group()
    {
        return $this->hasMany(User::class, 'office_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stageFiles()
    {
        return $this->hasMany(StageFile::class);
    }

    // Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in progress');
    }

    public function scopeOnHold($query)
    {
        return $query->where('status', 'on hold');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'complete');
    }

}
