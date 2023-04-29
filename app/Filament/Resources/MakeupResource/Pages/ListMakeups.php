<?php

namespace App\Filament\Resources\MakeupResource\Pages;

use App\Filament\Resources\MakeupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMakeups extends ListRecords
{
    protected static string $resource = MakeupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
