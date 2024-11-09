<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportResource extends Resource
{
    // Ubah model menjadi Report, bukan WithdrawRequest
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $label = 'Report';

    public static function form(Form $form): Form
    {
        // Resource ini hanya untuk tampilan data, jadi form bisa dikosongkan
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction')
                    ->label('Transaction')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('Mingguan')
                    ->query(fn ($query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
                Tables\Filters\Filter::make('Bulanan')
                    ->query(fn ($query) => $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])),
                Tables\Filters\Filter::make('Tahunan')
                    ->query(fn ($query) => $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])),
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Ekspor Excel')
                    ->action(function (array $records) {
                        // Ekspor ke Excel
                        return Excel::download(new ReportsExport($records), 'report.xlsx');
                    }),
                Tables\Actions\BulkAction::make('Ekspor PDF')
                    ->action(function (array $records) {
                        // Ekspor ke PDF
                        $pdf = Pdf::loadView('exports.report', ['reports' => $records]);
                        return $pdf->download('report.pdf');
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
        ];
    }
}
