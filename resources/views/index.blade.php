<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FleetCore — Vehicle Management System</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS for mobile navbar toggle -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-950 text-white antialiased">

    {{-- =====================================================
        NAVBAR
    ====================================================== --}}

    <header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-800/80 bg-slate-950/80 backdrop-blur-md transition-all" @keydown.escape.window="open = false">
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

                {{-- Desktop Navigation Links --}}
                <div class="hidden items-center gap-8 md:flex">
                    <a href="#features" class="text-sm font-medium text-slate-300 transition hover:text-white">
                        Fitur
                    </a>
                    <a href="#workflow" class="text-sm font-medium text-slate-300 transition hover:text-white">
                        Workflow
                    </a>
                    <a href="#about" class="text-sm font-medium text-slate-300 transition hover:text-white">
                        Tentang Sistem
                    </a>
                </div>

                {{-- Auth Section & Hamburger Toggle --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    @auth
                        {{-- Tampilan saat User SUDAH Login (Desktop) --}}
                        <div class="hidden items-center gap-3 border-l border-slate-800 pl-4 md:flex">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-800 text-xs font-bold text-blue-400">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-slate-200">
                                {{ Auth::user()->name }}
                            </span>
                            
                            <a href="{{ route('dashboard') }}" class="rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-500">
                                Dashboard
                            </a>

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="rounded-lg border border-slate-800 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-red-400 transition hover:bg-slate-800 hover:text-red-300">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        {{-- Tampilan saat User BELUM Login --}}
                        <a href="{{ route('login') }}" class="hidden rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-200 md:inline-flex">
                            Masuk
                        </a>
                    @endauth

                    {{-- Mobile Hamburger Button --}}
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 hover:bg-slate-800 hover:text-white focus:outline-none md:hidden" aria-controls="mobile-menu" :aria-expanded="open" aria-label="Toggle navigation menu">
                        <span class="sr-only">Open main menu</span>
                        
                        <!-- Icon Hamburger -->
                        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        
                        <!-- Icon Close (X) -->
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </nav>
        </div>

        {{-- Mobile Dropdown Menu (Floating Menu dengan Absolute Positioning) --}}
        <div x-show="open" 
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.away="open = false"
            class="absolute inset-x-0 top-full border-b border-slate-800 bg-slate-950/95 px-6 pb-6 pt-3 shadow-2xl backdrop-blur-xl md:hidden"
            id="mobile-menu">
            
            <div class="space-y-1">
                <a href="#features" @click="open = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-300 transition hover:bg-slate-800/60 hover:text-white">
                    Fitur
                </a>
                <a href="#workflow" @click="open = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-300 transition hover:bg-slate-800/60 hover:text-white">
                    Workflow
                </a>
                <a href="#about" @click="open = false" class="block rounded-lg px-3 py-2 text-base font-medium text-slate-300 transition hover:bg-slate-800/60 hover:text-white">
                    Tentang Sistem
                </a>
            </div>

            @guest
                <div class="mt-4 border-t border-slate-800/80 pt-4">
                    <a href="{{ route('login') }}" @click="open = false" class="inline-flex w-full items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">
                        Masuk
                    </a>
                </div>
            @endguest

            @auth
                {{-- Mobile User Profile & Action Buttons --}}
                <div class="mt-4 border-t border-slate-800/80 pt-4">
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-800 text-xs font-bold text-blue-400">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="truncate text-sm font-medium text-slate-200">{{ Auth::user()->name }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('dashboard') }}" @click="open = false" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-blue-500">
                                Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg border border-slate-800 bg-slate-900 px-3 py-2 text-xs font-semibold text-red-400 transition hover:bg-slate-800 hover:text-red-300">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </header>



    {{-- =====================================================
        HERO
    ====================================================== --}}

    <main>

        <section class="relative overflow-hidden">

            {{-- Background glow --}}

            <div class="absolute inset-0">

                <div class="absolute left-1/2 top-0 h-[600px] w-[800px] -translate-x-1/2 rounded-full bg-blue-600/20 blur-[120px]"></div>

                <div class="absolute right-0 top-1/3 h-[300px] w-[300px] rounded-full bg-cyan-500/10 blur-[100px]"></div>

            </div>


            <div class="relative mx-auto max-w-7xl px-6 pb-24 pt-36 lg:px-8 lg:pb-32">

                <div class="grid items-center gap-16 lg:grid-cols-2">


                    {{-- Hero Content --}}

                    <div>

                        <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-400/10 px-3 py-1.5 text-xs font-medium text-blue-300">

                            <span class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>

                            VEHICLE MANAGEMENT SYSTEM

                        </div>


                        <h1 class="max-w-3xl text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">

                            Kelola kendaraan
                            <span class="text-blue-400">
                                lebih terstruktur.
                            </span>

                        </h1>


                        <p class="mt-6 max-w-xl text-base leading-7 text-slate-400 sm:text-lg">

                            Satu sistem terpusat untuk mengelola pemesanan,
                            persetujuan, penggunaan dan monitoring kendaraan
                            perusahaan secara efisien.

                        </p>


                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                            <a
                                href="/login"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold transition hover:bg-blue-500"
                            >
                                Masuk ke Sistem

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 12h14m-6-6 6 6-6 6"
                                    />
                                </svg>

                            </a>


                            <a
                                href="#features"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-700 px-5 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:bg-slate-900"
                            >
                                Pelajari Sistem
                            </a>

                        </div>


                        {{-- Small trust information --}}

                        <div class="mt-10 flex flex-wrap gap-x-6 gap-y-3 text-xs text-slate-500">

                            <div class="flex items-center gap-2">

                                <svg
                                    class="h-4 w-4 text-emerald-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m5 12 4 4L19 6"
                                    />
                                </svg>

                                Multi-level approval

                            </div>


                            <div class="flex items-center gap-2">

                                <svg
                                    class="h-4 w-4 text-emerald-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m5 12 4 4L19 6"
                                    />
                                </svg>

                                Monitoring kendaraan

                            </div>


                            <div class="flex items-center gap-2">

                                <svg
                                    class="h-4 w-4 text-emerald-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m5 12 4 4L19 6"
                                    />
                                </svg>

                                Reporting

                            </div>

                        </div>

                    </div>



                    {{-- Dashboard Preview --}}

                    <div class="relative">

                        <div class="absolute -inset-4 rounded-3xl bg-blue-500/10 blur-2xl"></div>


                        <div class="relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 shadow-2xl">


                            {{-- Fake browser header --}}

                            <div class="flex items-center justify-between border-b border-slate-800 px-5 py-4">

                                <div class="flex gap-1.5">

                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-700"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-700"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-slate-700"></span>

                                </div>

                                <span class="text-[10px] uppercase tracking-widest text-slate-600">
                                    Fleet Dashboard
                                </span>

                            </div>


                            <div class="p-5">


                                <div class="mb-5">

                                    <p class="text-xs text-slate-500">
                                        Fleet Overview
                                    </p>

                                    <h3 class="mt-1 text-lg font-semibold">
                                        Dashboard
                                    </h3>

                                </div>


                                {{-- Stats --}}

                                <div class="grid grid-cols-3 gap-3">

                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-4">

                                        <p class="text-[10px] text-slate-500">
                                            Vehicles
                                        </p>

                                        <p class="mt-2 text-2xl font-bold">
                                            48
                                        </p>

                                        <p class="mt-1 text-[10px] text-emerald-400">
                                            +4.2%
                                        </p>

                                    </div>


                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-4">

                                        <p class="text-[10px] text-slate-500">
                                            Active
                                        </p>

                                        <p class="mt-2 text-2xl font-bold">
                                            16
                                        </p>

                                        <p class="mt-1 text-[10px] text-blue-400">
                                            33.3%
                                        </p>

                                    </div>


                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-4">

                                        <p class="text-[10px] text-slate-500">
                                            Pending
                                        </p>

                                        <p class="mt-2 text-2xl font-bold">
                                            08
                                        </p>

                                        <p class="mt-1 text-[10px] text-amber-400">
                                            Attention
                                        </p>

                                    </div>

                                </div>


                                {{-- Chart --}}

                                <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950 p-4">

                                    <div class="flex items-center justify-between">

                                        <div>

                                            <p class="text-[10px] text-slate-500">
                                                Vehicle Usage
                                            </p>

                                            <p class="mt-1 text-sm font-semibold">
                                                Monthly Activity
                                            </p>

                                        </div>

                                        <span class="rounded-md bg-slate-900 px-2 py-1 text-[9px] text-slate-500">
                                            2026
                                        </span>

                                    </div>


                                    <div class="mt-5 flex h-28 items-end gap-2">

                                        <div class="h-[35%] flex-1 rounded-t bg-blue-900"></div>
                                        <div class="h-[48%] flex-1 rounded-t bg-blue-800"></div>
                                        <div class="h-[42%] flex-1 rounded-t bg-blue-800"></div>
                                        <div class="h-[67%] flex-1 rounded-t bg-blue-700"></div>
                                        <div class="h-[58%] flex-1 rounded-t bg-blue-600"></div>
                                        <div class="h-[82%] flex-1 rounded-t bg-blue-500"></div>
                                        <div class="h-[72%] flex-1 rounded-t bg-blue-500"></div>
                                        <div class="h-[94%] flex-1 rounded-t bg-blue-400"></div>

                                    </div>

                                    <div class="mt-2 flex justify-between text-[8px] text-slate-600">

                                        <span>Jan</span>
                                        <span>Mar</span>
                                        <span>May</span>
                                        <span>Jul</span>

                                    </div>

                                </div>


                                {{-- Recent booking --}}

                                <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950 p-4">

                                    <div class="flex items-center justify-between">

                                        <p class="text-xs font-medium">
                                            Recent Booking
                                        </p>

                                        <span class="text-[9px] text-blue-400">
                                            View all
                                        </span>

                                    </div>


                                    <div class="mt-3 flex items-center justify-between">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400">

                                                <svg
                                                    class="h-4 w-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M5 17h14M6 17l1-7h10l1 7M8 10l1-3h6l1 3"
                                                    />
                                                </svg>

                                            </div>

                                            <div>

                                                <p class="text-xs font-medium">
                                                    Toyota Hilux
                                                </p>

                                                <p class="text-[9px] text-slate-600">
                                                    BK-2026-0815
                                                </p>

                                            </div>

                                        </div>


                                        <span class="rounded-full bg-emerald-500/10 px-2 py-1 text-[9px] font-medium text-emerald-400">
                                            Approved
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
            FEATURES
        ====================================================== --}}

        <section
            id="features"
            class="border-t border-slate-800 bg-white py-24 text-slate-900"
        >

            <div class="mx-auto max-w-7xl px-6 lg:px-8">

                <div class="max-w-2xl">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">
                        Core Features
                    </p>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                        Semua kebutuhan fleet
                        dalam satu sistem.
                    </h2>

                    <p class="mt-4 leading-7 text-slate-500">
                        Sistem dirancang untuk membantu pengelola kendaraan
                        mengatur operasional secara lebih terstruktur,
                        transparan dan terdokumentasi.
                    </p>

                </div>


                <div class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-4">


                    {{-- Feature 1 --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Vehicle Booking
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Kelola pemesanan kendaraan berdasarkan kebutuhan,
                            lokasi dan jadwal penggunaan.
                        </p>

                    </div>


                    {{-- Feature 2 --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Multi-Level Approval
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Persetujuan pemakaian kendaraan dilakukan
                            melalui alur approval berjenjang.
                        </p>

                    </div>


                    {{-- Feature 3 --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Fleet Monitoring
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Pantau penggunaan kendaraan dan kondisi
                            operasional fleet secara terpusat.
                        </p>

                    </div>


                    {{-- Feature 4 --}}

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Reporting
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Buat laporan periodik pemesanan kendaraan
                            dan export data untuk kebutuhan administrasi.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
            WORKFLOW
        ====================================================== --}}

        <section
            id="workflow"
            class="bg-slate-50 py-24 text-slate-900"
        >

            <div class="mx-auto max-w-5xl px-6 lg:px-8">

                <div class="text-center">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">
                        Approval Workflow
                    </p>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">
                        Proses pemesanan yang terstruktur.
                    </h2>

                    <p class="mx-auto mt-4 max-w-2xl text-slate-500">
                        Setiap pemesanan kendaraan melewati proses persetujuan
                        sehingga penggunaan kendaraan dapat tercatat dan
                        dikontrol dengan baik.
                    </p>

                </div>


                <div class="mt-16 grid gap-8 md:grid-cols-4">


                    <div class="relative text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-lg font-bold text-white">
                            01
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Request
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Admin membuat pemesanan kendaraan.
                        </p>

                    </div>


                    <div class="relative text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-lg font-bold text-white">
                            02
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Supervisor
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Pemesanan diperiksa dan disetujui oleh level pertama.
                        </p>

                    </div>


                    <div class="relative text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-lg font-bold text-white">
                            03
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Manager
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Persetujuan dilanjutkan ke level berikutnya.
                        </p>

                    </div>


                    <div class="relative text-center">

                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-lg font-bold text-white">
                            ✓
                        </div>

                        <h3 class="mt-5 font-semibold">
                            Approved
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Kendaraan siap digunakan sesuai jadwal.
                        </p>

                    </div>

                </div>

            </div>

        </section>



        {{-- =====================================================
            CTA
        ====================================================== --}}

        <section
            id="about"
            class="bg-slate-950 py-24"
        >

            <div class="mx-auto max-w-5xl px-6 text-center lg:px-8">

                <div class="rounded-3xl border border-slate-800 bg-slate-900 px-6 py-16 sm:px-12">

                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-400">
                        FleetCore
                    </p>

                    <h2 class="mx-auto mt-4 max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">
                        Operasional kendaraan yang lebih
                        terkontrol dan terdokumentasi.
                    </h2>

                    <p class="mx-auto mt-5 max-w-xl leading-7 text-slate-400">
                        Kelola pemesanan, persetujuan, penggunaan dan
                        laporan kendaraan dari satu platform.
                    </p>

                    <a
                        href="/login"
                        class="mt-8 inline-flex rounded-lg bg-blue-600 px-6 py-3 text-sm font-semibold transition hover:bg-blue-500"
                    >
                        Masuk ke Sistem
                    </a>

                </div>

            </div>

        </section>

    </main>



    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <footer class="border-t border-slate-800 bg-slate-950">

        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-6 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">

            <p>
                © {{ date('Y') }} FleetCore. Vehicle Management System.
            </p>

            <p>
                Internal Enterprise Application
            </p>

        </div>

    </footer>

</body>
</html>