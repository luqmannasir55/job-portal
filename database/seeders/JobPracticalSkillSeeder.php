<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobPracticalSkill;
use App\Models\Job;
use App\Models\PracticalSkill;

class JobPracticalSkillSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $jobIds = Job::pluck('id')->toArray(); // Get all job IDs
        $practicalSkillIds = PracticalSkill::pluck('id')->toArray(); // Get all practical skill IDs

        if (empty($jobIds) || empty($practicalSkillIds)) {
            return; // Skip seeding if no jobs or practical skills exist
        }

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobPracticalSkills = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jobPracticalSkills[] = [
                    'job_id' => $jobIds[array_rand($jobIds)], // Random job
                    'practical_skill_id' => $practicalSkillIds[array_rand($practicalSkillIds)], // Random skill
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobPracticalSkill::insert($jobPracticalSkills); // Batch insert
            unset($jobPracticalSkills); // Free memory
        }
    }
}
