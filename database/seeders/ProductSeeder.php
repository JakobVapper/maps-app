<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Earbuds',
                'description' => 'High-quality wireless earbuds with noise cancellation and long battery life.',
                'price' => 79.99,
                'image' => 'images/products/Airpods.png',
                'stock' => 50
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracker and smartphone companion with heart rate monitoring and sleep tracking.',
                'price' => 149.99,
                'image' => 'images/products/Watch.png',
                'stock' => 30
            ],
            [
                'name' => 'Portable Power Bank',
                'description' => '20000mAh high-capacity power bank with fast charging for all your devices.',
                'price' => 45.99,
                'image' => 'images/products/Powerbank.png',
                'stock' => 100
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Waterproof bluetooth speaker with 360° sound and 24-hour battery life.',
                'price' => 89.99,
                'image' => 'images/products/Speaker.png',
                'stock' => 40
            ],
            [
                'name' => 'Laptop Backpack',
                'description' => 'Anti-theft backpack with USB charging port and multiple compartments for organization.',
                'price' => 59.99,
                'image' => 'images/products/Backpack.png',
                'stock' => 75
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with adjustable DPI settings and silent clicks.',
                'price' => 29.99,
                'image' => 'images/products/Mouse.png',
                'stock' => 120
            ],
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Adjustable desk lamp with multiple brightness levels and color temperatures.',
                'price' => 34.99,
                'image' => 'images/products/Lamp.png',
                'stock' => 60
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard with customizable key switches for gaming and typing.',
                'price' => 89.99,
                'image' => 'images/products/Keyboard.png',
                'stock' => 45
            ],
            [
                'name' => 'Wireless Charger',
                'description' => 'Fast wireless charging pad compatible with all Qi-enabled devices.',
                'price' => 24.99,
                'image' => 'images/products/Charger.png',
                'stock' => 90
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}