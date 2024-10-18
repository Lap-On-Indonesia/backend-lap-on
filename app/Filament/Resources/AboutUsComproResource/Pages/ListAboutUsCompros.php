<?php

namespace App\Filament\Resources\AboutUsComproResource\Pages;

use App\Filament\Resources\AboutUsComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutUsCompros extends ListRecords
{
    protected static string $resource = AboutUsComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
