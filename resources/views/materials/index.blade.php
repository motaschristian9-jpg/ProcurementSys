@extends('layouts.app')

@section('title', 'Master Inventory Ledger')

@section('content')
<div class="space-y-8 pb-12">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">
                Asset <span class="text-indigo-600">Registry</span>
            </h1>
            <p class="text-[13px] text-slate-500 font-medium mt-1">Unified ledger of construction materials and procurement specifications.</p>
        </div>

        <button onclick="openMaterialModal()" class="bg-indigo-600 text-white rounded-2xl h-14 px-8 text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-500/20 italic flex items-center gap-3 w-full sm:w-auto justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            Register Asset
        </button>
    </div>

    <!-- Corporate Ledger Table -->
    <div class="corporate-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ref. Code</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Material Identification</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Specifications</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Unit Value</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($materials as $item)
                    <tr class="hover:bg-indigo-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-[11px] font-black text-slate-950 bg-white px-2.5 py-1 rounded-lg border border-slate-200 italic shadow-sm">
                                #{{ $item->item_code }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-slate-900 block group-hover:text-indigo-600 transition-colors uppercase leading-none">{{ $item->material }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 inline-block">{{ $item->supplier ?: 'Vetted Source' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100 uppercase tracking-tighter">
                                {{ $item->category->name }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-[11px] font-black text-slate-700 uppercase italic leading-none">{{ $item->size ?: 'Standard' }}</span>
                                <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase tracking-tighter">Unit: {{ $item->unit ?: 'pc' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-[13px] font-black text-slate-950 italic leading-none">₱{{ number_format($item->price, 2) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='openMaterialModal(@json($item))' class="p-2.5 rounded-xl text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md transition-all" title="Edit Record">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="confirmDelete({{ $item->id }})" class="p-2.5 rounded-xl text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md transition-all" title="Remove Record">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-[10px] italic">No organizational assets registered</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($materials->count() > 0)
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-between items-center">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Inventory Ledger Secure</span>
            <span class="text-[10px] font-black text-slate-900 tracking-tighter uppercase italic">DCJ'S Construction Services</span>
        </div>
        @endif
    </div>

</div>
@endsection
