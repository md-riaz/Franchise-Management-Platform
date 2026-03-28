<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Franchise Management Platform') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-b from-slate-50 via-sky-50 to-white">
    <div class="relative isolate overflow-hidden">
        <div class="absolute inset-x-0 top-0 h-64 bg-gradient-to-br from-indigo-100 via-sky-100 to-emerald-50 blur-3xl opacity-70"></div>
        <div class="page-shell py-16 lg:py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="pill bg-blue-50 text-blue-700 border border-blue-100 inline-flex">Modern franchise OS</span>
                    <h1 class="text-4xl font-extrabold text-slate-900 sm:text-5xl">
                        Franchise Management <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Platform</span>
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        A comprehensive system for managing operations with real-time tracking, inventory controls, rich analytics,
                        automated royalties, and proactive compliance.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                                Launch dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-indigo-700 transition">
                                Sign In
                            </a>
                        @endauth
                        <a href="#features" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3 text-slate-800 font-semibold shadow-sm hover:border-blue-200 hover:text-blue-700 transition">
                            Explore features
                        </a>
                    </div>
                </div>
                <div class="glass-card p-6 shadow-xl">
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-slate-700">Live snapshot</p>
                            <span class="pill bg-emerald-50 text-emerald-700 border border-emerald-100">Auto synced</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-card p-4 border border-slate-100 shadow-sm">
                                <p class="muted-label">Active franchises</p>
                                <p class="text-2xl font-bold text-slate-900">24</p>
                                <p class="text-xs text-emerald-600 mt-1">+3 this quarter</p>
                            </div>
                            <div class="glass-card p-4 border border-slate-100 shadow-sm">
                                <p class="muted-label">Monthly sales</p>
                                <p class="text-2xl font-bold text-slate-900">$1.2M</p>
                                <p class="text-xs text-blue-600 mt-1">Up 14%</p>
                            </div>
                            <div class="glass-card p-4 border border-slate-100 shadow-sm">
                                <p class="muted-label">Overdue tasks</p>
                                <p class="text-2xl font-bold text-rose-600">3</p>
                                <p class="text-xs text-slate-500 mt-1">Compliance follow-ups</p>
                            </div>
                            <div class="glass-card p-4 border border-slate-100 shadow-sm">
                                <p class="muted-label">Vendors</p>
                                <p class="text-2xl font-bold text-slate-900">18</p>
                                <p class="text-xs text-emerald-600 mt-1">Trusted network</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section id="features" class="mt-16 lg:mt-24 space-y-8">
                <div class="text-center space-y-3">
                    <span class="pill bg-slate-100 text-slate-700 border border-slate-200 inline-flex">Built for operators</span>
                    <p class="text-3xl font-extrabold text-slate-900 sm:text-4xl">Everything you need to manage franchises</p>
                </div>
                <div class="grid md:grid-cols-2 gap-8">
                    @php
                        $features = [
                            ['title' => 'Franchise Onboarding', 'copy' => 'Streamlined onboarding with automated workflows and compliance tracking.', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['title' => 'Inventory Management', 'copy' => 'Real-time inventory tracking across every location with proactive alerts.', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['title' => 'Sales Analytics', 'copy' => 'Comprehensive sales tracking, tax handling, and profit sharing insights.', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['title' => 'Compliance Tracking', 'copy' => 'Automated monitoring and reporting to keep every site audit-ready.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['title' => 'Royalty Automation', 'copy' => 'Hands-free royalty calculation tied directly to sales performance.', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['title' => 'Vendor Management', 'copy' => 'Centralized partner network with ratings, contact cards, and statuses.', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                        ];
                    @endphp

                    @foreach ($features as $feature)
                        <div class="glass-card p-5 flex gap-4 items-start">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-500 text-white flex items-center justify-center shadow-md">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-slate-900">{{ $feature['title'] }}</p>
                                <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $feature['copy'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</body>
</html>
