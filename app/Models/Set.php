<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'exercise_id', 
        'workout_id', 
        'reps', 
        'weight_lifted'
    ];

    /* Relationships */
    
    public function exercises() {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function workouts() {
        return $this->belongsTo(Workout::class, 'workout_id');
    }
}
