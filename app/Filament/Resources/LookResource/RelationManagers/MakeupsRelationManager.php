<?php

namespace App\Filament\Resources\LookResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MakeupsRelationManager extends RelationManager
{
    protected static string $relationship = 'makeups';

    protected static ?string $label = 'Макияж';

    protected static ?string $pluralLabel = 'Макияжи';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
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
                    ->label('Уровень сложности')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->disableAttachAnother()
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make()
            ])
            ->defaultSort('id', 'desc');
    }
}
