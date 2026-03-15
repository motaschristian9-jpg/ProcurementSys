<div id="materialModal" class="fixed inset-0 z-50 invisible opacity-0 transition-all duration-500 overflow-y-auto custom-scrollbar">
    <!-- glass backdrop -->
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xl transition-opacity duration-500" onclick="closeMaterialModal()"></div>
    
    <!-- Modal Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl bg-white rounded-[2.5rem] shadow-[0_50px_100px_-20px_rgba(15,23,42,0.4)] border border-slate-200 overflow-hidden transform scale-95 transition-all duration-500" id="modalCard">
            
            <!-- Modal Header -->
            <div class="p-10 bg-slate-950 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-500 text-[9px] font-black uppercase tracking-[0.2em] mb-4">
                            Operational Registry
                        </div>
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter" id="modalTitle">Material <span class="text-indigo-500">Registration</span></h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2" id="modalSubtitle">Push new assets to official construction inventory</p>
                    </div>
                    <button onclick="closeMaterialModal()" class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <form id="materialForm" class="p-10 space-y-12">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="material_id" id="materialId">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Left Column: Identity -->
                    <div class="space-y-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-6 w-1.5 bg-indigo-600 rounded-full"></div>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.3em]">Material Identity</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Department Hub</label>
                                    <select name="category_id" id="field_category_id" required class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black uppercase tracking-tighter italic">
                                        <option value="">Select Classification</option>
                                        @foreach(\App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Identification Code</label>
                                    <input type="text" name="item_code" id="field_item_code" required placeholder="e.g., CW-001" 
                                        class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black italic">
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Official Description</label>
                                    <input type="text" name="material" id="field_material" required placeholder="Material name..." 
                                        class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black italic">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Dimension/Size</label>
                                <input type="text" name="size" id="field_size" placeholder="40kg / 10mm" 
                                    class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-bold">
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Registry Unit</label>
                                <input type="text" name="unit" id="field_unit" placeholder="bag / pc" 
                                    class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Procurement -->
                    <div class="space-y-8">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-6 w-1.5 bg-indigo-600 rounded-full"></div>
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.3em]">Trade & Value</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Supplier / Trade Vendor</label>
                                    <input type="text" name="supplier" id="field_supplier" placeholder="Company Name" 
                                        class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black italic">
                                </div>

                                <div class="group">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Unit Value (PHP)</label>
                                    <div class="relative">
                                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 font-black italic">₱</span>
                                        <input type="number" step="0.01" name="price" id="field_price" required placeholder="0.00" 
                                            class="w-full pl-12 pr-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-xl font-black italic text-slate-950">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Source Location</label>
                                <select name="location" id="field_location" class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black uppercase italic">
                                    <option value="Local">Local</option>
                                    <option value="Davao">Davao</option>
                                </select>
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Purchase Quarter</label>
                                <select name="quarter" id="field_quarter" class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black italic appearance-none cursor-pointer">
                                    <option value="Q1">Q1</option>
                                    <option value="Q2">Q2</option>
                                    <option value="Q3">Q3</option>
                                    <option value="Q4">Q4</option>
                                </select>
                            </div>
                        </div>

                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 group-focus-within:text-indigo-600 transition-colors">Official Registry Date</label>
                            <input type="date" name="date" id="field_date" class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black uppercase">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-10 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">System Connection Active</span>
                    </div>
                    
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <button type="button" onclick="closeMaterialModal()" class="flex-1 md:flex-none px-8 py-4 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] hover:text-slate-600 transition-colors">
                            Abandon
                        </button>
                        <button type="submit" id="submitBtn" class="flex-1 md:flex-none bg-indigo-600 text-white rounded-2xl px-12 py-5 justify-center text-[11px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-500/20 italic">
                            Commit Registry &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[60] invisible opacity-0 transition-all duration-300 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="relative w-full max-w-md bg-white rounded-3xl p-8 shadow-2xl transform scale-95 transition-all duration-300" id="deleteCard">
        <div class="h-16 w-16 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center mb-6">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>
        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight italic">Confirm Removal</h3>
        <p class="text-slate-500 text-sm font-medium mt-2 leading-relaxed">Are you certain you want to remove this asset? This action will permanently erase the record from the master registry.</p>
        
        <div class="mt-8 flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-6 py-4 text-slate-400 text-[10px] font-black uppercase tracking-widest hover:text-slate-600 transition-colors">Cancel</button>
            <button id="confirmDeleteBtn" class="flex-1 px-6 py-4 bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/20 italic">Confirm Delete</button>
        </div>
    </div>
