<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PracticalSkill;

class PracticalSkillSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        // Get the last sort_order from the database
        $lastSortOrder = PracticalSkill::max('id') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $practicalSkills = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $practicalSkills[] = [
                    'name' => "Practical Skill $lastSortOrder", // Logical skill name
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            PracticalSkill::insert($practicalSkills); // Batch insert
            unset($practicalSkills); // Free memory
        }
    }
}
