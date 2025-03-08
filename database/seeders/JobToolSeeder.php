<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTool;
use App\Models\Job;
use App\Models\Affiliate;

class JobToolSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $toolIds = Affiliate::where('type', 1)->pluck('id')->toArray(); // Get all tool IDs (type = 1)

        if (empty($jobIds) || empty($toolIds)) {
            return; // Skip seeding if no jobs or tools exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobTools = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobTools[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'affiliate_id' => $toolIds[array_rand($toolIds)], // Random tool
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobTool::insert($jobTools); // Batch insert
            unset($jobTools); // Free memory
        }
    }
}
