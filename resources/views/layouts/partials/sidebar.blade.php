<!-- Mobile Overlay -->
<div x-show="sidebarOpen" 
    x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden" 
    @click="sidebarOpen = false">
</div>

<!-- Sidebar Container -->
<aside id="sidebar" 
    x-cloak
    :class="{ 
        'translate-x-0': sidebarOpen, 
        '-translate-x-full': !sidebarOpen
    }"
    class="fixed lg:static inset-y-0 left-0 z-40 w-72 bg-[#1e1b4b] text-slate-300 flex flex-col border-r border-white/5 overflow-hidden transition-transform duration-300 ease-in-out shrink-0 h-screen shadow-2xl lg:translate-x-0">
    
    <!-- Brand Branding -->
    <div class="h-20 flex items-center justify-between px-8 shrink-0 relative overflow-hidden group border-b border-white/5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition-transform hover:scale-105 relative z-10">
            <div class="h-10 w-10 rounded-xl bg-white p-1.5 shadow-lg overflow-hidden group-hover:rotate-3 transition-transform duration-300">
                <img class="h-full w-full object-contain" src="{{ asset('images/Picture1.png') }}" alt="DCJ Logo">
            </div>
            <div class="flex flex-col leading-none">
                <span class="text-[11px] font-black text-white tracking-[0.1em] uppercase">DCJ's Construction Services</span>
                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-[0.2em] mt-1 italic">Procurement Portal</span>
            </div>
        </a>

        <!-- Mobile/Compact Close Button -->
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    @auth
    <!-- Navigation List -->
    <div class="flex-1 overflow-y-auto py-8 px-4 space-y-8 custom-scrollbar">
        
        <!-- Management Section -->
        <div class="space-y-1.5">
            <span class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Management</span>
            
            <a href="{{ route('dashboard') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'sidebar-nav-active' : 'hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-[13px] font-bold tracking-tight italic">Dashboard</span>
            </a>

            <a href="{{ route('materials.index') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('materials.index') ? 'sidebar-nav-active' : 'hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('materials.index') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                <span class="text-[13px] font-bold tracking-tight italic">Materials Ledger</span>
            </a>
        </div>

        <!-- Inventory Sections -->
        <div class="space-y-1.5">
             <span class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Departments</span>
             
             <a href="{{ route('categories.index') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('categories.index') ? 'sidebar-nav-active' : 'hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('categories.index') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span class="text-[13px] font-bold tracking-tight italic">Categories Hub</span>
            </a>

            <a href="{{ route('materials.compare') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('materials.compare') ? 'sidebar-nav-active' : 'hover:bg-white/5 hover:text-white' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('materials.compare') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <span class="text-[13px] font-bold tracking-tight italic">Price Analyzer</span>
            </a>
        </div>

    </div>

    <!-- Sidebar Footer -->
    <div class="p-6 border-t border-white/5 shrink-0 bg-[#16143a]">
        <div class="flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest leading-none">System Core</span>
                <span class="text-[11px] font-black text-indigo-400 mt-1 uppercase italic leading-none">v1.2.0-PRO</span>
            </div>
            <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
        </div>
    </div>
    @endauth
</aside>
