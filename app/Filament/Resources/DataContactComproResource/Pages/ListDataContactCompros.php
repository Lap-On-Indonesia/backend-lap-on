<?php

namespace App\Filament\Resources\DataContactComproResource\Pages;

use App\Filament\Resources\DataContactComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataContactCompros extends ListRecords
{
    protected static string $resource = DataContactComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
