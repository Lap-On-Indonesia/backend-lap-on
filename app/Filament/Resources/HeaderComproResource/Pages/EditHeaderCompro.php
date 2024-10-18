<?php

namespace App\Filament\Resources\HeaderComproResource\Pages;

use App\Filament\Resources\HeaderComproResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeaderCompro extends EditRecord
{
    protected static string $resource = HeaderComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
