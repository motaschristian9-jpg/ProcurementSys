<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    public function getBadgeColorAttribute()
    {
        $colors = [
            'concreate-works' => 'blue',
            'masonry-works' => 'emerald',
            'roofing' => 'rose',
            'carpentry-works' => 'amber',
            'plumbing-sanitary-materials' => 'cyan',
            'structural-steel-and-metal' => 'slate',
            'doors' => 'indigo',
            'windows-and-glass' => 'violet',
            'architectural-finishes' => 'fuchsia',
            'ceiling-works' => 'orange',
            'electrical' => 'yellow',
            'hardware-consumables' => 'teal',
        ];

        return $colors[$this->slug] ?? 'gray';
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
