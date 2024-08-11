<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryMarketplaceResource\Pages;
use App\Filament\Resources\CategoryMarketplaceResource\RelationManagers;
use App\Models\CategoryMarketplace;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryMarketplaceResource extends Resource
{
    protected static ?string $model = CategoryMarketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategoryMarketplaces::route('/'),
            'create' => Pages\CreateCategoryMarketplace::route('/create'),
            'edit' => Pages\EditCategoryMarketplace::route('/{record}/edit'),
        ];
    }
}
