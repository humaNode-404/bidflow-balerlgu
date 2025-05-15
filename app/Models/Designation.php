<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    // Define which attributes are mass assignable
    protected $fillable = [
        'title',
        'category',
        'suffix'
    ];

    // Define the accessor for the combined title and suffix
    public function getFullTitleAttribute()
    {
        // If there's a suffix, append it to the title, else just return the title
        if ($this->suffix) {
            return $this->title . ' ' . $this->suffix;
        }

        return $this->title;
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
