<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'article';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'status',
        'category',
        'author',
        'source',
    ];
}
