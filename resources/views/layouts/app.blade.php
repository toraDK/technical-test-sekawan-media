<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'FleetCore — Vehicle Management System' }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>
<body class="flex flex-col min-h-full bg-slate-950 text-white antialiased">

    <!-- Sticky Frosted Navbar -->
    <header class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md transition-all">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <nav class="flex h-20 items-center justify-between">
                
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17h14M7 17V9l5-4 5 4v8M9 17v-3h6v3"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold tracking-tight text-white">FleetCore</span>
                        <span class="ml-2 hidden text-xs text-slate-400 sm:inline">Fleet Management</span>
                    </div>
                </a>

                {{-- Navigation --}}
                @auth
                <div class="hidden items-center gap-8 md:flex">
                    <a href="{{ route('dashboard') }}" 
                       class="text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'text-blue-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('bookings.index') }}" 
                       class="text-sm font-medium transition {{ request()->routeIs('bookings.*') ? 'text-blue-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                        Pemesanan
                    </a>
                    <a href="{{ route('approvals.index') }}" 
                       class="text-sm font-medium transition {{ request()->routeIs('approvals.*') ? 'text-blue-400 font-semibold' : 'text-slate-300 hover:text-white' }}">
                        Persetujuan
                    </a>
                </div>
                @endauth

                {{-- User Action --}}
                <div class="flex items-center gap-4">
                    @auth
                    <div class="relative flex items-center gap-3 border-l border-slate-800 pl-4">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-800 text-xs font-bold text-blue-400">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-200 hidden sm:inline">{{ Auth::user()->name }}</span>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="rounded-lg border border-slate-800 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-red-400 transition hover:bg-slate-800 hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">
                        Masuk
                    </a>
                    @endauth
                </div>

            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col justify-center relative">
        <!-- Glow Effect Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[500px] w-[500px] rounded-full bg-blue-600/10 blur-[120px]"></div>
        </div>

        <div class="relative z-10 w-full">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800 bg-slate-950 py-6">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 text-sm text-slate-500 sm:flex-row lg:px-8">
            <p>&copy; {{ date('Y') }} FleetCore. Vehicle Management System.</p>
            <p>Internal Enterprise Application</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>