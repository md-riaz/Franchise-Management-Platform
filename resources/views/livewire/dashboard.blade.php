<div class="space-y-6">
    <div class="glass-card relative overflow-hidden">
        <div class="absolute inset-y-0 right-0 w-1/3 bg-gradient-to-br from-blue-100 via-indigo-100 to-cyan-50 blur-3xl opacity-70"></div>
        <div class="relative p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="muted-label">Overview</p>
                    <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
                    <p class="mt-2 text-sm text-slate-600">Welcome to your franchise management cockpit</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="pill bg-blue-50 text-blue-700 border border-blue-100">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Live metrics
                    </span>
                    <span class="pill bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Operational snapshot
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @if(auth()->user()->isFranchisor())
            <div class="glass-card p-5 flex gap-4 items-start">
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center shadow-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="muted-label">Active Franchises</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $activeFranchises }}</p>
                    <p class="text-xs text-slate-500 mt-1">Locations currently trading</p>
                </div>
            </div>
        @endif

        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Total Sales</p>
                <p class="text-2xl font-semibold text-slate-900">${{ number_format($totalSales, 2) }}</p>
                <p class="text-xs text-slate-500 mt-1">Lifetime tracked revenue</p>
            </div>
        </div>

        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Monthly Sales</p>
                <p class="text-2xl font-semibold text-slate-900">${{ number_format($monthlySales, 2) }}</p>
                <p class="text-xs text-slate-500 mt-1">Current month performance</p>
            </div>
        </div>

        <div class="glass-card p-5 flex gap-4 items-start">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-500 text-white flex items-center justify-center shadow-md">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="muted-label">Overdue Compliance</p>
                <p class="text-2xl font-semibold text-rose-600">{{ $overdueCompliance }}</p>
                <p class="text-xs text-slate-500 mt-1">Items needing attention</p>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <div class="flex flex-wrap items-center justify-between gap-3 px-6 py-4 border-b border-slate-200/70">
            <div>
                <p class="muted-label">Recent Sales</p>
                <h3 class="text-lg font-semibold text-slate-900">Latest revenue activity</h3>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                Updated {{ now()->format('M d') }}
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Sale #</th>
                        @if(auth()->user()->isFranchisor())
                            <th class="px-6 py-3">Franchise</th>
                        @endif
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $sale->sale_number }}</td>
                            @if(auth()->user()->isFranchisor())
                                <td class="px-6 py-4 text-slate-600">{{ $sale->franchise->name }}</td>
                            @endif
                            <td class="px-6 py-4 text-slate-600">{{ $sale->sale_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">${{ number_format($sale->total, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="pill 
                                    @if($sale->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-100
                                    @elseif($sale->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                                    @else bg-rose-50 text-rose-700 border border-rose-100
                                    @endif">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-slate-500">No sales recorded yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
