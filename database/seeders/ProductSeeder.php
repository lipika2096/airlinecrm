<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_name' => 'Air Tickets',
                'description' => 'Flight booking and ticketing services for domestic and international travel',
                'status' => 'Active',
            ],
            [
                'product_name' => 'Hotel Bookings',
                'description' => 'Hotel reservation services worldwide with competitive rates',
                'status' => 'Active',
            ],
            [
                'product_name' => 'Visa Assistance',
                'description' => 'Visa processing and documentation support for various destinations',
                'status' => 'Active',
            ],
            [
                'product_name' => 'Holidays & Packages',
                'description' => 'Customized holiday packages and tour itineraries',
                'status' => 'Active',
            ],
            [
                'product_name' => 'Car Rentals',
                'description' => 'Car rental services for business and leisure travel',
                'status' => 'Active',
            ],
            [
                'product_name' => 'Travel Insurance',
                'description' => 'Comprehensive travel insurance coverage for travelers',
                'status' => 'Active',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
