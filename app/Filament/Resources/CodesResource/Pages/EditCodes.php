<?php

namespace App\Filament\Resources\CodesResource\Pages;

use App\Filament\Resources\CodesResource;
use App\Models\Games;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditCodes extends EditRecord
{
    protected static string $resource = CodesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // 获取code记录
        $code = $this->record;

        // 获取原始数据（保存前的状态）
        $originalStatus = $this->record->getOriginal('status');
        $newStatus = $code->status;

        // 更新对应游戏的code数量
        $game = Games::find($code->game_id);
        if ($game) {
            // 如果状态从正常变为过期，减少有效code数量
            if ($originalStatus == 1 && $newStatus == 0) {
                $game->decrement('codes_valid');
                $game->increment('codes_invalid');
            }
            // 如果状态从过期变为正常，增加有效code数量
            elseif ($originalStatus == 0 && $newStatus == 1) {
                $game->increment('codes_valid');
                $game->decrement('codes_invalid');
            }
        }

        //清楚缓存
        Cache::forget('game_detail_'.$game->slug);
    }

    protected function afterDelete(): void
    {
        // 获取被删除的code记录
        $code = $this->record;

        // 更新对应游戏的code数量
        $game = Games::find($code->game_id);
        if ($game) {
            // 减少总code数量
            $game->decrement('codes_total');

            // 根据code状态减少相应的数量
            if ($code->status == 1) {
                $game->decrement('codes_valid');
            } else {
                $game->decrement('codes_invalid');
            }
        }
    }
}
