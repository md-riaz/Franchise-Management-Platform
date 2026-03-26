<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Franchise Management Platform') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="relative min-h-screen bg-gradient-to-b from-slate-50 via-slate-100 to-slate-50">
    <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-br from-indigo-100 via-sky-100 to-emerald-50 blur-3xl opacity-70 -z-10"></div>

    @php
        $navItems = [
            ['label' => 'Dashboard', 'route' => 'dashboard'],
            ['label' => 'Franchises', 'route' => 'franchises'],
            ['label' => 'Inventory', 'route' => 'inventory'],
            ['label' => 'Sales', 'route' => 'sales'],
            ['label' => 'Vendors', 'route' => 'vendors'],
            ['label' => 'Compliance', 'route' => 'compliance'],
            ['label' => 'Royalties', 'route' => 'royalties'],
        ];
    @endphp

    <nav class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur shadow-sm">
        <div class="page-shell">
            <div class="flex flex-wrap items-center justify-between py-4 gap-4 md:gap-6">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-500 to-cyan-400 flex items-center justify-center text-white font-bold shadow-md">
                        FM
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-slate-900 block leading-tight">
                            Franchise Platform
                        </a>
                        <p class="text-sm text-slate-500">Operate, analyze, and grow every location</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 md:order-2">
                    @auth
                        <div class="hidden md:flex items-center gap-3 px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 text-sm text-slate-700">
                            <div class="h-8 w-8 rounded-full bg-blue-600/10 text-blue-700 flex items-center justify-center font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="leading-tight">
                                <p class="font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="md:block">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m0 0l4-4m-4 4l4 4m4-9V5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2h-6a2 2 0 01-2-2v-2"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @endauth
                    <button data-collapse-toggle="primary-nav" type="button" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-200 md:hidden" aria-controls="primary-nav" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="hidden w-full md:block md:w-auto md:order-1" id="primary-nav">
                    <div class="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white/70 p-2 shadow-sm md:flex-row md:items-center md:gap-1 md:border-0 md:bg-transparent md:p-0 md:shadow-none">
                        @foreach ($navItems as $item)
                            @php
                                $isActive = request()->routeIs($item['route']);
                            @endphp
                            <a href="{{ route($item['route']) }}"
                               class="flex items-center rounded-xl px-4 py-2 text-sm font-semibold transition
                               {{ $isActive ? 'bg-blue-600 text-white shadow-md' : 'text-slate-700 hover:bg-slate-100' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="relative z-10 py-10">
        <div class="page-shell space-y-6">
            @if (session('message'))
                <div class="glass-card border-green-200 bg-emerald-50/80 text-emerald-800 px-4 py-3 flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium">{{ session('message') }}</div>
                </div>
            @endif
            
            {{ $slot }}
        </div>
    </main>

    @livewireScripts
</body>
</html>
