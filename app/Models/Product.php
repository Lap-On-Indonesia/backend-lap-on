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
        'category_marketplace_id',
        'description',
        'price',
        'image', // Tambahkan kolom image ke sini
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
