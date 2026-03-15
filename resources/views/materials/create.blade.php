@extends('layouts.app')

@section('title', 'Add New Material')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white p-6 rounded-3xl border border-gray-100 shadow-xs">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-semibold uppercase tracking-widest text-indigo-400">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a></li>
                    <li><span class="mx-2 text-gray-300">/</span></li>
                    <li><a href="{{ route('materials.index') }}" class="hover:text-indigo-600 transition-colors">Materials</a></li>
                    <li><span class="mx-2 text-gray-300">/</span></li>
                    <li class="text-indigo-600">Register</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight italic">Register Material</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Add a new item to the system inventory.</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <a href="{{ route('materials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-50 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-100 transition-all border border-gray-200 uppercase tracking-wide">
                &larr; View All List
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-3xl shadow-xs border border-gray-100 overflow-hidden">
        <form action="{{ route('materials.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Section: Classification -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-[0.2em]">Item Classification</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                        <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Item Code</label>
                        <input type="text" name="item_code" value="{{ old('item_code') }}" required placeholder="e.g., CW-001"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                        @error('item_code') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Section: Material Details -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-[0.2em]">Material Specification</h2>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Material Description</label>
                    <input type="text" name="material" value="{{ old('material') }}" required placeholder="e.g., Portland Cement"
                        class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium font-bold">
                    @error('material') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Size</label>
                        <input type="text" name="size" value="{{ old('size') }}" placeholder="e.g., 40kg"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Unit</label>
                        <input type="text" name="unit" value="{{ old('unit') }}" placeholder="e.g., bag"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand') }}" placeholder="e.g., Holcim"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                    </div>
                </div>
            </div>

            <!-- Section: Procurement Info -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-1 bg-indigo-500 rounded-full"></div>
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-[0.2em]">Procurement Data</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Supplier</label>
                        <input type="text" name="supplier" value="{{ old('supplier') }}" placeholder="Company Name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Price (PHP)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-400 font-bold">₱</span>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00"
                                class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-black">
                        </div>
                        @error('price') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Quarter</label>
                        <input type="text" name="quarter" value="{{ old('quarter') }}" placeholder="e.g., 1Q"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Date Purchased</label>
                        <input type="date" name="date" value="{{ old('date') }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-medium uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Purchased At</label>
                        <select name="location" required class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm font-black uppercase tracking-tighter">
                            <option value="Local" {{ old('location') == 'Local' ? 'selected' : '' }}>Local</option>
                            <option value="Davao" {{ old('location') == 'Davao' ? 'selected' : '' }}>Davao</option>
                        </select>
                        @error('location') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Action Progress -->
            <div class="pt-6 border-t border-gray-50 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 bg-white text-gray-400 text-sm font-bold rounded-xl hover:text-gray-600 transition-all uppercase tracking-[0.1em]">
                    Clear Form
                </button>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white text-sm font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 active:scale-95 uppercase tracking-[0.2em] italic">
                    Push to Inventory &rarr;
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
