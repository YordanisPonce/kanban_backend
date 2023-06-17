<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'subtitle',
        'user_id',
    ];


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
