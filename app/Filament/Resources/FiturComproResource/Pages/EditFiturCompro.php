<?php

namespace App\Filament\Resources\FiturComproResource\Pages;

use App\Filament\Resources\FiturComproResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiturCompro extends EditRecord
{
    protected static string $resource = FiturComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
