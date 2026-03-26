<div class="space-y-4">
    <div class="glass-card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <p class="muted-label">Suppliers</p>
                <h2 class="text-2xl font-bold text-slate-900">Vendor Management</h2>
                <p class="text-sm text-slate-600 mt-1">Curate trusted partners and monitor their status</p>
            </div>
            <div class="pill bg-slate-100 text-slate-700 border border-slate-200">
                {{ $vendors->total() }} vendors
            </div>
        </div>

        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="muted-label block mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search vendors..." 
                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
            </div>
            <div>
                <label class="muted-label block mb-2">Status</label>
                <select wire:model.live="status" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="glass-card overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/70 flex items-center justify-between">
            <div>
                <p class="muted-label">Partner list</p>
                <p class="text-slate-800 font-semibold">Contact directory</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-700">
                <thead class="text-xs uppercase text-slate-500 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">Code</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Contact Person</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Phone</th>
                        <th class="px-6 py-3">Rating</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($vendors as $vendor)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4 font-semibold text-slate-900">{{ $vendor->code }}</td>
                        <td class="px-6 py-4 text-slate-800">{{ $vendor->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $vendor->contact_person }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $vendor->email }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $vendor->phone }}</td>
                        <td class="px-6 py-4 text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="text-amber-400">★</span>
                                <span class="font-medium text-slate-800">{{ number_format($vendor->rating, 1) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="pill 
                                @if($vendor->status === 'active') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @else bg-slate-100 text-slate-700 border border-slate-200
                                @endif">
                                {{ ucfirst($vendor->status) }}
                            </span>
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
                        <td colspan="8" class="px-6 py-4 text-center text-sm text-slate-500">No vendors found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200/70 bg-slate-50/60">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
