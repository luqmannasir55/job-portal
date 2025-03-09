<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;

class JobTypeSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches to optimize performance
        $totalRecords = 100000; // 100K rows

        // Get the last sort_order from the database
        $lastSortOrder = JobType::max('sort_order') ?? 0;
        $lastJobCategoryId = 1; // Start job_category_id sequentially

        $arrRandom = [
            'Full-Time', 'Part-Time', 'Freelance', 'Internship', 'Contract', 
            'Remote', 'On-Site', 'Temporary', 'Commission-Based', 'Volunteer'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobTypes = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                // Assign job_category_id sequentially (1, 2, 3, ... looping)
                if ($lastSortOrder % 10 == 0) {
                    $lastJobCategoryId++; // Every 10 job types, increment category
                }
                
                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Job Type";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)];

                $jobTypes[] = [
                    'name' => $name, // Logical naming
                    'job_category_id' => $lastJobCategoryId, // Sequential category
                    'sort_order' => $lastSortOrder,
                    'created_by' => 1,
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobType::insert($jobTypes); // Batch insert
            unset($jobTypes); // Free memory
        }
    }
}
