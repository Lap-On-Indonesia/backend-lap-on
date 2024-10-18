<?php

namespace App\Filament\Resources\HeaderComproResource\Pages;

use App\Filament\Resources\HeaderComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeaderCompros extends ListRecords
{
    protected static string $resource = HeaderComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
