<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'category_id',
        'location_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guests()
    {
        return $this->belongsToMany(Guest::class, 'attendances')
                    ->withPivot('status', 'response_time')
                    ->withTimestamps()
                    ->distinct();
    }
}