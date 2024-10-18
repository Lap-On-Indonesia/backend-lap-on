<?php

namespace App\Filament\Resources\FiturComproResource\Pages;

use App\Filament\Resources\FiturComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFiturCompros extends ListRecords
{
    protected static string $resource = FiturComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
