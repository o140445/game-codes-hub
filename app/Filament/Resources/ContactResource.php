<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('subject')
                    ->label('Subject')
                    ->required()
                    ->maxLength(255),
                Textarea::make('message')
                    ->label('Message')
                    ->required()
                    ->maxLength(2000)
                    ->rows(5),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        Contact::STATUS_PENDING => 'Pending',
                        Contact::STATUS_READ => 'Read',
                        Contact::STATUS_REPLIED => 'Replied',
                    ])
                    ->default(Contact::STATUS_PENDING)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        Contact::STATUS_PENDING => 'warning',
                        Contact::STATUS_READ => 'info',
                        Contact::STATUS_REPLIED => 'success',
                    }),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        Contact::STATUS_PENDING => 'Pending',
                        Contact::STATUS_READ => 'Read',
                        Contact::STATUS_REPLIED => 'Replied',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->visible(fn (Contact $record): bool => $record->status === Contact::STATUS_PENDING)
                    ->action(function (Contact $record): void {
                        $record->update(['status' => Contact::STATUS_READ]);
                    }),
                Action::make('mark_as_replied')
                    ->label('Mark as Replied')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Contact $record): bool => $record->status !== Contact::STATUS_REPLIED)
                    ->action(function (Contact $record): void {
                        $record->update(['status' => Contact::STATUS_REPLIED]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('mark_as_read')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->action(function ($records): void {
                            $records->each(function ($record) {
                                if ($record->status === Contact::STATUS_PENDING) {
                                    $record->update(['status' => Contact::STATUS_READ]);
                                }
                            });
                        }),
                    BulkAction::make('mark_as_replied')
                        ->label('Mark as Replied')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records): void {
                            $records->each(function ($record) {
                                if ($record->status !== Contact::STATUS_REPLIED) {
                                    $record->update(['status' => Contact::STATUS_REPLIED]);
                                }
                            });
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
