<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Network</p>
                <h2 class="text-2xl font-bold text-slate-900">Franchises</h2>
                <p class="text-sm text-slate-600 mt-1">Search and filter locations by status and region</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                {{ $franchises->total() }} locations
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <label class="muted-label block mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Find by name, code, or city"
                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="muted-label block mb-2">Status</label>
                <select wire:model.live="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="suspended">Suspended</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Directory</p>
                <p class="text-slate-800 font-semibold">Franchise roster</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Code</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Location</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Opening Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($franchises as $franchise)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $franchise->code }}</td>
                        <td class="px-6 py-4 text-slate-800">{{ $franchise->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $franchise->city }}, {{ $franchise->state }}</td>
                        <td class="px-6 py-4">
                            <span class="pill 
                                @if($franchise->status === 'active') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @elseif($franchise->status === 'pending') bg-amber-50 text-amber-700 border border-amber-100
                                @elseif($franchise->status === 'suspended') bg-rose-50 text-rose-700 border border-rose-100
                                @else bg-slate-100 text-slate-700 border border-slate-200
                                @endif">
                                {{ ucfirst($franchise->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $franchise->opening_date ? $franchise->opening_date->format('M d, Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 font-medium text-blue-600">
                            <div class="flex gap-3">
                                <a href="#" class="hover:text-blue-700">View</a>
                                <a href="#" class="text-indigo-600 hover:text-indigo-700">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-slate-500">No franchises found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $franchises->links() }}
        </div>
    </div>
</div>
