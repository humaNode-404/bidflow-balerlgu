<?php

namespace App\Models;

use App\Models\Scopes\CompletedPr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\PrdocObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([PrdocObserver::class])]
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

  /**
   * Scope a query to only include failed prdocs.
   */
  /**
   * Scope a query to only include failed prdocs.
   */
  public function scopeFailed(Builder $query): void
  {
    $query->whereNotNull('failed_at');
  }

  public function scopeNotFailed(Builder $query): void
  {
    $query->whereNull('failed_at');
  }

  protected $fillable = [
    'number',
    'mode',
    'desc',
    'value',
    'purpose',
    'event_need',
    'event_end',
    'event_loc',
    'user_id',
    'modify_by',
    'failed_at'
  ];

  public function getCanUpdateAttribute()
  {
    return is_null($this->failed_at) && is_null($this->deleted_at);
  }


  public function getPriorityLevelAttribute()
  {
    $level = 1;
    if (strcasecmp($this->mode, "Negotiated Procurement") == 0) {
      $level = 3;
    } elseif (\Carbon\Carbon::parse($this->event_need)->diffInDays(now()) < 7) {
      $level = 2;
    }

    return $level;
  }

  public function getStageCountAttribute()
  {
    return count($this->stageactions()->get());
  }

  public function getOfficeIdAttribute()
  {
    return $this->user?->office_id;
  }

  public function user()
  {
    return $this->belongsTo(User::class)->withTrashed();
  }

  public function office()
  {
    return $this->belongsTo(Office::class);
  }

  public function stageactions()
  {
    return $this->hasMany(StageAction::class);
  }
}
