<?php

namespace App\Filament\Resources\LookResource\Pages;

use App\Filament\Resources\LookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLooks extends ListRecords
{
    protected static string $resource = LookResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
