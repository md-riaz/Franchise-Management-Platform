<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SalesList extends Component
{
    use WithPagination;

    public $search = '';
    public $franchiseId = '';
    public $status = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Sale::with(['franchise', 'user']);
        
        if ($this->search) {
            $query->where('sale_number', 'like', '%' . $this->search . '%');
        }
        
        if ($this->franchiseId) {
            $query->where('franchise_id', $this->franchiseId);
        } elseif (!Auth::user()->isFranchisor() && !Auth::user()->isAdmin()) {
            $userFranchise = Auth::user()->franchises()->first();
            if ($userFranchise) {
                $query->where('franchise_id', $userFranchise->id);
            }
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        if ($this->dateFrom) {
            $query->where('sale_date', '>=', $this->dateFrom);
        }
        
        if ($this->dateTo) {
            $query->where('sale_date', '<=', $this->dateTo);
        }
        
        $sales = $query->latest('sale_date')->paginate(15);
        
        $franchises = Franchise::active()->get();
        
        return view('livewire.sales-list', [
            'sales' => $sales,
            'franchises' => $franchises
        ]);
    }
}
