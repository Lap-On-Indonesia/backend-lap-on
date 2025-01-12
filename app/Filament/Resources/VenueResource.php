<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Models\Category;
use App\Models\Owner;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Support\Facades\Log;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function getNavigationGroup(): ?string
    {
        return 'Admin Management';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->label('Owner')
                    ->options(Owner::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::query()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->label('Venue Name')
                    ->required()
                    ->maxLength(100),

                TextInput::make('description')
                    ->label('Description')
                    ->required(),

                FileUpload::make('image')
                    ->disk('public')
                    ->directory('venue')
                    ->image()
                    ->required(),

                TextInput::make('link_maps')
                    ->label('Google Maps Link')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->required()
                    ->rule('between:-90,90')
                    ->default('-6.3437692'), // Default latitude

                TextInput::make('longitude')
                    ->label('Longitude')
                    ->numeric()
                    ->required()
                    ->rule('between:-180,180')
                    ->default('106.6757172'), // Default longitude

                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required()
                    ->rule('min:0')
                    ->prefix('IDR ')
                    ->suffix(',-'), // Menambahkan simbol mata uang dan koma

                ViewField::make('map')
                    ->view('components.map-view')
                    ->label('Peta Lokasi')
                    ->extraAttributes(function ($record) {
                        Log::info('ExtraAttributes function called'); // Debugging

                        if ($record) {
                            Log::info('Record Data:', $record->toArray()); // Log data untuk verifikasi
                            return [
                                'latitude' => (float) $record->latitude,
                                'longitude' => (float) $record->longitude,
                                'id' => $record->id,
                            ];
                        }

                        Log::warning('Record is null'); // Jika record tidak tersedia
                        return [
                            'latitude' => -6.3437692, // Default latitude
                            'longitude' => 106.6757172, // Default longitude
                            'id' => null,
                        ];
                    }),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')
                    ->label('Owner')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Venue Name')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description'),

                TextColumn::make('category.name')
                    ->label('Category'),

                ImageColumn::make('image')
                    ->label('Image')
                    ->width(100)
                    ->height(100),

                TextColumn::make('latitude')
                    ->label('Latitude')
                    ->sortable(), // Menambahkan sortable

                TextColumn::make('longitude')
                    ->label('Longitude')
                    ->sortable(), // Menambahkan sortable

                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR'), // Format harga dalam IDR

                ViewColumn::make('map')
                    ->view('components.map-view')
                    ->label('Peta Lokasi')
                    ->extraAttributes(fn ($record) => [
                        'latitude' => (float) ($record->latitude ?? -6.3437692),
                        'longitude' => (float) ($record->longitude ?? 106.6757172),
                        'id' => $record->id ?? null,
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVenues::route('/'),
            'create' => Pages\CreateVenue::route('/create'),
            'edit' => Pages\EditVenue::route('/{record}/edit'),
        ];
    }
}
