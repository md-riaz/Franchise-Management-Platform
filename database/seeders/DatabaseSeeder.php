<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Franchise;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\ComplianceRequirement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@franchise.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'is_active' => true,
        ]);

        // Create Franchisor
        $franchisor = User::create([
            'name' => 'John Franchisor',
            'email' => 'franchisor@franchise.com',
            'password' => Hash::make('password'),
            'user_type' => 'franchisor',
            'is_active' => true,
        ]);

        // Create Franchisee
        $franchisee = User::create([
            'name' => 'Jane Franchisee',
            'email' => 'franchisee@franchise.com',
            'password' => Hash::make('password'),
            'user_type' => 'franchisee',
            'is_active' => true,
        ]);

        // Create Sample Franchises
        $franchise1 = Franchise::create([
            'name' => 'Downtown Location',
            'code' => 'FRN-001',
            'description' => 'Main downtown franchise location',
            'location' => 'Downtown',
            'address' => '123 Main Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'country' => 'USA',
            'phone' => '555-0100',
            'email' => 'downtown@franchise.com',
            'franchisor_id' => $franchisor->id,
            'status' => 'active',
            'opening_date' => now()->subMonths(6),
            'initial_investment' => 250000,
            'franchise_fee' => 50000,
            'royalty_percentage' => 5.00,
        ]);

        $franchise2 = Franchise::create([
            'name' => 'Uptown Location',
            'code' => 'FRN-002',
            'description' => 'Uptown franchise location',
            'location' => 'Uptown',
            'address' => '456 Park Avenue',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10002',
            'country' => 'USA',
            'phone' => '555-0200',
            'email' => 'uptown@franchise.com',
            'franchisor_id' => $franchisor->id,
            'status' => 'active',
            'opening_date' => now()->subMonths(3),
            'initial_investment' => 220000,
            'franchise_fee' => 45000,
            'royalty_percentage' => 5.00,
        ]);

        // Attach franchisee to franchise
        $franchise1->users()->attach($franchisee->id, [
            'role' => 'owner',
            'joined_date' => now()->subMonths(6),
        ]);

        // Create Sample Products
        $products = [
            [
                'name' => 'Premium Product A',
                'sku' => 'PROD-A-001',
                'description' => 'High quality premium product',
                'category' => 'Premium',
                'cost_price' => 25.00,
                'selling_price' => 49.99,
                'reorder_level' => 50,
            ],
            [
                'name' => 'Standard Product B',
                'sku' => 'PROD-B-001',
                'description' => 'Standard quality product',
                'category' => 'Standard',
                'cost_price' => 15.00,
                'selling_price' => 29.99,
                'reorder_level' => 100,
            ],
            [
                'name' => 'Economy Product C',
                'sku' => 'PROD-C-001',
                'description' => 'Economy product',
                'category' => 'Economy',
                'cost_price' => 8.00,
                'selling_price' => 14.99,
                'reorder_level' => 150,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Create Sample Vendors
        $vendors = [
            [
                'name' => 'ABC Supply Co.',
                'code' => 'VEN-001',
                'contact_person' => 'Bob Johnson',
                'email' => 'bob@abcsupply.com',
                'phone' => '555-1000',
                'address' => '789 Supplier Lane',
                'city' => 'Newark',
                'state' => 'NJ',
                'zip_code' => '07102',
                'country' => 'USA',
                'status' => 'active',
                'rating' => 4.5,
            ],
            [
                'name' => 'XYZ Wholesale',
                'code' => 'VEN-002',
                'contact_person' => 'Alice Smith',
                'email' => 'alice@xyzwholesale.com',
                'phone' => '555-2000',
                'address' => '321 Vendor Street',
                'city' => 'Jersey City',
                'state' => 'NJ',
                'zip_code' => '07302',
                'country' => 'USA',
                'status' => 'active',
                'rating' => 4.8,
            ],
        ];

        foreach ($vendors as $vendorData) {
            Vendor::create($vendorData);
        }

        // Create Compliance Requirements
        $requirements = [
            [
                'name' => 'Health & Safety Inspection',
                'description' => 'Annual health and safety inspection by certified inspector',
                'category' => 'safety',
                'frequency' => 'annually',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Business License Renewal',
                'description' => 'Renew business license with local authorities',
                'category' => 'legal',
                'frequency' => 'annually',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Quality Audit',
                'description' => 'Quarterly quality assurance audit',
                'category' => 'quality',
                'frequency' => 'quarterly',
                'is_mandatory' => true,
            ],
            [
                'name' => 'Financial Reporting',
                'description' => 'Monthly financial report submission',
                'category' => 'operational',
                'frequency' => 'monthly',
                'is_mandatory' => true,
            ],
        ];

        foreach ($requirements as $reqData) {
            ComplianceRequirement::create($reqData);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@franchise.com / password');
        $this->command->info('Franchisor: franchisor@franchise.com / password');
        $this->command->info('Franchisee: franchisee@franchise.com / password');
    }
}
