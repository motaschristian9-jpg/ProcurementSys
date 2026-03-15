<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'category_id',
        'item_code',
        'material',
        'size',
        'unit',
        'supplier',
        'brand',
        'price',
        'quarter',
        'date',
        'purchased',
        'location'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
