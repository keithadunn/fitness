<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calories_consumed', 
        'date',
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
