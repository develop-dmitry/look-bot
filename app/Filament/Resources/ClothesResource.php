<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClothesResource\Pages;
use App\Filament\Resources\ClothesResource\RelationManagers;
use App\Models\Clothes;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClothesResource extends Resource
{
    protected static ?string $model = Clothes::class;

    protected static ?string $label = 'Одежда';

    protected static ?string $pluralLabel = 'Одежда';

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
                    ->directory('public/clothes')
                    ->required(),
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
            RelationManagers\EventsRelationManager::class,
            RelationManagers\StylesRelationManager::class,
            RelationManagers\SeasonsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClothes::route('/'),
            'create' => Pages\CreateClothes::route('/create'),
            'edit' => Pages\EditClothes::route('/{record}/edit'),
        ];
    }
}
