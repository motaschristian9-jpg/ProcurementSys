<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::with('category')->latest()->paginate(10);
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
            'item_code' => 'required|string|max:50',
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

        if ($request->ajax() || $request->wantsJson()) {
            session()->flash('success', 'Asset successfully pushed to registry.');
            return response()->json([
                'success' => true,
                'message' => 'Asset successfully pushed to registry!',
            ]);
        }

        return redirect()->back()->with('success', 'Asset successfully pushed to registry.');
    }

    public function edit(Material $material)
    {
        return response()->json($material);
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'item_code' => 'required|string|max:50',
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

        $material->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            session()->flash('success', 'Registry record updated successfully.');
            return response()->json([
                'success' => true,
                'message' => 'Registry record updated successfully.',
            ]);
        }

        return back()->with('success', 'Registry record updated successfully.');
    }

    public function destroy(Request $request, Material $material)
    {
        $material->delete();

        if ($request->ajax() || $request->wantsJson()) {
            session()->flash('success', 'Material removed from registry.');
            return response()->json([
                'success' => true,
                'message' => 'Material removed from registry.',
            ]);
        }

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
                } elseif ($stats['avg_price'] <= 0) {
                    $stats['conclusion'] = "Detailed market analysis is unavailable because the recorded prices for these items are zero or missing. Please update the material prices to enable decision intelligence.";
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header
        fgetcsv($handle);

        $count = 0;
        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($data) < 2) continue; // Skip empty rows

            // Map data: item_code, material, category, brand, size, unit, supplier, price, location, quarter
            $rawCategory = $data[2] ?? 'Uncategorized';
            $categoryName = trim(preg_replace('/\s+/', ' ', $rawCategory));
            $categoryName = ucwords(strtolower($categoryName)); // Standardize to Title Case

            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => \Illuminate\Support\Str::slug($categoryName)]
            );

            Material::create([
                'category_id' => $category->id,
                'item_code' => $data[0] ?? 'N/A',
                'material' => $data[1] ?? 'Unknown',
                'brand' => $data[3] ?? null,
                'size' => $data[4] ?? null,
                'unit' => $data[5] ?? null,
                'supplier' => $data[6] ?? null,
                'price' => is_numeric($data[7] ?? null) ? $data[7] : 0,
                'location' => in_array($data[8] ?? '', ['Davao', 'Local']) ? $data[8] : 'Local',
                'quarter' => $data[9] ?? null,
                'date' => now(),
            ]);
            $count++;
        }

        fclose($handle);

        session()->flash('success', "$count materials successfully imported to registry.");
        return response()->json([
            'success' => true,
            'message' => "$count materials successfully imported!",
        ]);
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=material_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['item_code', 'material', 'category', 'brand', 'size', 'unit', 'supplier', 'price', 'location', 'quarter'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            // Add a sample row
            fputcsv($file, ['MAT-001', 'Sample Material', 'Construction', 'Grand', '10mm', 'pc', 'Supplier Co.', '150.00', 'Local', 'Q1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('error', 'No items selected for deletion.');
        }

        Material::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' materials have been removed from registry.');
    }
}
