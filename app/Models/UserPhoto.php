<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPhoto extends Model
{
    protected $fillable = [
        'original_name',
        'path_to_original',
        'path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
