@extends('layouts.app')

@section('title', 'Market Intelligence')

@section('content')
<div class="space-y-8 pb-12">

    <!-- Header & Search -->
    <div class="bg-slate-950 rounded-4xl p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 rounded-full blur-[100px] -mr-32 -mt-32"></div>
        
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-500 text-[10px] font-black uppercase tracking-[0.3em] mb-6">
                    <span class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    Market Intelligence
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase italic mb-4">Price <span class="text-indigo-500">Analyzer</span></h1>
                <p class="text-slate-400 text-sm font-medium tracking-wide leading-relaxed">Cross-reference material costs across our supplier network. Identify peak procurement efficiency and market-leading vendor rates.</p>
            </div>

            <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-2 rounded-4xl shadow-2xl">
                <form action="{{ route('materials.compare') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <select name="category_id" class="w-full sm:w-48 pl-6 pr-10 py-5 rounded-3xl border-none focus:ring-4 focus:ring-indigo-500/20 transition-all text-[11px] font-black uppercase tracking-widest bg-slate-900 text-slate-400 italic appearance-none cursor-pointer">
                        <option value="">All Sectors</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter Item Code" 
                            class="w-full pl-12 pr-6 py-5 rounded-3xl border-none focus:ring-4 focus:ring-indigo-500/20 transition-all text-sm font-black italic bg-slate-900 text-white placeholder-slate-500">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white rounded-3xl px-8 py-5 justify-center text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-slate-950 transition-all shadow-none italic shrink-0">
                        Analyze
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(request('search') || request('category_id'))
    <div class="space-y-8">
        <!-- Market Pulse Summary -->
        @if($materials->isNotEmpty())
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3 corporate-card p-8 bg-white relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Visual Analysis</span>
                        <h4 class="text-xl font-black text-slate-900 italic tracking-tight uppercase">Price <span class="text-indigo-600">Distribution</span></h4>
                    </div>
                    <div class="flex items-center gap-2">
                         <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                         <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Live Market Data</span>
                    </div>
                </div>
                <!-- Chart Container -->
                <div class="h-[300px] md:h-[400px] w-full bg-slate-50/50 rounded-2xl p-4">
                    <canvas id="priceChart"></canvas>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-950 p-8 rounded-3xl shadow-xl flex flex-col relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.3em] mb-4">Strategic Intel</span>
                    <h4 class="text-xl font-black text-white italic uppercase leading-tight mb-4">Market <span class="text-indigo-500">Conclusion</span></h4>
                    <p class="text-[12px] text-slate-400 font-medium leading-relaxed italic z-10">{{ $stats['conclusion'] }}</p>
                    <div class="mt-8 pt-6 border-t border-white/5 flex items-center justify-between">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Logic: V2.1-Analytics</span>
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>

                <div class="bg-indigo-600 p-8 rounded-3xl shadow-lg flex flex-col">
                    <span class="text-[10px] font-black text-indigo-100 uppercase tracking-widest mb-2">Market Sample</span>
                    <span class="text-3xl font-black text-white italic leading-none">{{ $stats['count'] }} <span class="text-indigo-200 text-sm">Active Units</span></span>
                    <p class="text-[10px] text-indigo-100/60 uppercase tracking-widest mt-4 font-bold">Cross-referenced across vetted sources</p>
                </div>
            </div>
        </div>

        <!-- Metric Matrix -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col group hover:border-indigo-200 transition-all">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Average Valuation</span>
                <span class="text-2xl font-black text-slate-950 italic">₱{{ number_format($stats['avg_price'], 2) }}</span>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col group hover:border-emerald-200 transition-all">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Optimal Entry</span>
                    <span class="text-[8px] font-black bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded uppercase">Target</span>
                </div>
                <span class="text-2xl font-black text-slate-950 italic">₱{{ number_format($stats['min_price'], 2) }}</span>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col group hover:border-rose-200 transition-all">
                <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-2">Peak Threshold</span>
                <span class="text-2xl font-black text-slate-950 italic">₱{{ number_format($stats['max_price'], 2) }}</span>
            </div>
        </div>
        @endif

        <div class="flex items-center justify-between px-4">
            <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-[0.2em] italic flex items-center gap-3">
                <span class="text-indigo-600">@if(request('search')) "{{ request('search') }}" @else All Sectors @endif</span>
                Comparative Market Report
            </h3>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white border border-slate-100 px-3 py-1.5 rounded-xl">Registry Verified</span>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @forelse($materials as $index => $item)
            <div class="corporate-card group hover:border-indigo-300 transition-all duration-500 relative overflow-hidden bg-white">
                @php
                    $diffFromAvg = $stats['avg_price'] > 0 ? (($item->price - $stats['avg_price']) / $stats['avg_price']) * 100 : 0;
                    $positionInRange = $stats['price_range'] > 0 ? (($item->price - $stats['min_price']) / $stats['price_range']) * 100 : 0;
                @endphp

                @if($index == 0)
                <div class="absolute top-0 right-10 bg-emerald-600 text-white px-6 py-2.5 rounded-b-2xl shadow-lg shadow-emerald-500/20 z-10 transition-transform group-hover:translate-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest italic">Efficiency Leader</span>
                </div>
                @elseif($item->price > $stats['avg_price'] * 1.2)
                <div class="absolute top-0 right-10 bg-slate-900 text-white px-6 py-2.5 rounded-b-2xl shadow-lg z-10 transition-transform group-hover:translate-y-1">
                    <span class="text-[10px] font-black uppercase tracking-widest italic">Premium Tier</span>
                </div>
                @endif

                <div class="p-8 md:p-10 flex flex-col gap-10">
                    <div class="flex flex-col md:flex-row md:items-center gap-8 md:gap-12">
                        <!-- Rank & Code -->
                        <div class="flex items-center gap-6">
                            <div class="h-20 w-20 rounded-3xl {{ $index == 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($item->price > $stats['avg_price'] ? 'bg-slate-50 text-slate-400 border border-slate-100' : 'bg-indigo-50 text-indigo-600 border border-indigo-100') }} flex items-center justify-center shrink-0 transition-transform group-hover:rotate-3 shadow-sm">
                                <span class="text-3xl font-black italic">#{{ $index + 1 }}</span>
                            </div>
                            <div class="flex flex-col border-r border-slate-100 pr-8">
                                <h4 class="text-2xl font-black text-slate-900 tracking-tighter uppercase group-hover:text-indigo-600 transition-colors leading-none italic">{{ $item->material }}</h4>
                                <div class="flex items-center gap-3 mt-3">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-2 py-1 rounded border border-slate-100">{{ $item->item_code }}</span>
                                    <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest">{{ $item->category->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Data Points -->
                        <div class="flex-1 grid grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Source Intelligence</span>
                                <span class="text-xs font-black text-slate-900 uppercase italic group-hover:text-indigo-600 transition-colors">{{ $item->supplier ?: 'Vetted Source' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">{{ $item->location }} &bull; {{ $item->brand ?: 'N/A' }}</span>
                            </div>
                            
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Specifications</span>
                                <span class="text-xs font-black text-slate-700 uppercase italic">{{ $item->size ?: 'Standard' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">Measure: {{ $item->unit ?: 'pcs' }}</span>
                            </div>

                            <div class="flex flex-col text-right">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unit Valuation</span>
                                <span class="text-2xl font-black text-slate-950 italic group-hover:text-indigo-600 transition-all">₱{{ number_format($item->price, 2) }}</span>
                                <div class="flex flex-col mt-1">
                                    @if($diffFromAvg < 0)
                                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-tighter">{{ number_format(abs($diffFromAvg), 1) }}% Below Market Average</span>
                                    @else
                                    <span class="text-[9px] font-black text-rose-500 uppercase tracking-tighter">+{{ number_format($diffFromAvg, 1) }}% Above Market Average</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Price Analysis Section -->
                    <div class="pt-8 border-t border-slate-50 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="space-y-3">
                            <div class="flex justify-between items-end">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Market Range Positioning</span>
                                <span class="text-[10px] font-black {{ $positionInRange < 30 ? 'text-emerald-500' : ($positionInRange > 70 ? 'text-rose-500' : 'text-indigo-500') }} uppercase italic">
                                    @if($positionInRange == 0) Optimal Entry Point @elseif($positionInRange == 100) Price Ceiling @else {{ number_format($positionInRange, 1) }}% Percentile @endif
                                </span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden flex border border-slate-100">
                                <div class="h-full {{ $positionInRange < 30 ? 'bg-emerald-500' : ($positionInRange > 70 ? 'bg-rose-500' : 'bg-indigo-500') }} transition-all duration-1000" style="width: {{ $positionInRange }}%"></div>
                            </div>
                            <div class="flex justify-between text-[8px] font-black text-slate-300 uppercase tracking-[0.2em]">
                                <span>₱{{ number_format($stats['min_price'], 0) }} (Min)</span>
                                <span>₱{{ number_format($stats['max_price'], 0) }} (Max)</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-8 justify-end">
                            <div class="flex flex-col items-end">
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Savings Potential</span>
                                <span class="text-sm font-black text-slate-950 italic">
                                    @if($index == 0)
                                    <span class="text-emerald-500 text-[10px] uppercase">Peak Savings Selected</span>
                                    @else
                                    ₱{{ number_format($item->price - $stats['min_price'], 2) }} <span class="text-slate-400 text-[10px] ml-1">Total Gap</span>
                                    @endif
                                </span>
                            </div>
                            <button class="px-6 py-2.5 rounded-xl bg-slate-950 text-white text-[9px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all italic">
                                Source Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="corporate-card p-24 flex flex-col items-center text-center">
                <div class="h-24 w-24 bg-slate-50 text-slate-200 flex items-center justify-center rounded-3xl border border-slate-100 mb-6">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-2xl font-black text-slate-950 uppercase tracking-tight italic">Insufficient Intelligence</h4>
                <p class="text-[13px] text-slate-400 font-medium max-w-sm mt-2">The registry contains no data matches for your parameters. Please refine your search criteria.</p>
                <a href="{{ route('materials.compare') }}" class="mt-8 text-[11px] font-black text-indigo-600 hover:text-indigo-700 uppercase tracking-widest border-b-2 border-indigo-100 pb-1 italic transition-all">Reset Analysis Console</a>
            </div>
            @endforelse
        </div>
    </div>
    @else
    <div class="corporate-card border-none shadow-none bg-white p-20 flex flex-col items-center text-center">
        <div class="w-full max-w-2xl">
            <div class="text-indigo-500/20 mb-8 flex justify-center">
                <svg class="h-24 w-24 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h4 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter mb-4">Registry Analysis <span class="text-indigo-600">Pending</span></h4>
            <p class="text-slate-500 font-medium text-lg leading-relaxed mb-12">Initialize market analysis by entering a technical search term. Our engine will cross-reference all vetted construction vendors in real-time.</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-indigo-200 transition-all">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Intelligence</p>
                    <span class="text-[11px] font-black text-slate-950 uppercase italic">Real-time</span>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-indigo-200 transition-all">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Network</p>
                    <span class="text-[11px] font-black text-slate-950 uppercase italic">Multi-source</span>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-indigo-200 transition-all">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Valuation</p>
                    <span class="text-[11px] font-black text-slate-950 uppercase italic">Ranked</span>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-indigo-200 transition-all">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 leading-none">Assets</p>
                    <span class="text-[11px] font-black text-slate-950 uppercase italic">Unified</span>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('priceChart').getContext('2d');
    
    // Prepare data from Blade
    const labels = [
        @foreach($materials as $item)
            "{{ $item->supplier ?: 'Vetted Source' }}",
        @endforeach
    ];
    
    const prices = [
        @foreach($materials as $item)
            {{ $item->price }},
        @endforeach
    ];

    const avgPrice = {{ $stats['avg_price'] }};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Unit Price (₱)',
                data: prices,
                backgroundColor: prices.map(p => p <= avgPrice ? 'rgba(79, 70, 229, 0.8)' : 'rgba(15, 23, 42, 0.8)'),
                borderRadius: 12,
                borderSkipped: false,
                barThickness: 32,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { size: 10, weight: '900', family: 'Inter' },
                    bodyFont: { size: 12, weight: 'bold', family: 'Inter' },
                    callbacks: {
                        label: function(context) {
                            return ' ₱' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.03)', drawBorder: false },
                    ticks: {
                        font: { size: 10, weight: 'bold', family: 'Inter' },
                        color: '#94a3b8',
                        callback: function(value) { return '₱' + value.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 9, weight: '900', family: 'Inter' },
                        color: '#64748b',
                        callback: function(val, index) {
                            const label = this.getLabelForValue(val);
                            return label.length > 12 ? label.substr(0, 10) + '..' : label;
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutElastic'
            }
        }
    });
});
</script>
@endpush
@endsection
