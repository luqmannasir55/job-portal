<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 600000; // 600K rows

        // Get the last sort_order from the database
        $lastSortOrder = Job::max('sort_order') ?? 0;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobs = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $jobs[] = [
                    'name' => "Job $lastSortOrder", // Logical job name
                    'job_category_id' => ceil($lastSortOrder / 10), // Assign category sequentially
                    'job_type_id' => ceil($lastSortOrder / 20), // Assign job type sequentially
                    'description' => "Description for Job $lastSortOrder",
                    'detail' => "Detailed info for Job $lastSortOrder",
                    'business_skill' => "Skill for Job $lastSortOrder",
                    'knowledge' => "Knowledge for Job $lastSortOrder",
                    'location' => "Location $lastSortOrder",
                    'salary_statistic_group' => rand(1, 5),
                    'salary_range_first_year' => rand(30000, 50000),
                    'salary_range_average' => rand(50000, 80000),
                    'salary_range_remarks' => "Salary remarks for Job $lastSortOrder",
                    'sort_order' => $lastSortOrder,
                    'publish_status' => 1,
                    'created_by' => 1,
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            Job::insert($jobs); // Batch insert
            unset($jobs); // Free memory
        }
    }
}
