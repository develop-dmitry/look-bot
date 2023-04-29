<?php

namespace App\Filament\Resources\ClothesResource\Pages;

use App\Filament\Resources\ClothesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClothes extends ListRecords
{
    protected static string $resource = ClothesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
