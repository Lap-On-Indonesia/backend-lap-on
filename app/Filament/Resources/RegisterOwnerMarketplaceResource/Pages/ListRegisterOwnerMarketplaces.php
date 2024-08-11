<?php

namespace App\Filament\Resources\RegisterOwnerMarketplaceResource\Pages;

use App\Filament\Resources\RegisterOwnerMarketplaceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegisterOwnerMarketplaces extends ListRecords
{
    protected static string $resource = RegisterOwnerMarketplaceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
