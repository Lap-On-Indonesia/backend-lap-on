<?php

namespace App\Observers;

use App\Models\Owner;
use App\Mail\StatusUpdated;
use Illuminate\Support\Facades\Mail;

class OwnerObserver
{
    /**
     * Handle the Owner "created" event.
     */
    public function created(Owner $owner): void
    {
        //
    }

    /**
     * Handle the Owner "updated" event.
     */
    public function updated(Owner $owner): void
    {
        if ($owner->isDirty('status')) { // Mengecek apakah status berubah
            // Kirim email notifikasi ke owner
            Mail::to($owner->email)->send(new StatusUpdated($owner));
        }
    }

    /**
     * Handle the Owner "deleted" event.
     */
    public function deleted(Owner $owner): void
    {
        //
    }

    /**
     * Handle the Owner "restored" event.
     */
    public function restored(Owner $owner): void
    {
        //
    }

    /**
     * Handle the Owner "force deleted" event.
     */
    public function forceDeleted(Owner $owner): void
    {
        //
    }
}
