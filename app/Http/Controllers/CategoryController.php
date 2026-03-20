<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('materials')
            ->with(['materials' => function($q) {
                $q->select('id', 'category_id', 'brand');
            }])
            ->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'New inventory category successfully registered.');
    }

    public function show(Request $request, Category $category)
    {
        $query = $category->materials();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('material', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $materials = $query->latest()->paginate(10);

        return view('categories.show', compact('category', 'materials'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No items selected for deletion.');
        }

        Category::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' categories have been removed.');
    }
}
