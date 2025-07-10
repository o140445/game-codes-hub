<?php

namespace App\Filament\Resources\AttachmentResource\Pages;

use App\Filament\Resources\AttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttachment extends ViewRecord
{
    protected static string $resource = AttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('编辑'),
            Actions\Action::make('download')
                ->label('下载')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => $this->record->url)
                ->openUrlInNewTab(),
        ];
    }
}
