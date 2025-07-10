<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = '内容管理';
    protected static ?string $navigationLabel = '文章管理';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('标题')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->dehydrated(false),
                FileUpload::make('image')
                    ->label('图片')
                    ->image()
                    ->disk('public')
                    ->directory('articles')
                    ->maxSize(5120),
                RichEditor::make('content')
                    ->label('正文')
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('状态')
                    ->options([
                        '1' => '发布',
                        '0' => '草稿',
                    ])
                    ->default('1')
                    ->required(),
                TextInput::make('category')
                    ->label('分类')
                    ->maxLength(100),
                TextInput::make('author')
                    ->label('作者')
                    ->maxLength(100),
                TextInput::make('source')
                    ->label('来源')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('标题')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\ImageColumn::make('image')
                    ->label('图片')
                    ->disk('public')
                    ->size(40),
                Tables\Columns\TextColumn::make('status')
                    ->label('状态')
                    ->formatStateUsing(fn ($state) => $state == 1 ? '发布' : '草稿')
                    ->badge()
                    ->color(fn ($state) => $state == 1 ? 'success' : 'gray'),
                Tables\Columns\TextColumn::make('category')
                    ->label('分类')
                    ->limit(15),
                Tables\Columns\TextColumn::make('author')
                    ->label('作者')
                    ->limit(10),
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
                        '1' => '发布',
                        '0' => '草稿',
                    ]),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListArticle::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
