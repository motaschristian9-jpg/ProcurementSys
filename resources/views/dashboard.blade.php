@extends('layouts.app')

@section('title', 'System Analytics')

@section('content')
<div class="space-y-8 pb-12">

    <!-- Hero Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">
                System <span class="text-indigo-600">Analytics</span>
            </h1>
            <p class="text-[13px] text-slate-500 font-medium mt-1">Operational status and procurement overview for DCJ's Construction Services.</p>
        </div>
        
        <div class="flex items-center gap-4 shrink-0">
            <div class="px-5 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-center w-full sm:w-auto">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Server Clock</span>
                <span class="text-sm font-black text-slate-900 italic uppercase">{{ now()->format('H:i') }} <span class="text-indigo-500 font-bold ml-1">PST</span></span>
            </div>
        </div>
    </div>

    <!-- Analytics Matrix -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Items -->
        <div class="corporate-card p-6 flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start">
                <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-2.5 py-1 rounded-lg">Operational</span>
            </div>
            <div class="mt-8">
                <h3 class="text-3xl font-black text-slate-950 italic">{{ $stats['total_materials'] }}</h3>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Active Registry</p>
            </div>
        </div>

        <!-- Latest Entry -->
        <div class="corporate-card p-6 flex flex-col justify-between group hover:border-indigo-200 transition-colors">
            <div class="flex justify-between items-start">
                <div class="h-12 w-12 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 px-2.5 py-1 rounded-lg">Recently Added</span>
            </div>
            <div class="mt-8 overflow-hidden">
                <h3 class="text-xl font-black text-slate-950 truncate italic uppercase leading-none">{{ optional($stats['latest_materials']->first())->material ?? 'No Data' }}</h3>
                <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-[0.2em] mt-3">{{ optional($stats['latest_materials']->first())->created_at ? $stats['latest_materials']->first()->created_at->diffForHumans() : 'N/A' }}</p>
            </div>
        </div>

        <!-- Total Value -->
        <div class="corporate-card p-6 flex flex-col justify-between group hover:border-indigo-200 transition-colors" style="background: linear-gradient(135deg, white 60%, rgba(79, 70, 229, 0.05) 100%)">
            <div class="flex justify-between items-start">
                <div class="h-12 w-12 rounded-xl bg-slate-950 text-indigo-400 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
            </div>
            <div class="mt-8">
                <h3 class="text-2xl font-black text-slate-950 italic tracking-tighter">₱ {{ number_format($stats['total_value'], 2) }}</h3>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2">Inventory Valuation</p>
            </div>
        </div>

        <!-- Quick Action Card -->
        <div class="bg-indigo-600 rounded-2xl p-6 flex flex-col justify-between shadow-corporate group hover:bg-indigo-700 transition-all cursor-pointer overflow-hidden relative" onclick="openMaterialModal()">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
            <div class="relative z-10 flex justify-between items-start">
                <div class="h-10 w-10 rounded-lg bg-white/20 text-white flex items-center justify-center">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
            </div>
            <div class="relative z-10 mt-6">
                <h3 class="text-lg font-black text-white italic uppercase leading-none">New Entry</h3>
                <p class="text-[10px] font-bold text-indigo-100 uppercase tracking-[0.2em] mt-2 italic">Register Material</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left: Sector Visualization -->
        <div class="lg:col-span-2 corporate-card p-8">
            <div class="flex items-center justify-between mb-10">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Operational Structure</span>
                    <h4 class="text-xl font-black text-slate-900 italic tracking-tight uppercase">Departmental <span class="text-indigo-600">Distribution</span></h4>
                </div>
                <a href="{{ route('categories.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors">Review Hub &rarr;</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                @foreach($stats['category_counts'] as $cat)
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 hover:border-indigo-200 transition-all group cursor-pointer" onclick="window.location='{{ route('categories.show', $cat->slug) }}'">
                    <div class="flex justify-between items-center mb-4">
                        <div class="h-8 w-8 rounded-lg bg-white border border-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        </div>
                        <span class="text-[14px] font-black text-slate-950 italic tracking-tighter bg-white px-2 rounded-lg shadow-xs">{{ $cat->materials_count }}</span>
                    </div>
                    <span class="block text-[10px] font-black text-slate-500 uppercase tracking-tight truncate">{{ $cat->name }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Recent Log -->
        <div class="corporate-card overflow-hidden">
            <div class="p-6 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">Registry Activity</h4>
                <div class="flex gap-1.5">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-200"></span>
                </div>
            </div>
            
            <div class="divide-y divide-slate-50 max-h-[480px] overflow-y-auto custom-scrollbar">
                @forelse($stats['latest_materials'] as $item)
                <div class="p-5 flex gap-4 hover:bg-slate-50/50 transition-colors">
                    <div class="h-10 w-10 shrink-0 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600">
                         <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[12px] font-bold text-slate-900 truncate uppercase tracking-tight">{{ $item->material }}</span>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">{{ $item->category->name }}</span>
                            <span class="h-1 w-1 rounded-full bg-slate-200"></span>
                            <span class="text-[9px] font-bold text-indigo-500 uppercase">{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-8 py-20 text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">No recent activity detected</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
