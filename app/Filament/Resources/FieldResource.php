<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FieldResource\Pages;
use App\Models\Field;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    // public static function getNavigationGroup(): ?string
    // {
    //     return 'Admin Management';
    // }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('venue_id')
                    ->label('Venue')
                    ->options(Venue::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->label('Field Name')
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('venue.name')
                    ->label('Venue')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Field Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description'),
                TextColumn::make('price')
                    ->label('Price')
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}

