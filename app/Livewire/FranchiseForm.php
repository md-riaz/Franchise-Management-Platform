<?php

namespace App\Livewire;

use App\Models\Franchise;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FranchiseForm extends Component
{
    public $franchiseId;
    public $name;
    public $code;
    public $description;
    public $location;
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $country = 'USA';
    public $phone;
    public $email;
    public $status = 'pending';
    public $opening_date;
    public $initial_investment;
    public $franchise_fee;
    public $royalty_percentage = 5.00;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255|unique:franchises,code',
        'description' => 'nullable|string',
        'location' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'zip_code' => 'required|string|max:20',
        'country' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'status' => 'required|in:active,pending,suspended,closed',
        'opening_date' => 'nullable|date',
        'initial_investment' => 'nullable|numeric|min:0',
        'franchise_fee' => 'nullable|numeric|min:0',
        'royalty_percentage' => 'required|numeric|min:0|max:100',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->franchiseId = $id;
            $franchise = Franchise::findOrFail($id);
            $this->fill($franchise->toArray());
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'location' => $this->location,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'opening_date' => $this->opening_date,
            'initial_investment' => $this->initial_investment,
            'franchise_fee' => $this->franchise_fee,
            'royalty_percentage' => $this->royalty_percentage,
            'franchisor_id' => Auth::id(),
        ];

        if ($this->franchiseId) {
            $franchise = Franchise::findOrFail($this->franchiseId);
            $franchise->update($data);
            session()->flash('message', 'Franchise updated successfully.');
        } else {
            Franchise::create($data);
            session()->flash('message', 'Franchise created successfully.');
        }

        return redirect()->route('franchises.index');
    }

    public function render()
    {
        return view('livewire.franchise-form');
    }
}
