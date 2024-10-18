<?php

namespace App\Filament\Resources\DataContactComproResource\Pages;

use App\Filament\Resources\DataContactComproResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataContactCompro extends EditRecord
{
    protected static string $resource = DataContactComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
