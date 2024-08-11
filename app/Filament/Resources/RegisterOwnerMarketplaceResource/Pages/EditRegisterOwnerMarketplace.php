<?php

namespace App\Filament\Resources\RegisterOwnerMarketplaceResource\Pages;

use App\Filament\Resources\RegisterOwnerMarketplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegisterOwnerMarketplace extends EditRecord
{
    protected static string $resource = RegisterOwnerMarketplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
