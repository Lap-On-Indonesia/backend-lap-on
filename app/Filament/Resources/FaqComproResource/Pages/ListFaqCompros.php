<?php

namespace App\Filament\Resources\FaqComproResource\Pages;

use App\Filament\Resources\FaqComproResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFaqCompros extends ListRecords
{
    protected static string $resource = FaqComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
