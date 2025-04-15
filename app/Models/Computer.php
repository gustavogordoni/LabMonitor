<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'status']; // status: available, in_use, inactive

    public function usages()
    {
        return $this->hasMany(Usage::class);
    }
}
