<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_length', 
        'workout_date',
    ];

    /* Relationships */
    
    public function sets() {
        return $this->hasMany(Set::class);
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
