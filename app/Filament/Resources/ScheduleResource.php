<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required()
                    ->label('Venue'),
                Select::make('day_of_week')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->required()
                    ->label('Day of Week'),
                TimePicker::make('start_time')
                    ->required()
                    ->label('Start Time')
                    ->hoursStep(1) // Mengatur interval pemilihan waktu menjadi setiap 1 jam
                    ->withoutSeconds() // Menghilangkan detik dari tampilan
                    ->reactive() // Untuk memungkinkan perubahan end_time ketika start_time diubah
                    ->afterStateUpdated(fn($state, callable $set) => $set('end_time', \Carbon\Carbon::parse($state)->addHour()->format('H:i'))), // Set end_time secara otomatis 1 jam setelah start_time
                TimePicker::make('end_time')
                    ->required()
                    ->label('End Time')
                    ->hoursStep(1) // Mengatur interval pemilihan waktu menjadi setiap 1 jam
                    ->withoutSeconds(), // Menghilangkan detik dari tampilan
                Forms\Components\Toggle::make('is_available')
                    ->label('Is Available')
                    ->default(true)
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
                TextColumn::make('day_of_week')
                    ->label('Day of Week')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_time')
                    ->label('Start Time')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label('End Time')
                    ->sortable(),
                // Perbaikan bagian ini
                TextColumn::make('is_available')
                    ->label('Is Available')
                    ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
