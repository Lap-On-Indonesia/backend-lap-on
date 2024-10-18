<?php

namespace App\Filament\Resources\FooterComproResource\Pages;

use App\Filament\Resources\FooterComproResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFooterCompro extends EditRecord
{
    protected static string $resource = FooterComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
