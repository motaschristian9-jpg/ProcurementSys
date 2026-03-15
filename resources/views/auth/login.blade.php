<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login - DCJ's Construction Services</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Picture1.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans antialiased min-h-screen flex selection:bg-[#4f46e5] selection:text-white overflow-hidden">

    <!-- Split Layout -->
    <div class="flex-1 flex flex-col md:flex-row w-full">
        
        <!-- Left Section: Login Form -->
        <div class="flex-1 flex flex-col items-center justify-center p-8 md:p-12 lg:p-24 bg-white relative z-10">
            <div class="w-full max-w-[400px] space-y-12">
                
                <!-- Header Branding -->
                <div class="text-center space-y-6">
                    <img src="{{ asset('images/Picture1.png') }}" alt="DCJ Logo" class="h-16 w-auto mx-auto grayscale opacity-80">
                    <div class="space-y-2">
                        <h2 class="text-[32px] font-[900] tracking-tight text-slate-950 uppercase">Access Dashboard</h2>
                        <p class="text-xs text-slate-500 font-medium">Sign in to manage materials, pricing, and procurement reporting.</p>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-tight">Admin Username</label>
                        <div class="relative">
                            <input type="text" name="username" required placeholder="Enter username" value="{{ old('username') }}"
                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-sm font-medium">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                        @error('username') <p class="text-rose-500 text-[11px] mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase tracking-tight">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required placeholder="••••••••" 
                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none text-sm font-medium">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="remember" class="ml-2 text-xs text-slate-500 font-medium cursor-pointer">Remember me</label>
                    </div>

                    <button type="submit" class="w-full bg-[#4f46e5] text-white py-4 rounded-xl font-black text-sm tracking-tight hover:bg-[#4338ca] transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                        Sign In to Portal
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Right Section: Branding -->
    <div class="hidden md:flex 
flex-1 bg-linear-to-tr from-[#1e1b4b] to-[#4338ca] relative items-center justify-center p-20 overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl -ml-32 -mb-32"></div>
            
            <div class="relative z-10 text-center space-y-6 max-w-md">
                <h1 class="text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                    Next-Generation <br>
                    <span class="bg-clip-text text-transparent bg-linear-to-r from-indigo-300 via-purple-300 to-rose-300">Procurement System</span>
                </h1>
                <p class="text-indigo-100/70 text-sm leading-relaxed font-medium">
                    Automate inventory tracking, calculate material variances, and manage your supply chain effectively with our integrated modular tools.
                </p>
            </div>
        </div>

    </div>

</body>
</html>
