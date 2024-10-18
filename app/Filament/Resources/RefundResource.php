<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefundResource\Pages;
use App\Models\Refund;
use Filament\Forms;
use Filament\Tables; // Perbaikan: gunakan Filament\Tables
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table; // Perbaikan: gunakan Filament\Tables\Table
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class RefundResource extends Resource
{
    protected static ?string $model = Refund::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->required(),
                DateTimePicker::make('refund_date_time')
                    ->label('Refund Date and Time')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_payment')
                    ->label('Total Payment')
                    ->numeric()
                    ->required(),
                FileUpload::make('validation_image')
                    ->label('Upload Validation Image')
                    ->image()
                    ->directory('uploads/refund-validations')
                    ->required(),
            ]);
    }

    // Perbaikan: Pastikan signature method table sesuai
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('booking_id')
                    ->label('Booking ID')
                    ->sortable(),
                TextColumn::make('refund_date_time')
                    ->label('Refund Date and Time')
                    ->dateTime(),
                TextColumn::make('status'),
                TextColumn::make('total_payment')
                    ->label('Total Payment'),
                ImageColumn::make('validation_image')
                    ->label('Validation Image'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRefunds::route('/'),
            'create' => Pages\CreateRefund::route('/create'),
            'edit' => Pages\EditRefund::route('/{record}/edit'),
        ];
    }
}
