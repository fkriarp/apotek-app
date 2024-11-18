<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            ['name' => 'Paracetamol 500 mg', 'type' => 'tablet', 'price' => 5000, 'stock' => 100],
            ['name' => 'Amoxicillin 500 mg', 'type' => 'kapsul', 'price' => 12000, 'stock' => 50],
            ['name' => 'Ibuprofen 400 mg', 'type' => 'tablet', 'price' => 9000, 'stock' => 75],
            ['name' => 'Cetirizine 10 mg', 'type' => 'tablet', 'price' => 13000, 'stock' => 60],
            ['name' => 'Omeprazole 20 mg', 'type' => 'kapsul', 'price' => 9000, 'stock' => 80],
            ['name' => 'Metformin 500 mg', 'type' => 'tablet', 'price' => 12000, 'stock' => 70],
            ['name' => 'Amlodipine 5 mg', 'type' => 'tablet', 'price' => 13000, 'stock' => 90],
            ['name' => 'Ciprofloxacin 500 mg', 'type' => 'kapsul', 'price' => 17000, 'stock' => 40],
            ['name' => 'Loperamide 2 mg', 'type' => 'tablet', 'price' => 6000, 'stock' => 100],
            ['name' => 'Dexamethasone 0.5 mg', 'type' => 'tablet', 'price' => 8000, 'stock' => 50],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
