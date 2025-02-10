<?php

namespace App\Filament\Resources\LinkDownloadResource\Pages;

use App\Filament\Resources\LinkDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinkDownloads extends ListRecords
{
    protected static string $resource = LinkDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
