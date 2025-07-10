<?php

namespace App\Filament\Resources\AttachmentResource\Pages;

use App\Filament\Resources\AttachmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttachment extends EditRecord
{
    protected static string $resource = AttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('查看'),
            Actions\DeleteAction::make()
                ->label('删除'),
            Actions\Action::make('download')
                ->label('下载')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn (): string => $this->record->url)
                ->openUrlInNewTab(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
