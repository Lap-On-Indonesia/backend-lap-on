<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
    ];
}
