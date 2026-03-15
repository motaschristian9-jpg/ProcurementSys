@extends('layouts.app')

@section('title', 'Departments & Inventory')

@section('content')
<div class="space-y-8 pb-12">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">
                Inventory <span class="text-indigo-600">Hub</span>
            </h1>
            <p class="text-[13px] text-slate-500 font-medium mt-1">Browse and manage construction assets across specialized departmental ledgers.</p>
        </div>
        
        <div class="flex items-center gap-4 shrink-0">
            <div class="px-5 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-center w-full sm:w-auto">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</span>
                <span class="text-sm font-black text-emerald-500 italic uppercase">Operational</span>
            </div>
        </div>
    </div>

    <!-- Category Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            @php $category_color = $category->badge_color; @endphp
            <a href="{{ route('categories.show', $category->slug) }}" class="corporate-card overflow-hidden group">
                <div class="p-8">
                    <div class="flex items-start justify-between mb-8">
                        <div class="h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                             <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="text-right">
                             <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Stock Vol.</span>
                             <span class="text-2xl font-black text-slate-950 italic tracking-tighter">{{ $category->materials_count }}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h3>
                        <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-{{ $category_color }}-500"></span>
                            Specialized Registry
                        </p>
                    </div>
                </div>
                
                <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-indigo-50 transition-colors">
                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                        Open Ledger
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <div class="h-1 w-12 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-indigo-500 w-1/3 group-hover:w-full transition-all duration-500"></div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

</div>
@endsection
