<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;


    public function beforeSave()
    {
        if (auth()->user()->hasRole('super_admin')) {
            $this->data['owner_id'] = auth()->user()->owner_marketplace_id;
        }
    }
}
