<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Codes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'game_id',
        'status',
        'name',
        'description',
        'is_latest',
    ];

    public function game()
    {
        return $this->belongsTo(Games::class, 'game_id');
    }
}
