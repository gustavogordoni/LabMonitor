<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warning extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'reason', 'issued_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
