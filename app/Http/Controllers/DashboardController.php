<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_materials' => Material::count(),
            'total_categories' => Category::count(),
            'total_value' => Material::sum('price'),
            'latest_materials' => Material::with('category')->latest()->take(5)->get(),
            'category_counts' => Category::withCount('materials')->orderBy('materials_count', 'desc')->take(12)->get(),
            'recent_additions_count' => Material::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
