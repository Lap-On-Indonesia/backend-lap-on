<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Filament\Resources\VenueResource\RelationManagers;
use App\Models\Category;
use App\Models\Owner;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('owner_id')
                    ->label('Owner')
                    ->options(Owner::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                TextInput::make('description')
                    ->required(),
                FileUpload::make('image')
                    ->label('Venue Upload')
                    ->disk('public')
                    ->directory('venue')
                    ->image()
                    ->required(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('link_maps')
                    ->required()
                    ->maxLength(255),
                Select::make('day_of_week')
                    ->label('Day of Week')
                    ->options([
                        'monday'    => 'Monday',
                        'tuesday'   => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday'  => 'Thursday',
                        'friday'    => 'Friday',
                        'saturday'  => 'Saturday',
                        'sunday'    => 'Sunday',
                    ])
                    ->required(),
                TimePicker::make('start_time')
                    ->required()
                    ->label('Start Time')
                    ->hoursStep(1) // Mengatur interval pemilihan waktu menjadi setiap 1 jam
                    ->withoutSeconds() // Menghilangkan detik dari tampilan
                    ->reactive() // Memungkinkan perubahan end_time ketika start_time diubah
                    ->afterStateUpdated(fn($state, callable $set) => $set('end_time', \Carbon\Carbon::parse($state)->addHour()->format('H:i'))), // Set end_time secara otomatis 1 jam setelah start_time
                TimePicker::make('end_time')
                    ->required()
                    ->label('End Time')
                    ->hoursStep(1) // Mengatur interval pemilihan waktu menjadi setiap 1 jam
                    ->withoutSeconds(), // Menghilangkan detik dari tampilan
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('owner.name')->label('Owner')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('description'),
                TextColumn::make('category.name')->label('Category'),
                ImageColumn::make('image')->width(100)->height(100),
                TextColumn::make('address')->searchable(),
                TextColumn::make('link_maps'),
                TextColumn::make('day_of_week')->label('Day of Week'),
                TextColumn::make('start_time')->label('Start Time'),
                TextColumn::make('end_time')->label('End Time'),
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
            'index' => Pages\ListVenues::route('/'),
            'create' => Pages\CreateVenue::route('/create'),
            'edit' => Pages\EditVenue::route('/{record}/edit'),
        ];
    }
}
