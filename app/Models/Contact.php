<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // 状态常量
    const STATUS_PENDING = 'pending';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    // 获取状态标签
    public function getStatusLabelAttribute()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_READ => 'Read',
            self::STATUS_REPLIED => 'Replied',
        ][$this->status] ?? 'Unknown';
    }

    // 获取状态颜色
    public function getStatusColorAttribute()
    {
        return [
            self::STATUS_PENDING => 'yellow',
            self::STATUS_READ => 'blue',
            self::STATUS_REPLIED => 'green',
        ][$this->status] ?? 'gray';
    }
}
