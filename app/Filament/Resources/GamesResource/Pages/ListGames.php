<?php

namespace App\Filament\Resources\GamesResource\Pages;

use App\Filament\Resources\GamesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGames extends ListRecords
{
    protected static string $resource = GamesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('创建游戏'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // 可以在这里添加头部小部件
        ];
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 3; // 筛选器每行显示3个
    }

    protected function getTableFiltersFormWidth(): string
    {
        return '4xl'; // 筛选器表单宽度
    }
}
