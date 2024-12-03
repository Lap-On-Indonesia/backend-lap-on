<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RefundResource\Pages;
use App\Models\Refund;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn; // Pastikan untuk mengimpor ImageColumn

class RefundResource extends Resource
{
    protected static ?string $model = Refund::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->label('Booking')
                    ->required(),
                DateTimePicker::make('refund_date_time')
                    ->label('Refund Date and Time')
                    ->required(),
                TextInput::make('status')
                    ->label('Status')
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),
                TextColumn::make('booking_id')
                    ->label('Booking ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('refund_date_time')
                    ->label('Refund Date and Time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('total_payment')
                    ->label('Total Payment')
                    ->sortable(),
                ImageColumn::make('validation_image')
                    ->label('Validation Image')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Anda bisa menambahkan filter jika diperlukan
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
