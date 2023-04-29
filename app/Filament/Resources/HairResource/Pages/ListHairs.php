<?php

namespace App\Filament\Resources\HairResource\Pages;

use App\Filament\Resources\HairResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHairs extends ListRecords
{
    protected static string $resource = HairResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
