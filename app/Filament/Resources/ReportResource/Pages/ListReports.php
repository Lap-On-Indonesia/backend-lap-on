<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('Export PDF')
                ->label('Ekspor PDF')
                ->action('exportPdf'),
        ];
    }

    // Menambahkan bulk action untuk ekspor PDF berdasarkan pilihan tabel
    protected function getTableBulkActions(): array
    {
        return [
            Actions\BulkAction::make('Ekspor PDF')
                ->action(function (Collection $records) {
                    $pdf = Pdf::loadView('exports.report', ['reports' => $records]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'selected_reports.pdf'
                    );
                }),
        ];
    }

    public function exportPdf()
    {
        $reports = ReportResource::getEloquentQuery()->get();
        $pdf = Pdf::loadView('exports.report', ['reports' => $reports]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'reports.pdf'
        );
    }
}
