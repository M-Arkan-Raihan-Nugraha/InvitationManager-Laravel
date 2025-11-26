<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $fillable = ['name','address','contact'];

    public function invitation() {
        return $this->belongsToMany(Invitation::class, 'attendances')
                    ->withPivot('status','response_time')
                    ->withTimestamps();
    }
}
