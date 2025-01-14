<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\SalesLead;

class SalesLeadSeeder extends Seeder
{
    public function run()
    {
        // Update all existing records with a unique random value
        // Generate a unique random value for each existing sales lead
        SalesLead::all()->each(function ($salesLead) {
            $salesLead->unique_id = Str::uuid()->toString(); // Generate UUID
            $salesLead->save();
        });
    }
}
