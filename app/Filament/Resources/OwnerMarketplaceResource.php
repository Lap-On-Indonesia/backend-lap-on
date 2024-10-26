<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OwnerMarketplace;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OwnerMarketplaceResource\Pages;
use App\Filament\Resources\OwnerMarketplaceResource\RelationManagers;
use App\Mail\StatusOwnerMarketplace;

class OwnerMarketplaceResource extends Resource
{
    protected static ?string $model = OwnerMarketplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected function afterSave($record): void
    {
        // Mengecek apakah status berubah
        if ($record->wasChanged('status')) {
            // Kirim email ke pemilik marketplace
            Mail::to($record->email)->send(new StatusOwnerMarketplace($record));
        }
    }

    public static function form(Form $form): Form
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
                    ->maxLength(15),
                FileUpload::make('photo_profile')
                    ->label('Foto Profile')
                    ->disk('public')
                    ->image()
                    ->directory('photo_profile_marketplace'),
                FileUpload::make('photo_ktp')
                    ->label('Foto KTP')
                    ->disk('public')
                    ->image()
                    ->directory('owner_ktp_marketplace'),
                TextInput::make('no_rekening')
                    ->label('Nomor Rekening'),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'accept' => 'Accept',
                        'reject' => 'Reject',
                    ])
                    ->default('pending')
                    ->required(),
                TextInput::make('store_name')
                    ->label('Nama Store')
                    ->required(),
                TextInput::make('store_address')
                    ->label('Alamat Store')
                    ->required(),
                TextInput::make('link_maps')
                    ->label('Link Maps')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(100)
                    ->required(fn($record) => !$record),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),

                ImageColumn::make('photo_profile'),

                ImageColumn::make('photo_ktp'),

                TextColumn::make('no_rekening')
                    ->label('Nomor Rekening')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status'),

                TextColumn::make('store_name')
                    ->label('Nama Store')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('store_address')
                    ->label('Alamat Store')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('link_maps')
                    ->label('Link Maps')
                    ->url(fn($record) => $record->link_maps)
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListOwnerMarketplaces::route('/'),
            'create' => Pages\CreateOwnerMarketplace::route('/create'),
            'edit' => Pages\EditOwnerMarketplace::route('/{record}/edit'),
        ];
    }
}
