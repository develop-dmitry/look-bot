<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HairResource\Pages;
use App\Filament\Resources\HairResource\RelationManagers;
use App\Models\Hair;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HairResource extends Resource
{
    protected static ?string $model = Hair::class;

    protected static ?string $label = 'Прическа';

    protected static ?string $pluralLabel = 'Прически';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                \Nuhel\FilamentCropper\Components\Cropper::make('photo')
                    ->label('Фотография')
                    ->enableImageRotation()
                    ->modalSize('xl')
                    ->modalHeading('Обрезать фотографию')
                    ->enableOpen()
                    ->disk('local')
                    ->directory('public/hairs')
                    ->required(),
                Forms\Components\TextInput::make('level')
                    ->label('Уровень сложности')
                    ->numeric()
                    ->required()
                    ->mask(static fn (Forms\Components\TextInput\Mask $mask) => $mask
                        ->range()
                        ->from(0)
                        ->to(100)
                        ->maxValue(100)
                    ),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Название'),
                Tables\Columns\ImageColumn::make('photo')
                    ->disk('local')
                    ->label('Фотография'),
                Tables\Columns\TextColumn::make('level')
                    ->label('Уровень сложности'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StylesRelationManager::class,
            RelationManagers\EventsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHairs::route('/'),
            'create' => Pages\CreateHair::route('/create'),
            'edit' => Pages\EditHair::route('/{record}/edit'),
        ];
    }
}
