<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegisterOwnerMarketplaceResource\Pages;
use App\Filament\Resources\RegisterOwnerMarketplaceResource\RelationManagers;
use App\Models\RegisterOwnerMarketplace;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegisterOwnerMarketplaceResource extends Resource
{
    protected static ?string $model = RegisterOwnerMarketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(100),
                TextInput::make('phone')
                    ->required()
                    ->maxLength(20),
                FileUpload::make('photo_profile')
                    ->nullable()
                    ->disk('public')
                    ->directory('profile_photos')
                    ->image(),
                FileUpload::make('photo_ktp')
                    ->nullable()
                    ->disk('public')
                    ->directory('ktp_photos')
                    ->image(),
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->maxLength(100),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                ImageColumn::make('photo_profile')->width(100)->height(100),
                ImageColumn::make('photo_ktp')->width(100)->height(100),
            ])
            ->filters([
                // You can add filters here if needed
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
            // Add relations here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegisterOwnerMarketplaces::route('/'),
            'create' => Pages\CreateRegisterOwnerMarketplace::route('/create'),
            'edit' => Pages\EditRegisterOwnerMarketplace::route('/{record}/edit'),
        ];
    }
}
