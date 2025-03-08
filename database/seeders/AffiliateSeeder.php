<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Affiliate;

class AffiliateSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        // Get the last id from the database
        $lastSortOrder = Affiliate::max('id') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $affiliates = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $affiliates[] = [
                    'name' => "Affiliate $lastSortOrder", // Logical affiliate name
                    'type' => rand(1, 5), // Random type (adjust as needed)
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            Affiliate::insert($affiliates); // Batch insert
            unset($affiliates); // Free memory
        }
    }
}
