<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'owner_id',
        'name',
        'description',
        'image',
        'link_maps',
        'latitude',
        'longitude',
        'price',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!is_numeric($model->latitude) || !is_numeric($model->longitude)) {
                throw new \Exception('Latitude and Longitude must be valid numbers.');
            }

            if ($model->latitude < -90 || $model->latitude > 90) {
                throw new \Exception('Latitude must be between -90 and 90 degrees.');
            }

            if ($model->longitude < -180 || $model->longitude > 180) {
                throw new \Exception('Longitude must be between -180 and 180 degrees.');
            }

            if (auth()->check() && !auth()->user()->hasRole('super_admin')) {
                $model->owner_id = auth()->user()->owner_id;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function field()
    {
        return $this->hasMany(Field::class);
    }
}
