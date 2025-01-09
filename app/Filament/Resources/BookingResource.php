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
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('start_time', null);
                        $set('end_time', null);
                        $set('total_payment', null);
                        $set('tax_percentage', null);

                        // Mengambil harga venue
                        if ($state) {
                            $venue = Venue::find($state);
                            if ($venue) {
                                $set('price_per_hour', $venue->price);
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
                        $venueId = $get('venue_id');
                        $bookingDate = $get('booking_date');
                        $endTime = $get('end_time');

                        if ($venueId && $bookingDate && $state && $endTime) {
                            $schedule = Schedule::where('venue_id', $venueId)
                                ->whereJsonContains('day_of_week', strtolower(Carbon::parse($bookingDate)->format('l')))
                                ->where('is_available', true)
                                ->first();

                            if ($schedule) {
                                $startTime = Carbon::parse($state);
                                $scheduleStartTime = Carbon::parse($schedule->start_time);
                                $scheduleEndTime = Carbon::parse($schedule->end_time);

                                if ($startTime < $scheduleStartTime || $startTime > $scheduleEndTime) {
                                    $set('start_time', null); // Reset start_time jika tidak valid
                                    $set('start_time_error', 'Waktu mulai harus berada dalam rentang ' . $schedule->start_time . ' hingga ' . $schedule->end_time);
                                } else {
                                    $set('start_time_error', null); // Hapus pesan kesalahan jika valid
                                    self::calculateTotalPayment($get, $set);
                                }
                            }
                        }
                    }),

                TimePicker::make('end_time')
                    ->required()
                    ->label('End Time')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $venueId = $get('venue_id');
                        $bookingDate = $get('booking_date');
                        $startTime = $get('start_time');

                        if ($venueId && $bookingDate && $state && $startTime) {
                            $schedule = Schedule::where('venue_id', $venueId)
                                ->whereJsonContains('day_of_week', strtolower(Carbon::parse($bookingDate)->format('l')))
                                ->where('is_available', true)
                                ->first();

                            if ($schedule) {
                                $endTime = Carbon::parse($state);
                                $scheduleStartTime = Carbon::parse($schedule->start_time);
                                $scheduleEndTime = Carbon::parse($schedule->end_time);

                                if ($endTime < $scheduleStartTime || $endTime > $scheduleEndTime) {
                                    $set('end_time', null); // Reset end_time jika tidak valid
                                    $set('end_time_error', 'Waktu selesai harus berada dalam rentang ' . $schedule->start_time . ' hingga ' . $schedule->end_time);
                                } else {
                                    $set('end_time_error', null); // Hapus pesan kesalahan jika valid
                                    self::calculateTotalPayment($get, $set);
                                }
                            }
                        }
                    }),

                TextInput::make('price_per_hour')
                    ->label('Price per Hour')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(fn ($state, callable $get) => $get('venue_id') ? true : false)
                    ->suffix('IDR'), // Menambahkan suffix IDR

                TextInput::make('tax_percentage')
                    ->label('Tax Percentage')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(fn ($state, callable $get) => $get('venue_id') ? true : false)
                    ->default(11)
                    ->suffix('%'), // Menambahkan suffix %

                TextInput::make('total_payment')
                    ->label('Total Payment')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(fn ($state, callable $get) => $get('venue_id') ? true : false)
                    ->suffix('IDR'), // Menambahkan suffix IDR
            ]);
    }

    protected static function calculateTotalPayment(callable $get, callable $set)
    {
        $venueId = $get('venue_id');
        $bookingDate = $get('booking_date');
        $startTime = $get('start_time');
        $endTime = $get('end_time');

        if ($venueId && $bookingDate && $startTime && $endTime) {
            $schedule = Schedule::where('venue_id', $venueId)
                ->whereJsonContains('day_of_week', strtolower(Carbon::parse($bookingDate)->format('l')))
                ->where('is_available', true)
                ->first();

            if ($schedule) {
                $startTime = Carbon::parse($startTime);
                $endTime = Carbon::parse($endTime);

                if ($startTime >= $schedule->start_time && $endTime <= $schedule->end_time) {
                    $durationInHours = $endTime->diffInHours($startTime);
                    $pricePerHour = $get('price_per_hour');

                    if ($pricePerHour) {
                        $totalPayment = $durationInHours * $pricePerHour;
                        $taxPercentage = 11;
                        $taxAmount = $totalPayment * ($taxPercentage / 100);
                        $totalPaymentWithTax = $totalPayment + $taxAmount;

                        $set('total_payment', $totalPaymentWithTax);
                        $set('tax_percentage', $taxPercentage);
                    }
                } else {
                    $set('total_payment', null);
                    $set('tax_percentage', null);
                }
            }
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
                TextColumn::make('booking_date'),
                TextColumn::make('start_time'),
                TextColumn::make('end_time'),
                TextColumn::make('venue.price')
                    ->label('Price per Hour')
                    ->money('IDR'), // Format harga per jam dalam IDR
                TextColumn::make('tax_percentage')
                    ->suffix('%'), // Menampilkan hanya persentase pajak
                TextColumn::make('total_payment')
                    ->money('IDR'), // Format total pembayaran dalam IDR
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
