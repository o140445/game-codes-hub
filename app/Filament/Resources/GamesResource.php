<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GamesResource\Pages;
use App\Filament\Resources\GamesResource\RelationManagers;
use App\Models\Games;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;


class GamesResource extends Resource
{
    protected static ?string $model = Games::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->columns(1)->required()->maxLength(255),
                // 不可修改的slug
                TextInput::make('slug')->columns(1)
                    ->disabled()
                    ->dehydrated(false), // 禁用脱水，确保slug在表单提交时不会被修改

                //description
                TextInput::make('description')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),

                // summary
                TextInput::make('summary')
                    ->label('简介')
                    ->columnSpan(2),

                // image
                FileUpload::make('image')
                    ->columnSpan(2)
                    ->required()
                    ->image()
                    ->acceptedFileTypes(['image/*'])
                    ->maxSize(5120) // 5MB
                    ->disk('public')
                    ->directory('games'),

                // platform
                Select::make('platform')
                    ->options([
                        'roblox' => 'Roblox',
                        'mobile' => 'Mobile',
                    ])
                    ->required(),

                // status
                Select::make('status')
                    ->options([
                        '2' => '待发布',
                        '1' => '正常',
                        '0' => '禁用',
                    ])
                    ->required(),

                Toggle::make('is_recommended')
                    ->label('推荐')
                    ->default(false),

                Toggle::make('is_special_recommend')
                    ->label('特别推荐')
                    ->default(false),


                RichEditor::make('content')
                    ->label('详细内容')
                    ->columnSpan(2),

                RichEditor::make('how_to_redeem')
                    ->label('如何兑换')
                    ->columnSpan(2),

                RichEditor::make('faq')
                    ->label('常见问题')
                    ->columnSpan(2),


                // author
                TextInput::make('author')
                    ->label('作者')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('图片')
                    ->circular()
                    ->size(40)
                    ->disk('public'),

                Tables\Columns\TextColumn::make('name')
                    ->label('名称')
                    ->searchable()
                    ->sortable()
                    ->placeholder('搜索游戏名称...'),

                Tables\Columns\TextColumn::make('platform')
                    ->label('平台')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'roblox' => 'Roblox',
                        'mobile' => 'Mobile',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                        '2' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => '正常',
                        '0' => '禁用',
                        '2' => '待发布',
                        default => '未知',
                    })
                    ->badge()
                    ,
                Tables\Columns\ToggleColumn::make('is_recommended')
                    ->label('推荐'),
                Tables\Columns\ToggleColumn::make('is_special_recommend')
                    ->label('特别推荐'),

                Tables\Columns\TextColumn::make('views')
                    ->label('观看次数')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('创建时间')
                    ->dateTime('Y-m-d H:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新时间')
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('状态筛选')
                    ->options([
                        '1' => '正常',
                        '0' => '禁用',
                        '2' => '待发布',
                    ])
                    ->placeholder('选择状态'),
                Tables\Filters\SelectFilter::make('platform')
                    ->label('平台筛选')
                    ->options([
                        'roblox' => 'Roblox',
                        'mobile' => 'Mobile',
                    ])
                    ->placeholder('选择平台'),
                Tables\Filters\TernaryFilter::make('is_recommended')
                    ->label('推荐筛选'),
                Tables\Filters\TernaryFilter::make('is_special_recommend')
                    ->label('特别推荐筛选'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100]);
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
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGames::route('/create'),
            'edit' => Pages\EditGames::route('/{record}/edit'),
        ];
    }
}
