<?php

namespace App\Observers;

use App\Mail\StatusOwnerMarketplace;
use App\Models\OwnerMarketplace;
use Illuminate\Support\Facades\Mail;

class OwnerMarketplaceObserver
{
    /**
     * Handle the OwnerMarketplace "created" event.
     */
    public function created(OwnerMarketplace $ownerMarketplace): void
    {
        //
    }

    /**
     * Handle the OwnerMarketplace "updated" event.
     */
    public function updated(OwnerMarketplace $ownerMarketplace): void
    {
        if ($ownerMarketplace->isDirty('status')) { // Mengecek apakah status berubah

            // Kirim email notifikasi ke owner
            Mail::to($ownerMarketplace->email)->send(new StatusOwnerMarketplace($ownerMarketplace));
        }
    }

    /**
     * Handle the OwnerMarketplace "deleted" event.
     */
    public function deleted(OwnerMarketplace $ownerMarketplace): void
    {
        //
    }

    /**
     * Handle the OwnerMarketplace "restored" event.
     */
    public function restored(OwnerMarketplace $ownerMarketplace): void
    {
        //
    }

    /**
     * Handle the OwnerMarketplace "force deleted" event.
     */
    public function forceDeleted(OwnerMarketplace $ownerMarketplace): void
    {
        //
    }
}
