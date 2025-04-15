<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warning extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reason', 'issued_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
