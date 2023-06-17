<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_users');
    }
}
