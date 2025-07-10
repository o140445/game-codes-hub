<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Games extends Model
{
    use HasFactory, SoftDeletes;

    // 保存字段
    protected $fillable = [
        'name',
        'slug',
        'image',
        'platform',
        'status',
        'description',
        'content',
        'category',
        'codes_total',
        'codes_valid',
        'codes_invalid',
        'is_recommended',
        'is_special_recommend',
        'author',
        'summary',
        'how_to_redeem',
        'faq',
        'views',
    ];

    /**
     * 获取图片URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * 获取状态文本
     */
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            '0' => '禁用',
            '1' => '正常',
            '2' => '待发布',
            default => '未知',
        };
    }

    /**
     * 获取平台文本
     */
    public function getPlatformTextAttribute()
    {
        return match ($this->platform) {
            'roblox' => 'Roblox',
            'mobile' => 'Mobile',
            default => $this->platform,
        };
    }

    /**
     * 获取游戏的兑换码
     */
    public function codes()
    {
        return $this->hasMany(Codes::class, 'game_id');
    }

    //published
    public static function scopePublished()
    {
        return self::where('status', '1');
    }
}
