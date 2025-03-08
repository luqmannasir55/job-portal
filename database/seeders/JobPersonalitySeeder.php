<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPersonality;
use App\Models\Job;
use App\Models\Personality;

class JobPersonalitySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $personalityIds = Personality::pluck('id')->toArray(); // Get all personality IDs

        if (empty($jobIds) || empty($personalityIds)) {
            return; // Skip seeding if no jobs or personalities exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobPersonalities = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobPersonalities[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'personality_id' => $personalityIds[array_rand($personalityIds)], // Random personality
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobPersonality::insert($jobPersonalities); // Batch insert
            unset($jobPersonalities); // Free memory
        }
    }
}
