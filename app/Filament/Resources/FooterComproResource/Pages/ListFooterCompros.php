<?php

namespace App\Filament\Resources\FooterComproResource\Pages;

use App\Filament\Resources\FooterComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFooterCompros extends ListRecords
{
    protected static string $resource = FooterComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
