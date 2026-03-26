<div class="space-y-6">
    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Dashboard</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Welcome back, {{ auth()->user()->name }}. Here's what's happening.</p>
        </div>
        <x-ui.badge color="indigo" variant="outline">
            <x-heroicon-m-signal class="w-3 h-3 mr-1" />
            Live data
        </x-ui.badge>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @if(auth()->user()->isFranchisor())
        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-indigo-50 text-indigo-600 shrink-0">
                <x-heroicon-m-building-office-2 class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Active Franchises</p>
                <p class="text-2xl font-bold text-neutral-900 mt-0.5">{{ $activeFranchises }}</p>
                <p class="text-xs text-neutral-400 mt-1">Locations currently trading</p>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                <x-heroicon-m-banknotes class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Total Sales</p>
                <p class="text-2xl font-bold text-neutral-900 mt-0.5">${{ number_format($totalSales, 0) }}</p>
                <p class="text-xs text-neutral-400 mt-1">Lifetime tracked revenue</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-amber-50 text-amber-600 shrink-0">
                <x-heroicon-m-arrow-trending-up class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Monthly Sales</p>
                <p class="text-2xl font-bold text-neutral-900 mt-0.5">${{ number_format($monthlySales, 0) }}</p>
                <p class="text-xs text-neutral-400 mt-1">Current month performance</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-neutral-200 p-5 flex gap-4">
            <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-red-50 text-red-600 shrink-0">
                <x-heroicon-m-exclamation-triangle class="w-5 h-5" />
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide">Overdue Compliance</p>
                <p class="text-2xl font-bold {{ $overdueCompliance > 0 ? 'text-red-600' : 'text-neutral-900' }} mt-0.5">{{ $overdueCompliance }}</p>
                <p class="text-xs text-neutral-400 mt-1">Items needing attention</p>
            </div>
        </div>
    </div>

    {{-- Recent Sales table --}}
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-200">
            <div>
                <h2 class="text-sm font-semibold text-neutral-900">Recent Sales</h2>
                <p class="text-xs text-neutral-500 mt-0.5">Latest revenue activity</p>
            </div>
            <span class="text-xs text-neutral-400">Updated {{ now()->format('M d') }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Sale #</th>
                        @if(auth()->user()->isFranchisor())
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Franchise</th>
                        @endif
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Date</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($recentSales as $sale)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3.5 font-medium text-neutral-900">{{ $sale->sale_number }}</td>
                        @if(auth()->user()->isFranchisor())
                        <td class="px-5 py-3.5 text-neutral-600">{{ $sale->franchise->name }}</td>
                        @endif
                        <td class="px-5 py-3.5 text-neutral-500">{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td class="px-5 py-3.5 font-semibold text-neutral-900">${{ number_format($sale->total, 2) }}</td>
                        <td class="px-5 py-3.5">
                            @if($sale->status === 'completed')
                                <x-ui.badge color="emerald">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @elseif($sale->status === 'pending')
                                <x-ui.badge color="amber">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @else
                                <x-ui.badge color="red">{{ ucfirst($sale->status) }}</x-ui.badge>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-neutral-400">No sales recorded yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
