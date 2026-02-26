<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Car QR Tag',
                'slug' => 'car',
                'description' => 'For parked or lost vehicles',
                'price' => 499.00,
                'icon' => '🚗',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Bike QR Tag',
                'slug' => 'bike',
                'description' => 'Protect your two-wheeler anywhere',
                'price' => 399.00,
                'icon' => '🏍️',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Bag QR Tag',
                'slug' => 'bag',
                'description' => 'Luggage, office bags & travel bags',
                'price' => 299.00,
                'icon' => '🎒',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Pet QR Tag',
                'slug' => 'pet',
                'description' => 'Help pets find their way home',
                'price' => 349.00,
                'icon' => '🐕',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Children QR Tag',
                'slug' => 'children',
                'description' => 'Safety tags for kids & school trips',
                'price' => 299.00,
                'icon' => '👶',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Combo QR Tags',
                'slug' => 'combo',
                'description' => 'Best value pack for families',
                'price' => 1499.00,
                'icon' => '📦',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
