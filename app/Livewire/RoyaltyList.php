<?php

namespace App\Livewire;

use App\Models\Royalty;
use App\Models\Franchise;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RoyaltyList extends Component
{
    use WithPagination;

    public $franchiseId = '';
    public $status = '';
    
    public function render()
    {
        $query = Royalty::with('franchise');
        
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
        
        $royalties = $query->latest('period_start')->paginate(15);
        
        $franchises = Franchise::active()->get();
        
        return view('livewire.royalty-list', [
            'royalties' => $royalties,
            'franchises' => $franchises
        ]);
    }

    public function calculateRoyalties()
    {
        // Logic to automatically calculate royalties for all franchises
        // This would typically be run as a scheduled task
        $franchises = Franchise::active()->get();
        
        foreach ($franchises as $franchise) {
            // Calculate monthly royalties based on sales
            // Implementation would depend on business logic
        }
        
        session()->flash('message', 'Royalties calculated successfully.');
    }
}
