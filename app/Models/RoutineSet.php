<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutineSet extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'routine_id', 
        'exercise_id', 
    ];

    /* Relationships */

    public function exercises() {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function routines() {
        return $this->belongsTo(Routines::class, 'routine_id');
    }
}
