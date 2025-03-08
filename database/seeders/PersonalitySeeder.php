<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personality;

class PersonalitySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        // Get the last sort_order from the database
        $lastSortOrder = Personality::max('id') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $personalities = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $personalities[] = [
                    'name' => "Personality $lastSortOrder", // Logical name
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            Personality::insert($personalities); // Batch insert
            unset($personalities); // Free memory
        }
    }
}
