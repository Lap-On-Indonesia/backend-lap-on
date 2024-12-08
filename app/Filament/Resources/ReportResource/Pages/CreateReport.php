<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Booking;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil data dari Booking dan relasinya (Venue)
        $booking = Booking::with('venue')->find($data['booking_id']);

        if ($booking) {
            $data['transaction'] = 'Booking at ' . $booking->venue->name;
            $data['total'] = $booking->total_payment ?? 0;
        }

        return $data;
    }
}
