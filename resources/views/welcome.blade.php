<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DCJ's Construction Services - Procurement Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f0f7ff] text-[#1e1b4b] antialiased min-h-screen flex flex-col overflow-x-hidden">

    <!-- Header -->
    <header class="bg-white px-6 md:px-12 py-4 md:py-6 flex items-center justify-between shadow-sm relative z-20">
        <div class="flex items-center">
            <img src="{{ asset('images/Picture1.png') }}" alt="DCJ Logo" class="h-10 md:h-16 w-auto drop-shadow-sm">
        </div>
        <div class="flex justify-end">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-[#1e60ff] text-white px-6 md:px-10 py-2.5 md:py-3 rounded-lg font-bold text-xs md:text-sm hover:bg-[#1650d9] transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-[#1e60ff] text-white px-6 md:px-10 py-2.5 md:py-3 rounded-lg font-bold text-xs md:text-sm hover:bg-[#1650d9] transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                    Log In
                </a>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-6 py-12 md:py-20 relative overflow-hidden">
        
        <!-- Hero Section -->
        <div class="w-full max-w-5xl mx-auto text-center space-y-8 animate-in fade-in slide-in-from-bottom-5 duration-700">
            <div class="flex flex-col items-center justify-center gap-6 md:gap-8">
                <div class="flex flex-col md:flex-row items-center gap-4 md:gap-6">
                    <img src="{{ asset('images/Picture1.png') }}" alt="DCJ Logo" class="h-16 md:h-24 w-auto">
                    <h1 class="text-[32px] sm:text-[48px] md:text-[64px] font-[900] tracking-tight text-slate-950 flex flex-col md:flex-row items-center gap-1 md:gap-4 leading-tight">
                        DCJ's Construction <span class="text-[#2563eb]">Services</span>
                    </h1>
                </div>

                <p class="text-base md:text-xl text-slate-500 font-medium max-w-2xl leading-relaxed px-4">
                    Building With Integrity. Integrated material management and procurement system
                    tailored for construction operations.
                </p>

                <div class="pt-4 md:pt-6">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-[#2563eb] text-white px-8 md:px-10 py-3.5 md:py-4 rounded-xl font-extrabold text-xs md:text-sm tracking-tight hover:bg-[#1d4ed8] transition-all shadow-xl shadow-blue-500/30 active:scale-95 inline-block">
                            Access System
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#2563eb] text-white px-8 md:px-10 py-3.5 md:py-4 rounded-xl font-extrabold text-xs md:text-sm tracking-tight hover:bg-[#1d4ed8] transition-all shadow-xl shadow-blue-500/30 active:scale-95 inline-block">
                            Access System
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-10 md:py-12 px-6 md:px-8 flex items-center justify-center border-t border-slate-200/50">
        <p class="text-[10px] md:text-[12px] font-medium text-slate-400 text-center leading-relaxed">
            © {{ date('Y') }} DCJ's Construction Services. <br class="md:hidden"> All rights reserved. Built with Integrity.
        </p>
    </footer>

</body>
</html>
