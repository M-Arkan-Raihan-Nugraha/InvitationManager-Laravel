<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = ['invitation_id','guest_id','status','response_time'];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }
    
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
