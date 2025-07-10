<?php

namespace App\Filament\Resources\CodesResource\Pages;

use App\Filament\Resources\CodesResource;
use App\Models\Games;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;


class CreateCodes extends CreateRecord
{
    protected static string $resource = CodesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        // 获取刚创建的code记录
        $code = $this->record;

        // 更新对应游戏的code数量
        $game = Games::find($code->game_id);
        if ($game) {
            $game->increment('codes_total');

            // 如果code状态为正常，也增加有效code数量
            if ($code->status == 1) {
                $game->increment('codes_valid');
            }
        }

        // 更新游戏更新时间
        $game->update(['updated_at' => now()]);

        //清楚缓存
        Cache::forget('game_detail_'.$game->slug);
    }
}
