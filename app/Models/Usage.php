<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'computer_id', 'start_time', 'end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
