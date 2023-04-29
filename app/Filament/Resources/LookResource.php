<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LookResource\Pages;
use App\Filament\Resources\LookResource\RelationManagers;
use App\Models\Look;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LookResource extends Resource
{
    protected static ?string $model = Look::class;

    protected static ?string $label = 'Образ';

    protected static ?string $pluralLabel = 'Образы';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Описание'),
                \Nuhel\FilamentCropper\Components\Cropper::make('photo')
                    ->label('Фотография')
                    ->enableImageRotation()
                    ->modalSize('xl')
                    ->modalHeading('Обрезать фотографию')
                    ->enableOpen()
                    ->disk('local')
                    ->directory('public/looks')
                    ->required(),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('lower_temperature_range')
                            ->label('Нижний диапазон температуры')
                            ->required()
                            ->mask(static fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->minValue(-50)
                                ->maxValue(50)
                                ->numeric()
                            ),
                        Forms\Components\TextInput::make('upper_temperature_range')
                            ->label('Верхний диапазон температуры')
                            ->required()
                            ->mask(static fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->maxValue(50)
                                ->minValue(-50)
                                ->numeric()
                            ),
                    ])
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
            RelationManagers\HairsRelationManager::class,
            RelationManagers\MakeupsRelationManager::class,
            RelationManagers\ClothesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLooks::route('/'),
            'create' => Pages\CreateLook::route('/create'),
            'edit' => Pages\EditLook::route('/{record}/edit'),
        ];
    }
}
