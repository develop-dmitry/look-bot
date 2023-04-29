<?php

namespace App\Filament\Resources\MakeupResource\Pages;

use App\Filament\Resources\MakeupResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMakeup extends EditRecord
{
    protected static string $resource = MakeupResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
