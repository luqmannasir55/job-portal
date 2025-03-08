<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCareerPath;
use App\Models\Job;
use App\Models\Affiliate;

class JobCareerPathSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $careerPathIds = Affiliate::where('type', 3)->pluck('id')->toArray(); // Get all career paths (type = 3)

        if (empty($jobIds) || empty($careerPathIds)) {
            return; // Skip seeding if no jobs or career paths exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobCareerPaths = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobCareerPaths[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'affiliate_id' => $careerPathIds[array_rand($careerPathIds)], // Random career path
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobCareerPath::insert($jobCareerPaths); // Batch insert
            unset($jobCareerPaths); // Free memory
        }
    }
}
