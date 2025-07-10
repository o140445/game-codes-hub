<?php

namespace App\Filament\Resources\CodesResource\Pages;

use App\Filament\Resources\CodesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCodes extends ListRecords
{
    protected static string $resource = CodesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('创建兑换码'),
        ];
    }
}
