<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsComproResource\Pages;
use App\Filament\Resources\AboutUsComproResource\RelationManagers;
use App\Models\AboutUsCompro;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsComproResource extends Resource
{
    protected static ?string $model = AboutUsCompro::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListAboutUsCompros::route('/'),
            'create' => Pages\CreateAboutUsCompro::route('/create'),
            'edit' => Pages\EditAboutUsCompro::route('/{record}/edit'),
        ];
    }
}
