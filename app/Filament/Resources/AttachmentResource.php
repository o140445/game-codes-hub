<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttachmentResource\Pages;
use App\Models\Attachment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class AttachmentResource extends Resource
{
    protected static ?string $model = Attachment::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static ?string $navigationGroup = '内容管理';

    protected static ?string $navigationLabel = '附件管理';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('选择文件')
                    ->required()
                    ->acceptedFileTypes([
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/plain',
                        'application/zip',
                        'application/x-rar-compressed',
                    ])
                    ->maxSize(50 * 1024) // 50MB
                    ->disk('public')
                    ->directory('attachments')
                    ->preserveFilenames()
                    ->columnSpanFull(),

                TextInput::make('name')
                    ->label('文件名')
                    ->required()
                    ->maxLength(255),

                TextInput::make('original_name')
                    ->label('原始文件名')
                    ->required()
                    ->maxLength(255),

                TextInput::make('file_path')
                    ->label('文件路径')
                    ->required()
                    ->maxLength(255),

                TextInput::make('file_size')
                    ->label('文件大小(字节)')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                TextInput::make('mime_type')
                    ->label('MIME类型')
                    ->required()
                    ->maxLength(255),

                TextInput::make('extension')
                    ->label('文件扩展名')
                    ->required()
                    ->maxLength(50),

                Select::make('disk')
                    ->label('存储磁盘')
                    ->options([
                        'public' => 'Public',
                        'local' => 'Local',
                        's3' => 'S3',
                    ])
                    ->default('public')
                    ->required(),

                Textarea::make('description')
                    ->label('描述')
                    ->maxLength(65535)
                    ->columnSpanFull(),

                TextInput::make('alt_text')
                    ->label('替代文本')
                    ->maxLength(255),

                Select::make('user_id')
                    ->label('上传用户')
                    ->relationship('user', 'name')
                    ->required(),

                TextInput::make('attachable_type')
                    ->label('关联模型类型')
                    ->maxLength(255),

                TextInput::make('attachable_id')
                    ->label('关联模型ID')
                    ->numeric()
                    ->minValue(0),

                Toggle::make('is_public')
                    ->label('是否公开')
                    ->default(true),

                TextInput::make('download_count')
                    ->label('下载次数')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->label('预览')
                    ->circular()
                    ->size(40)
                    ->visible(fn (Attachment $record): bool => $record->is_image),

                TextColumn::make('name')
                    ->label('文件名')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('original_name')
                    ->label('原始文件名')
                    ->searchable()
                    ->limit(30),

                TextColumn::make('human_size')
                    ->label('文件大小')
                    ->sortable(query: fn (Builder $query, string $direction): Builder => $query->orderBy('file_size', $direction)),

                TextColumn::make('mime_type')
                    ->label('类型')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_starts_with($state, 'image/') => 'success',
                        str_starts_with($state, 'application/pdf') => 'warning',
                        str_starts_with($state, 'text/') => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('user.name')
                    ->label('上传用户')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('download_count')
                    ->label('下载次数')
                    ->sortable()
                    ->badge(),

                ToggleColumn::make('is_public')
                    ->label('公开')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('上传时间')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('mime_type')
                    ->label('文件类型')
                    ->options([
                        'image/*' => '图片',
                        'application/pdf' => 'PDF文档',
                        'application/msword' => 'Word文档',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word文档',
                        'application/vnd.ms-excel' => 'Excel文档',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'Excel文档',
                        'text/plain' => '文本文件',
                        'application/zip' => '压缩文件',
                        'application/x-rar-compressed' => '压缩文件',
                    ]),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('公开状态'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('download')
                    ->label('下载')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Attachment $record): string => $record->url)
                    ->openUrlInNewTab(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachments::route('/'),
            'create' => Pages\CreateAttachment::route('/create'),
            'view' => Pages\ViewAttachment::route('/{record}'),
            'edit' => Pages\EditAttachment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
