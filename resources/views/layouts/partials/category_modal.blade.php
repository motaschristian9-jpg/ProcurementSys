<div id="categoryModal" class="fixed inset-0 z-70 invisible opacity-0 transition-all duration-500 overflow-y-auto custom-scrollbar">
    <!-- glass backdrop -->
    <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-xl transition-opacity duration-500" onclick="closeCategoryModal()"></div>
    
    <!-- Modal Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-lg bg-white rounded-[2.5rem] shadow-[0_50px_100px_-20px_rgba(15,23,42,0.4)] border border-slate-200 overflow-hidden transform scale-95 transition-all duration-500" id="categoryModalCard">
            
            <!-- Modal Header -->
            <div class="p-10 bg-slate-950 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-500 text-[9px] font-black uppercase tracking-[0.2em] mb-4">
                            System Taxonomy
                        </div>
                        <h2 class="text-3xl font-black text-white italic uppercase tracking-tighter">New <span class="text-indigo-500">Category</span></h2>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Create a new inventory classification</p>
                    </div>
                    <button onclick="closeCategoryModal()" class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <form id="categoryForm" class="p-10 space-y-8">
                @csrf
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 group-focus-within:text-indigo-600 transition-colors">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g., Electrical Works, Landscaping..." 
                        class="w-full px-6 py-4 rounded-xl border border-slate-100 bg-slate-50 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all text-sm font-black italic">
                    <p class="mt-3 text-[9px] text-slate-400 font-bold uppercase tracking-widest leading-relaxed">Ensure the name is unique to avoid inventory fragmentation.</p>
                </div>

                <!-- Footer Actions -->
                <div class="pt-8 border-t border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Taxonomy Engine Ready</span>
                    </div>
                    
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <button type="button" onclick="closeCategoryModal()" class="flex-1 sm:flex-none px-6 py-3 text-slate-400 text-[10px] font-black uppercase tracking-widest hover:text-slate-600 transition-colors">
                            Abandon
                        </button>
                        <button type="submit" id="catSubmitBtn" class="flex-1 sm:flex-none bg-indigo-600 text-white rounded-2xl px-8 py-4 justify-center text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-500/20 italic">
                            Register Category &rarr;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCategoryModal() {
        const modal = document.getElementById('categoryModal');
        const card = document.getElementById('categoryModalCard');
        modal.classList.remove('invisible', 'opacity-0');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeCategoryModal() {
        const modal = document.getElementById('categoryModal');
        const card = document.getElementById('categoryModalCard');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('invisible', 'opacity-0');
        }, 300);
    }

    document.getElementById('categoryForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('catSubmitBtn');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = 'Registering...';

        const formData = new FormData(this);
        
        try {
            const response = await fetch("{{ route('categories.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                showToast(data.message || 'Validation failed. Name might be taken.', 'error');
            }
        } catch (error) {
            showToast('Portal connection failed.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
</script>
