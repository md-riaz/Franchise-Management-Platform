<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard;
use App\Livewire\FranchiseList;
use App\Livewire\InventoryList;
use App\Livewire\SalesList;
use App\Livewire\VendorList;
use App\Livewire\ComplianceList;
use App\Livewire\RoyaltyList;

Route::get('/', fn () => view('welcome'))->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, request()->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid credentials'])
                ->onlyInput('email');
        }

        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    });
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/franchises', FranchiseList::class)->name('franchises');
    Route::get('/inventory', InventoryList::class)->name('inventory');
    Route::get('/sales', SalesList::class)->name('sales');
    Route::get('/vendors', VendorList::class)->name('vendors');
    Route::get('/compliance', ComplianceList::class)->name('compliance');
    Route::get('/royalties', RoyaltyList::class)->name('royalties');
});
