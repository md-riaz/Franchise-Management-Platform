<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryList extends Component
{
    use WithPagination;

    public $search = '';
    public $franchiseId = '';
    public $lowStockOnly = false;
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Inventory::with(['franchise', 'product']);
        
        if ($this->search) {
            $query->whereHas('product', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->franchiseId) {
            $query->where('franchise_id', $this->franchiseId);
        } elseif (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            // If user is franchisee, only show their franchise inventory
            $userFranchise = Auth::user()->franchises()->first();
            if ($userFranchise) {
                $query->where('franchise_id', $userFranchise->id);
            }
        }
        
        if ($this->lowStockOnly) {
            $query->lowStock();
        }
        
        $inventory = $query->paginate(15);
        
        $franchises = Franchise::active()->get();
        
        return view('livewire.inventory-list', [
            'inventory' => $inventory,
            'franchises' => $franchises
        ]);
    }
}
