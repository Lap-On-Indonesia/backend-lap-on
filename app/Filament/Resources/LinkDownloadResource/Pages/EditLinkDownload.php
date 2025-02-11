<?php

namespace App\Filament\Resources\LinkDownloadResource\Pages;

use App\Filament\Resources\LinkDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinkDownload extends EditRecord
{
    protected static string $resource = LinkDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
