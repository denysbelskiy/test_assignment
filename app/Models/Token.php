<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'id',
        'expires_at',
        'used',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function setToUsed()
    {
        $this->used = true;
        $this->save();
    }
}
