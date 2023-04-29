<?php

namespace App\Filament\Resources\LookResource\Pages;

use App\Filament\Resources\LookResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLook extends EditRecord
{
    protected static string $resource = LookResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
