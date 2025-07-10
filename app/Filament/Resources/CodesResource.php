<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CodesResource\Pages;
use App\Models\Codes;
use App\Models\Games;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class CodesResource extends Resource
{
    protected static ?string $model = Codes::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = '兑换码管理';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('兑换码')
                    ->required()
                    ->maxLength(255),
                TextInput::make('name')
                    ->label('名称')
                    ->maxLength(255),
                Select::make('game_id')
                    ->label('所属游戏')
                    ->options(\App\Models\Games::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Select::make('status')
                    ->label('状态')
                    ->options([
                        '1' => '正常',
                        '0' => '过期',
                    ])
                    ->default('1')
                    ->required(),
                Textarea::make('description')
                    ->label('描述')
                    ->maxLength(500),
                Toggle::make('is_latest')
                    ->label('是否最新')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('兑换码')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('名称')
                    ->limit(30)
                    ->searchable(),
                Tables\Columns\TextColumn::make('game.name')
                    ->label('所属游戏')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->formatStateUsing(fn ($state) => $state == 1 ? '正常' : '过期')
                    ->badge()
                    ->color(fn ($state) => $state == 1 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('is_latest')
                    ->label('是否最新')
                    ->formatStateUsing(fn ($state) => $state ? '是' : '否')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
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
                    ]),
                Tables\Filters\SelectFilter::make('game_id')
                    ->label('游戏筛选')
                    ->relationship('game', 'name'),
                Tables\Filters\TernaryFilter::make('is_latest')
                    ->label('最新筛选'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function ($records) {
                            // 批量删除后更新游戏code数量
                            foreach ($records as $code) {
                                $game = Games::find($code->game_id);
                                if ($game) {
                                    $game->decrement('codes_total');
                                    if ($code->status == 1) {
                                        $game->decrement('codes_valid');
                                    } else {
                                        $game->decrement('codes_invalid');
                                    }
                                }
                            }
                        }),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->after(function ($records) {
                            // 强制删除后更新游戏code数量
                            foreach ($records as $code) {
                                $game = Games::find($code->game_id);
                                if ($game) {
                                    $game->decrement('codes_total');
                                    if ($code->status == 1) {
                                        $game->decrement('codes_valid');
                                    } else {
                                        $game->decrement('codes_invalid');
                                    }
                                }
                            }
                        }),
                    Tables\Actions\RestoreBulkAction::make()
                        ->after(function ($records) {
                            // 恢复后更新游戏code数量
                            foreach ($records as $code) {
                                $game = Games::find($code->game_id);
                                if ($game) {
                                    $game->increment('codes_total');
                                    if ($code->status == 1) {
                                        $game->increment('codes_valid');
                                    } else {
                                        $game->increment('codes_invalid');
                                    }
                                }
                            }
                        }),
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
            'index' => Pages\ListCodes::route('/'),
            'create' => Pages\CreateCodes::route('/create'),
            'edit' => Pages\EditCodes::route('/{record}/edit'),
        ];
    }
}
