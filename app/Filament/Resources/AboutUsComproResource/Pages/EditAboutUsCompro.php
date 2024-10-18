<?php

namespace App\Filament\Resources\AboutUsComproResource\Pages;

use App\Filament\Resources\AboutUsComproResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutUsCompro extends EditRecord
{
    protected static string $resource = AboutUsComproResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
