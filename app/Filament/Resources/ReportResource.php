<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use App\Models\Booking;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public static function getNavigationGroup(): ?string
    {
        return 'Admin Management';
    }

    protected static ?string $label = 'Report';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('booking_id')
                ->label('Booking')
                ->options(Booking::all()->pluck('id', 'id')) // Tampilkan daftar Booking ID
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $booking = Booking::with('venue')->find($state);

                    if ($booking) {
                        // Isi data otomatis berdasarkan relasi Booking dan Venue
                        $set('transaction', 'Booking at ' . $booking->venue->name);
                        $set('total', $booking->total_payment ?? 0); // Ambil total_payment dari Booking
                    }
                }),

            Forms\Components\TextInput::make('transaction')
                ->label('Transaction')
                ->disabled(), // Kolom ini otomatis diisi, jadi tidak perlu diinput

            Forms\Components\TextInput::make('total')
                ->label('Total')
                ->numeric()
                ->disabled(), // Kolom ini otomatis diisi, jadi tidak perlu diinput
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction')
                    ->label('Transaction')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking.id')
                    ->label('Booking ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Payment')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime('d/m/Y H:i'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'), // Tambahkan halaman Create
        ];
    }
}
