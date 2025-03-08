<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BasicAbility;

class BasicAbilitySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        // Get the last id from the database
        $lastSortOrder = BasicAbility::max('id') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $basicAbilities = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $basicAbilities[] = [
                    'name' => "Basic Ability $lastSortOrder",
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            BasicAbility::insert($basicAbilities); // Batch insert
            unset($basicAbilities); // Free memory
        }
    }
}
