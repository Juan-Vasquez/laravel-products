<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code_product',
        'name_product',
        'quantity',
        'photo_product',
        'price',
        'currency',
        'entry_date',
        'expiration_date',
    ];
}
