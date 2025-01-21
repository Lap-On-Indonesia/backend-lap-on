<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $timestamps = true;
    protected $keyType = 'string'; // Menentukan tipe primary key sebagai string
    public $incrementing = false; // Menonaktifkan auto-increment
    protected $fillable = [
        'product_id',
        'name_product',
        'category_marketplace_id',
        'description',
        'owner_marketplace_id',
        'price',
        'image',
        'stock', // Menambahkan field stock ke sini
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_id)) {
                $product->product_id = self::generateProductId();
            }

            if (empty($product->owner_marketplace_id)) {
                $product->owner_marketplace_id = auth()->user()->owner_marketplace_id;
            }
        });
    }

    public static function generateProductId()
    {
        do {
            $productId = strtoupper(Str::random(9)); // Generate string acak 9 karakter
        } while (self::where('product_id', $productId)->exists()); // Pastikan ID unik

        return $productId;
    }

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