</div>

<script>
    let currentMaterialId = null;

    function openMaterialModal(materialData = null) {
        const modal = document.getElementById('materialModal');
        const card = document.getElementById('modalCard');
        const form = document.getElementById('materialForm');
        const methodInput = document.getElementById('formMethod');
        const idInput = document.getElementById('materialId');
        const title = document.getElementById('modalTitle');
        const subtitle = document.getElementById('modalSubtitle');
        const submitBtn = document.getElementById('submitBtn');

        if (materialData) {
            // Edit Mode
            methodInput.value = 'PUT';
            idInput.value = materialData.id;
            title.innerHTML = 'Modify <span class="text-indigo-500">Asset</span>';
            subtitle.innerText = 'Update existing inventory record details';
            submitBtn.innerHTML = 'Save Changes &rarr;';
            
            // Populate Fields
            document.getElementById('field_category_id').value = materialData.category_id;
            document.getElementById('field_item_code').value = materialData.item_code;
            document.getElementById('field_material').value = materialData.material;
            document.getElementById('field_size').value = materialData.size || '';
            document.getElementById('field_unit').value = materialData.unit || '';
            document.getElementById('field_supplier').value = materialData.supplier || '';
            document.getElementById('field_price').value = materialData.price;
            document.getElementById('field_location').value = materialData.location || 'Local';
            document.getElementById('field_quarter').value = materialData.quarter || '';
            document.getElementById('field_date').value = materialData.date || '';
        } else {
            // Create Mode
            form.reset();
            methodInput.value = 'POST';
            idInput.value = '';
            title.innerHTML = 'Material <span class="text-indigo-500">Registration</span>';
            subtitle.innerText = 'Push new assets to official construction inventory';
            submitBtn.innerHTML = 'Commit Registry &rarr;';
        }

        modal.classList.remove('invisible', 'opacity-0');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeMaterialModal() {
        const modal = document.getElementById('materialModal');
        const card = document.getElementById('modalCard');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('invisible', 'opacity-0');
        }, 300);
    }

    // Delete Logic
    function confirmDelete(id) {
        currentMaterialId = id;
        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteCard');
        modal.classList.remove('invisible', 'opacity-0');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const card = document.getElementById('deleteCard');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('invisible', 'opacity-0');
        }, 300);
        currentMaterialId = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
        if (!currentMaterialId) return;
        
        const btn = this;
        btn.disabled = true;
        btn.innerText = 'Processing...';

        try {
            const response = await fetch(`/materials/${currentMaterialId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            });

            if (response.ok) {
                showToast('Success', 'Asset removed from registry.', 'success');
                window.location.reload();
            } else {
                showToast('Action Failed', 'Could not delete the record.', 'error');
            }
        } catch (error) {
            showToast('System Error', 'Communication breakdown.', 'error');
        } finally {
            closeDeleteModal();
            btn.disabled = false;
            btn.innerText = 'Confirm Delete';
        }
    });

    document.getElementById('materialForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const originalText = btn.innerHTML;
        const materialId = document.getElementById('materialId').value;
        const method = document.getElementById('formMethod').value;
        
        btn.disabled = true;
        btn.innerHTML = '<span class="flex items-center gap-2">Processing...</span>';

        const formData = new FormData(this);
        const url = method === 'POST' ? "{{ route('materials.store') }}" : `/materials/${materialId}`;
        
        try {
            const response = await fetch(url, {
                method: "POST", // Standard Laravel way to handle PUT via _method
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            });

            if (response.ok) {
                showToast('Success', 'Ledger updated successfully.', 'success');
                window.location.reload();
            } else {
                const data = await response.json();
                showToast('Registry Error', data.message || 'Validation failed.', 'error');
            }
        } catch (error) {
            showToast('System Error', 'Failed to communicate with portal.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
</script>
