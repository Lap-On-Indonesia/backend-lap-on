<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $timestamps = true;
    protected $fillable = [
        'name_product',
        'owner_marketplace_id',
        'category_marketplace_id', // pastikan kolom ini ada
        'description',
        'price',
    ];

    public function categoryMarketplace()
    {
        return $this->belongsTo(CategoryMarketplace::class, 'category_marketplace_id');
    }

    public function ownerMarketplace()
    {
        return $this->belongsTo(OwnerMarketplace::class, 'owner_marketplace_id');
    }

    public function transactionMarketplace()
    {
        return $this->hasMany(TransactionMarketplace::class);
    }
}
