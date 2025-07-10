<?php

namespace App\Filament\Resources\GamesResource\Pages;

use App\Filament\Resources\GamesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class EditGames extends EditRecord
{
    protected static string $resource = GamesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 根据标题自动生成 slug
        if (isset($data['name']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // 更新游戏更新时间
        $game = $this->record;
        $game->update(['updated_at' => now()]);

        //清楚缓存
        Cache::forget('game_detail_'.$game->slug);
        Cache::forget('special_recommended_games');
        Cache::forget('hot_games');
        Cache::forget('new_games');
        Cache::forget('recommended_games');
    }
}
