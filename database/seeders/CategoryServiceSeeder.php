<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryService;

class CategoryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Option 1: Using Eloquent model
        $categories = [
            [
                'name' => 'Cleaning Services',
                'description' => 'Professional cleaning for homes, offices, and commercial spaces'
            ],
            [
                'name' => 'Plumbing & HVAC',
                'description' => 'Installation, repair, and maintenance of pipes, heating, and cooling systems'
            ],
            [
                'name' => 'Electrician & Technician',
                'description' => 'Electrical wiring, appliance repair, and technical maintenance services'
            ],
            [
                'name' => 'Food & Beverage Service',
                'description' => 'Waitstaff, bartenders, and catering professionals'
            ],
            [
                'name' => 'Construction & Carpentry',
                'description' => 'Building, remodeling, and woodworking services'
            ],
            [
                'name' => 'Automotive Repair',
                'description' => 'Mechanics and technicians for vehicle maintenance and repairs'
            ]
        ];

        foreach ($categories as $category) {
            CategoryService::create($category);
        }

        // Option 2: Using DB facade (uncomment if you prefer this approach)
        /*
        DB::table('category_services')->insert([
            [
                'name' => 'Web Development',
                'description' => 'Services related to website and web application development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more categories as needed
        ]);
        */
    }
}