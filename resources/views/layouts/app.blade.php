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
<body class="bg-neutral-50 text-neutral-900 antialiased" x-data="{ sidebarOpen: false }">

    @php
        $navItems = [
            ['label' => 'Dashboard',  'route' => 'dashboard',  'icon' => 'squares-2x2'],
            ['label' => 'Franchises', 'route' => 'franchises', 'icon' => 'building-office-2'],
            ['label' => 'Inventory',  'route' => 'inventory',  'icon' => 'cube'],
            ['label' => 'Sales',      'route' => 'sales',      'icon' => 'banknotes'],
            ['label' => 'Vendors',    'route' => 'vendors',    'icon' => 'truck'],
            ['label' => 'Compliance', 'route' => 'compliance', 'icon' => 'clipboard-document-check'],
            ['label' => 'Royalties',  'route' => 'royalties',  'icon' => 'currency-dollar'],
        ];
    @endphp

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar overlay for mobile --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black/50 lg:hidden"
        ></div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 transform transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col bg-white border-r border-neutral-200"
        >
            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-neutral-200">
                <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-indigo-600 text-white shrink-0">
                    <x-heroicon-m-building-storefront class="w-5 h-5" />
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-neutral-900 truncate">Franchise Platform</p>
                    <p class="text-xs text-neutral-500 truncate">Management Suite</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">
                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['route']); @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                               {{ $isActive
                                   ? 'bg-indigo-50 text-indigo-700'
                                   : 'text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900' }}"
                    >
                        <x-dynamic-component :component="'heroicon-m-' . $item['icon']" class="w-4 h-4 shrink-0" />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- User + logout --}}
            @auth
            <div class="px-3 py-4 border-t border-neutral-200">
                <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-neutral-50 border border-neutral-200">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-neutral-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900 transition-colors">
                        <x-heroicon-m-arrow-right-start-on-rectangle class="w-4 h-4" />
                        Sign out
                    </button>
                </form>
            </div>
            @endauth
        </aside>

        {{-- Main content area --}}
        <div class="flex flex-col flex-1 overflow-hidden">
            {{-- Top bar --}}
            <header class="flex items-center justify-between h-14 px-4 sm:px-6 bg-white border-b border-neutral-200 shrink-0">
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-neutral-500 hover:bg-neutral-100 lg:hidden"
                >
                    <x-heroicon-m-bars-3 class="w-5 h-5" />
                </button>
                @auth
                <div class="flex items-center gap-3 ml-auto">
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-neutral-500 bg-neutral-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ ucfirst(auth()->user()->role ?? 'user') }}
                    </span>
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
                @endauth
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto bg-neutral-50">
                <div class="page-shell py-6 space-y-6">
                    @if (session('message'))
                        <div class="flex items-start gap-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm font-medium">
                            <x-heroicon-m-check-circle class="w-5 h-5 shrink-0 mt-0.5 text-emerald-600" />
                            {{ session('message') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
