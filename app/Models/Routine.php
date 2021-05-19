<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use HasFactory;

    /* Relationships */
    
    public function routineSets() {
        return $this->hasMany(RoutineSet::class);
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
