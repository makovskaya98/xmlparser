<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeds extends Model
{
    use HasFactory;

    protected $fillable = [
        'url'
    ];

    public function categoryMappings()
    {
        return $this->hasMany(CategoryMappings::class);
    }
}
