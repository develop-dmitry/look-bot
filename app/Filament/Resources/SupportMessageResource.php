<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportMessageResource\Pages;
use App\Models\SupportMessage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class SupportMessageResource extends Resource
{
    protected static ?string $model = SupportMessage::class;

    protected static ?string $label = 'Техническая поддержка';

    protected static ?string $pluralLabel = 'Техническая поддержка';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label('Клиент')
                    ->relationship('client', 'id')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\TextInput::make('context')
                    ->label('Откуда пришел запрос')
                    ->disabledOn('edit')
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('Сообщение')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\Toggle::make('resolved')
                    ->label('Разрешен')
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label('Комментарий')
                    ->disabledOn('create'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_id')
                    ->label('Клиент'),
                Tables\Columns\TextColumn::make('context')
                    ->label('Откуда пришел запрос'),
                Tables\Columns\IconColumn::make('resolved')
                    ->label('Разрешен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i:s'),
            ])
            ->filters([
                Tables\Filters\Filter::make('not_resolved')
                    ->label('Не разрешены')
                    ->toggle()
                    ->query(static fn (Builder $query) => $query->where('resolved', false))
                    ->default()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListSupportMessages::route('/'),
            'create' => Pages\CreateSupportMessage::route('/create'),
            'edit' => Pages\EditSupportMessage::route('/{record}/edit'),
        ];
    }
}
