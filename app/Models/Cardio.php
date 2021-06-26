<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardio extends Model
{
    use HasFactory;

    public function workouts() {
        return $this->belongsTo(Workout::class, 'workout_id');
    }
}
