<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\User as verified;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'prefix',
        'suffix',
        'gender',
        'avatar',
        'office_id',
        'role',
        'email',
        'password',
    ];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getVerifiedStatusAttribute()
    {
        return $this->hasVerifiedEmail() ? 'verified' : 'not verified';
    }

    public function getStatusAttribute()
    {
        return $this->trashed() ? 'inactive' : 'active';
    }

    public function getFullnameAttribute()
    {
        $middleInitial = $this->middle_name ? strtoupper($this->middle_name[0]) . '.' : '';
        return "{$this->first_name} {$middleInitial} {$this->last_name}";
    }

    /**
     * Compute the full name with affixes.
     *
     * @param string|null $option (accepts 'prefix', 'suffix', or null for both)
     * @return string
     */
    public function name_affix(?string $option = null): string
    {

        $fullname = $this->fullname;
        $prefix = $this->prefix ?? '';
        $suffix = $this->suffix ?? '';

        switch ($option) {
            case 'prefix':
                return trim("{$this->prefix} {$fullname}");
            case 'suffix':
                return trim("{$fullname} {$this->suffix}");
            default: // Both prefix and suffix
                return trim("{$this->prefix} {$fullname} {$this->suffix}");
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
