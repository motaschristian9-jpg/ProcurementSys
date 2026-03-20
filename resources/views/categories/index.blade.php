@extends('layouts.app')

@section('title', 'Departments & Inventory')

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
            title: 'Bulk Remove Categories',
            message: `Are you sure you want to remove ${this.selectedIds.length} selected classifications? This will NOT delete the materials inside them but will move them to the default category.`,
            buttonText: 'Remove All Selected',
            onConfirm: () => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('categories.bulk-delete') }}';
                
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

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight italic uppercase">
                Inventory <span class="text-indigo-600">Hub</span>
            </h1>
            <p class="text-[13px] text-slate-500 font-medium mt-1">Browse and manage construction assets across specialized departmental ledgers.</p>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <!-- New Category Button -->
            <button onclick="openCategoryModal()" class="flex-1 sm:flex-none bg-indigo-600 text-white rounded-2xl h-14 px-8 text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-500/20 italic flex items-center gap-3 justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                New Category
            </button>

            <!-- Bulk Delete Button (Conditional) -->
            <button x-show="selectedIds.length > 0" 
                    @click="performBulkDelete()"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="bg-rose-50 text-rose-600 border border-rose-100 rounded-2xl h-14 px-6 text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm italic flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Delete Selected (<span x-text="selectedIds.length"></span>)
            </button>

            <div class="px-5 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm text-center w-full sm:w-auto">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</span>
                <span class="text-sm font-black text-emerald-500 italic uppercase">Operational</span>
            </div>
        </div>
    </div>

    <!-- Corporate Ledger Table -->
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
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Classification</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Associated Brands</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Asset Count</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-indigo-50/30 transition-colors group cursor-pointer" 
                        :class="selectedIds.includes('{{ $category->id }}') ? 'bg-indigo-50/50' : ''"
                        @click="window.location='{{ route('categories.show', $category->slug) }}'">
                        <td class="px-8 py-6 text-center" @click.stop>
                            <input type="checkbox" 
                                   value="{{ $category->id }}" 
                                   x-model="selectedIds"
                                   @change="updateSelectAll()"
                                   class="item-checkbox h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <span class="text-sm font-black text-slate-900 block group-hover:text-indigo-600 transition-colors uppercase leading-none">{{ $category->name }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 inline-block">Specialized Registry</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-wrap gap-1">
                                @php
                                    $brands = $category->materials->pluck('brand')->unique()->filter()->take(3);
                                @endphp
                                @forelse($brands as $brand)
                                    <span class="text-[9px] font-black text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100 uppercase">{{ $brand }}</span>
                                @empty
                                    <span class="text-[9px] font-bold text-slate-400 uppercase italic">No brands listed</span>
                                @endforelse
                                @if($category->materials->pluck('brand')->unique()->filter()->count() > 3)
                                    <span class="text-[9px] font-bold text-slate-400 uppercase italic">+{{ $category->materials->pluck('brand')->unique()->filter()->count() - 3 }} more</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-sm font-black text-slate-900 italic leading-none">{{ $category->materials_count }}</span>
                        </td>
                        <td class="px-8 py-6" @click.stop>
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('categories.show', $category->slug) }}" class="p-2.5 rounded-xl text-slate-400 hover:bg-white hover:text-indigo-600 hover:shadow-md transition-all" title="View Ledger">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-[10px] italic">No categories mapped in registry</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
        <div class="px-8 py-6 border-t border-slate-100 bg-white pagination-container">
            {{ $categories->links() }}
        </div>
        @endif

        @if($categories->total() > 0)
        <div class="bg-slate-50 px-8 py-4 border-t border-slate-100 flex justify-between items-center">
            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Categories Hub Secure | Showing {{ $categories->firstItem() }}-{{ $categories->lastItem() }} of {{ $categories->total() }}</span>
            <span class="text-[10px] font-black text-slate-900 tracking-tighter uppercase italic">DCJ'S Construction Services</span>
        </div>
        @endif
    </div>

</div>
@endsection
