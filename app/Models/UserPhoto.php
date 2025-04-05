<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getPhotoUrl()
    {
        return asset(Storage::url($this->path) ?? Storage::url($this->path_to_original));
    }
}
