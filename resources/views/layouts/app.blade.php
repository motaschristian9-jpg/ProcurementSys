<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DCJ\'s Construction Services')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
    <div class="flex h-screen bg-[#f3f4f6]" 
        x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
        @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content area -->
        <div class="flex-1 flex flex-col h-screen overflow-y-auto relative">
            
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-30 shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 p-2 hover:bg-slate-50 rounded-lg transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <!-- Breadcrumbs -->
                    <div class="flex items-center gap-2 text-[11px] sm:text-[13px] font-medium overflow-hidden">
                        <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-2 shrink-0">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        </a>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 uppercase tracking-tight font-bold truncate">@yield('title', 'Dashboard')</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    @auth
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:block bg-indigo-50 text-indigo-700 px-4 py-1 rounded-full text-[11px] font-bold border border-indigo-100 uppercase tracking-tight">
                            {{ auth()->user()->name }}
                        </div>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
                        <button type="button" onclick="confirmAction({
                            title: 'Sign Out Confirmation',
                            message: 'Are you sure you want to end your current session?',
                            buttonText: 'Sign Out',
                            onConfirm: () => { document.getElementById('logout-form').submit(); }
                        })" class="text-rose-400 hover:text-rose-600 transition-colors p-1.5 hover:bg-rose-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 p-4 sm:p-8">
                <div class="max-w-7xl mx-auto">
                    @include('layouts.partials.toast')
                    @include('layouts.partials.confirm_modal')
                    @include('layouts.partials.material_modal')

                    <!-- Dynamic Delete Form -->
                    <form id="global-delete-form" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="h-12 border-t border-slate-100 flex items-center justify-center px-4 sm:px-8 text-[10px] sm:text-[11px] text-slate-400 font-medium tracking-tight bg-white text-center">
                © {{ date('Y') }} DCJ's Construction Services. v1.2
            </footer>
        </div>
    </div>

    @stack('scripts')

</body>
</html>
