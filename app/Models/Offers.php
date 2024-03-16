<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'feeds_id',
        'url',
        'price',
        'currency_id',
        'category_id',
        'oldprice',
        'picture',
        'store',
        'pickup',
        'delivery',
        'type_prefix',
        'vendor',
        'model',
        'name',
        'vendor_code',
        'description',
        'param'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
