<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_marketplace_id',
        'amount',
        'status',
        'requested_at',
    ];

    public function transactionMarketplace()
    {
        return $this->belongsTo(TransactionMarketplace::class);
    }
}
