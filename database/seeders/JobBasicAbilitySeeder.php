<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobBasicAbility;
use App\Models\Job;
use App\Models\BasicAbility;

class JobBasicAbilitySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 200000; // 200K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $abilityIds = BasicAbility::pluck('id')->toArray(); // Get all basic ability IDs

        if (empty($jobIds) || empty($abilityIds)) {
            return; // Skip seeding if no jobs or abilities exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobBasicAbilities = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobBasicAbilities[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'basic_ability_id' => $abilityIds[array_rand($abilityIds)], // Random basic ability
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobBasicAbility::insert($jobBasicAbilities); // Batch insert
            unset($jobBasicAbilities); // Free memory
        }
    }
}
