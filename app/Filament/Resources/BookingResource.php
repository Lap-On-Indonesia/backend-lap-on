<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
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
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
            Select::make('user_id')
                ->label('User')
                ->options(User::all()->pluck('name', 'id'))
                ->required(),

            Select::make('venue_id')
                ->label('Venue')
                ->options(Venue::all()->pluck('name', 'id'))
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $set('start_time', null);
                    $set('end_time', null);
                    $set('total_payment', null);

                    // Ambil harga per jam dari venue yang dipilih
                    if ($state) {
                        $venue = Venue::find($state);
                        if ($venue) {
                            $set('price_per_hour', $venue->price);
                            $set('tax_percentage', 11); // Set default tax percentage
                        }
                    }
                }),

            DatePicker::make('booking_date')
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
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
                }),

            TimePicker::make('start_time')
                ->required()
                ->label('Start Time')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    self::calculateTotalPayment($get, $set);
                }),

            TimePicker::make('end_time')
                ->required()
                ->label('End Time')
                ->reactive()
                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                    self::calculateTotalPayment($get, $set);
                }),

            TextInput::make('price_per_hour')
                ->label('Price per Hour')
                ->numeric()
                ->required()
                ->disabled()
                ->suffix('IDR'),

            TextInput::make('tax_percentage')
                ->label('Tax Percentage')
                ->numeric()
                ->default(11)
                ->required()
                ->disabled()
                ->suffix('%'),

            TextInput::make('total_payment')
                ->label('Total Payment')
                ->numeric()
                ->disabled()
                ->suffix('IDR'),
        ]);
}

protected static function calculateTotalPayment(callable $get, callable $set)
{
    $venueId = $get('venue_id');
    $bookingDate = $get('booking_date');
    $startTime = $get('start_time');
    $endTime = $get('end_time');
    $pricePerHour = $get('price_per_hour');
    $taxPercentage = $get('tax_percentage') ?? 11; // Set default tax percentage jika tidak ada

    if ($venueId && $bookingDate && $startTime && $endTime && $pricePerHour) {
        $startTime = Carbon::parse($startTime);
        $endTime = Carbon::parse($endTime);
        $durationInHours = $endTime->diffInHours($startTime);

        if ($durationInHours > 0) {
            $totalPayment = $durationInHours * $pricePerHour;
            $taxAmount = $totalPayment * ($taxPercentage / 100);
            $totalPaymentWithTax = $totalPayment + $taxAmount;

            $set('total_payment', $totalPaymentWithTax);
        } else {
            $set('total_payment', null); // Reset jika durasi tidak valid
        }
    } else {
        $set('total_payment', null); // Reset jika ada input yang hilang
    }
}



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_id')
                    ->label('Booking ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('venue.name')
                    ->label('Venue')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking_date')->sortable(),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
                TextColumn::make('total_payment')
                    ->money('IDR'),
                TextColumn::make('created_at')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                // Hilangkan kemampuan bulk delete atau aksi lainnya
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Cek apakah pengguna adalah super admin
        if (Auth::user()->hasRole('super_admin')) {
            return $query;
        }

        // Jika bukan super admin, filter booking berdasarkan venue yang dimiliki oleh owner
        return $query->whereHas('venue', function (Builder $venueQuery) {
            $venueQuery->where('owner_id', Auth::user()->owner_id);
        });
    }
}
