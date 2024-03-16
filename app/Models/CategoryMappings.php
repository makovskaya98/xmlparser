<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMappings extends Model
{
    use HasFactory;

    protected $fillable = [
        'feeds_id',
        'category_id',
        'external_id'
    ];

    public function feeds()
    {
        return $this->belongsTo(Feeds::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
