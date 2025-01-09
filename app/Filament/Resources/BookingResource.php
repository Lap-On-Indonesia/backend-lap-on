<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use App\Models\User;
use App\Models\Venue;
use App\Models\Schedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getNavigationGroup(): ?string
    {
        return 'Admin Management';
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Select::make('user_id') // Menambahkan pemilihan pengguna
                ->label('User')
                ->options(User::all()->pluck('name', 'id'))
                ->required(),

            Select::make('venue_id')
                ->label('Venue')
                ->options(Venue::all()->pluck('name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set = null) {
                    if ($set) {
                        $set('start_time', null);
                        $set('end_time', null);
                    }
                }),

            DatePicker::make('booking_date')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $get = null, callable $set = null) {
                    if ($get && $set) {
                        $venueId = $get('venue_id');

                        if ($venueId && $state) {
                            $schedule = Schedule::where('venue_id', $venueId)
                                ->whereJsonContains('day_of_week', strtolower(Carbon::parse($state)->format('l')))
                                ->where('is_available', true)
                                ->first();

                            if ($schedule) {
                                $set('start_time', $schedule->start_time);
                                $set('end_time', $schedule->end_time);
                            } else {
                                $set('start_time', null);
                                $set('end_time', null);
                            }
                        }
                    }
                }),

            TimePicker::make('start_time') // Aktifkan input untuk start_time
                ->required()
                ->label('Start Time'),

            TimePicker::make('end_time') // Aktifkan input untuk end_time
                ->required()
                ->label('End Time'),

            TextInput::make('tax_percentage')
                ->required()
                ->numeric(),

            TextInput::make('total_payment')
                ->required()
                ->numeric(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_id')
                    ->label('Booking ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name') // Menambahkan kolom untuk nama pengguna
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('venue.name')
                    ->label('Venue')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_date'),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
                TextColumn::make('tax_percentage'),
                TextColumn::make('total_payment'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Hapus aksi edit dan delete
            ])
            ->bulkActions([
                // Hilangkan kemampuan bulk delete atau aksi lainnya
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
