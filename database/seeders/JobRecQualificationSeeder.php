<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobRecQualification;
use App\Models\Job;
use App\Models\Affiliate;

class JobRecQualificationSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $qualificationIds = Affiliate::where('type', 2)->pluck('id')->toArray(); // Get all recommended qualifications

        if (empty($jobIds) || empty($qualificationIds)) {
            return; // Skip seeding if no jobs or qualifications exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobRecQualifications = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobRecQualifications[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'affiliate_id' => $qualificationIds[array_rand($qualificationIds)], // Random qualification
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobRecQualification::insert($jobRecQualifications); // Batch insert
            unset($jobRecQualifications); // Free memory
        }
    }
}
