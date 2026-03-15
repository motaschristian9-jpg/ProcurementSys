<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::with('category')->latest()->get();
        $total_items = Material::count();

        return view('materials.index', compact('materials', 'total_items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_code' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quarter' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'location' => 'required|in:Davao,Local',
        ]);

        Material::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Material added successfully!',
            ]);
        }

        return redirect()->back()->with('success', 'Material added successfully!');
    }

    public function edit(Material $material)
    {
        return response()->json($material);
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'material' => 'required|string|max:255',
            'item_code' => 'required|string|max:50|unique:materials,item_code,' . $material->id,
            'size' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:20',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:100'
        ]);

        $material->update($validated);

        return back()->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return back()->with('success', 'Material removed from registry.');
    }

    public function compare(Request $request)
    {
        $materials = collect();
        $categories = Category::all();
        $stats = [
            'avg_price' => 0,
            'min_price' => 0,
            'max_price' => 0,
            'price_range' => 0,
            'count' => 0
        ];

        if ($request->has('search') || $request->has('category_id')) {
            $query = Material::with('category');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('material', 'like', "%{$search}%")
                      ->orWhere('item_code', 'like', "%{$search}%")
                      ->orWhere('supplier', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%")
                      ->orWhereHas('category', function($cq) use ($search) {
                          $cq->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $materials = $query->orderBy('price', 'asc')->get();

            if ($materials->isNotEmpty()) {
                $prices = $materials->pluck('price');
                $stats['avg_price'] = $prices->avg();
                $stats['min_price'] = $prices->min();
                $stats['max_price'] = $prices->max();
                $stats['price_range'] = $stats['max_price'] - $stats['min_price'];
                $stats['count'] = $materials->count();

                // Advanced Decision Intelligence Logic
                if ($stats['count'] === 1) {
                    $stats['conclusion'] = "Insufficient sample size for comparison. This is currently our only vetted source for this item.";
                } else {
                    $savingsPotential = $stats['avg_price'] - $stats['min_price'];
                    $variancePercent = ($stats['price_range'] / $stats['avg_price']) * 100;

                    if ($variancePercent < 5) {
                        $stats['conclusion'] = "Market prices are highly stable. Variations are negligible (<5%), suggesting a commodity-level pricing structure. Selection should be based on supplier reliability or delivery speed rather than cost.";
                    } elseif ($variancePercent > 25) {
                        $stats['conclusion'] = "Significant market fragmentation detected. Price variation exceeds 25%. We recommend prioritizing the Efficiency Leader ({$materials[0]->supplier}), as the potential savings versus the market peak is ₱" . number_format($stats['price_range'], 2) . ".";
                    } else {
                        $stats['conclusion'] = "Healthy market competition observed. The Efficiency Leader offers a " . number_format(($savingsPotential / $stats['avg_price']) * 100, 1) . "% advantage over the market average. This is a strategic procurement opportunity.";
                    }
                }
            }
        }

        return view('materials.compare', compact('materials', 'categories', 'stats'));
    }
}
