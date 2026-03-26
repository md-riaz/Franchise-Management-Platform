<div class="space-y-5">
    {{-- Page header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900">Vendors</h1>
            <p class="text-sm text-neutral-500 mt-0.5">Curate trusted partners and monitor their status</p>
        </div>
        <x-ui.badge color="indigo" variant="outline">{{ $vendors->total() }} vendors</x-ui.badge>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-neutral-200 p-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Search</label>
                <div class="relative">
                    <x-heroicon-m-magnifying-glass class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400 pointer-events-none" />
                    <input type="text" wire:model.live="search" placeholder="Search vendors..."
                        class="w-full rounded-lg border border-neutral-300 bg-white pl-9 pr-3 py-2.5 text-sm text-neutral-900 placeholder-neutral-400 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</label>
                <select wire:model.live="status"
                    class="w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-sm text-neutral-900 shadow-xs transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-neutral-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-200">
            <h2 class="text-sm font-semibold text-neutral-900">Vendor Directory</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 border-b border-neutral-200">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Code</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Name</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Contact</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Email</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Phone</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Rating</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-neutral-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @forelse($vendors as $vendor)
                    <tr class="hover:bg-neutral-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="font-mono text-xs font-semibold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">{{ $vendor->code }}</span>
                        </td>
                        <td class="px-5 py-3.5 font-medium text-neutral-900">{{ $vendor->name }}</td>
                        <td class="px-5 py-3.5 text-neutral-600">{{ $vendor->contact_person }}</td>
                        <td class="px-5 py-3.5 text-neutral-500 text-xs">{{ $vendor->email }}</td>
                        <td class="px-5 py-3.5 text-neutral-500 text-xs">{{ $vendor->phone }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-1">
                                <x-heroicon-m-star class="w-3.5 h-3.5 text-amber-400" />
                                <span class="font-medium text-neutral-800 text-xs">{{ number_format($vendor->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($vendor->status === 'active')
                                <x-ui.badge color="emerald">{{ ucfirst($vendor->status) }}</x-ui.badge>
                            @else
                                <x-ui.badge>{{ ucfirst($vendor->status) }}</x-ui.badge>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 transition-colors">View</a>
                                <span class="text-neutral-300">·</span>
                                <a href="#" class="text-xs font-medium text-neutral-600 hover:text-neutral-800 transition-colors">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center">
                            <x-heroicon-m-truck class="w-8 h-8 text-neutral-300 mx-auto mb-2" />
                            <p class="text-sm text-neutral-400">No vendors found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-neutral-200 bg-neutral-50">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
