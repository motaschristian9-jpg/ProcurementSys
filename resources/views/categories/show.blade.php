@extends('layouts.app')

@php $color = $category->badge_color; @endphp

@section('title', $category->name)

@section('content')
<div class="space-y-8 pb-12" x-data="{ 
    selectedIds: [],
    selectAll: false,
    toggleAll() {
        this.selectAll = !this.selectAll;
        this.selectedIds = this.selectAll ? Array.from(document.querySelectorAll('.item-checkbox')).map(cb => cb.value) : [];
    },
    updateSelectAll() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        this.selectAll = checkboxes.length > 0 && this.selectedIds.length === checkboxes.length;
    },
    async performBulkDelete() {
        confirmAction({
            title: 'Bulk De-list Assets',
            message: `Are you sure you want to remove ${this.selectedIds.length} selected items from the operational registry? This action cannot be undone.`,
            buttonText: 'Remove All Selected',
            onConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('materials.bulk-delete') }}';
                
                const csrfToken = document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}';
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                this.selectedIds.forEach(id => {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'ids[]';
                    idInput.value = id;
                    form.appendChild(idInput);
                });

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
}">

    <!-- Action Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div>
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-lg active:scale-95 transition-transform shrink-0">
                     <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase italic leading-none">{{ $category->name }}</h1>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-2 flex items-center gap-2 italic">
                        <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                        Category Registry &bull; {{ $materials->total() }} Assets
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <!-- Bulk Delete Button (Conditional) -->
            <button x-show="selectedIds.length > 0" 
                    @click="performBulkDelete()"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="bg-rose-50 text-rose-600 border border-rose-100 rounded-xl h-11 px-6 text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm italic flex items-center justify-center gap-2 w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete (<span x-text="selectedIds.length"></span>)
            </button>

             <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="relative flex flex-col sm:flex-row items-center gap-2 w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Filter ledger..." 
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all text-sm font-medium bg-white">
                    <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button type="submit" class="bg-slate-950 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all italic w-full sm:w-auto">
                    Search
                </button>
            </form>
            <button onclick="window.location='{{ route('categories.index') }}'" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all flex items-center gap-2 w-full sm:w-auto justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </button>
        </div>
    </div>

    <!-- Inventory Registry Table -->
    <div class="corporate-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-center w-10">
                            <input type="checkbox" 
                                   @click="toggleAll()" 
                                   :checked="selectAll"
                                   class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Ref. Code</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Material Identification</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Brand</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Category</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Specifications</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Unit Value</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($materials as $item)
                    <tr class="hover:bg-indigo-50/30 transition-colors group" :class="selectedIds.includes('{{ $item->id }}') ? 'bg-indigo-50/50' : ''">
                        <td class="px-8 py-6 text-center">
                            <input type="checkbox" 
                                   value="{{ $item->id }}" 
                                   x-model="selectedIds"
                                   @change="updateSelectAll()"
                                   class="item-checkbox h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                        </td>
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
                            <span class="text-sm font-black text-slate-700 uppercase italic leading-none">{{ $item->brand ?: '---' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-100 uppercase tracking-tighter">
                                {{ $category->name }}
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
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick='openMaterialModal(@json($item))' class="p-2.5 rounded-xl text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md transition-all" title="Edit Record">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick='initiateMaterialDelete({{ $item->id }}, "{{ $item->material }}")' class="p-2.5 rounded-xl text-slate-400 hover:bg-white hover:text-rose-600 hover:shadow-md transition-all" title="Remove Record">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-[10px] italic">No operational data found in this ledger</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
>
        
        @if($materials->hasPages())
        <div class="px-8 py-6 border-t border-slate-100 bg-white pagination-container">
            {{ $materials->links() }}
        </div>
        @endif

        @if($materials->total() > 0)
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-between items-center">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Registry Secure | Showing {{ $materials->firstItem() }}-{{ $materials->lastItem() }} of {{ $materials->total() }}</span>
            <span class="text-[10px] font-black text-slate-900 tracking-tighter uppercase italic">DCJ'S Construction Services</span>
        </div>
        @endif
    </div>

</div>
@push('scripts')
<script>
    function initiateMaterialDelete(id, name) {
        confirmAction({
            title: 'De-list Item',
            message: `Are you sure you want to remove "${name}" from the operational registry? This action is permanent.`,
            buttonText: 'Remove',
            onConfirm: () => {
                const form = document.getElementById('global-delete-form');
                form.action = `/materials/${id}`;
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
