<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class JobSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        // Get the last sort_order from the database
        $lastSortOrder = Job::max('sort_order') ?? 0;

        $arrRandom = [
            'Software Engineer', 'Data Analyst', 'Marketing Manager', 'Financial Advisor',
            'Project Manager', 'UX Designer', 'Cybersecurity Specialist', 'AI Researcher',
            'Network Administrator', 'DevOps Engineer', 'Content Writer', 'Graphic Designer',
            'HR Specialist', 'Mechanical Engineer', 'Customer Support Representative',
            'Legal Consultant', 'Sales Executive', 'Operations Manager', 'Biomedical Engineer'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobs = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $lastSortOrder++;

                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)];

                $jobs[] = [
                    'name' => $name, // Logical job name
                    'job_category_id' => ceil($lastSortOrder / 10), // Assign category sequentially
                    'job_type_id' => ceil($lastSortOrder / 20), // Assign job type sequentially
                    'description' => "Description for Job ".$name,
                    'detail' => "Detailed info for Job ".$name,
                    'business_skill' => "Skill for Job ".$name,
                    'knowledge' => "Knowledge for Job ".$name,
                    'location' => "Location for Job ".$name,
                    'salary_statistic_group' => rand(1, 5),
                    'salary_range_first_year' => rand(30000, 50000),
                    'salary_range_average' => rand(50000, 80000),
                    'salary_range_remarks' => "Salary remarks for Job ".$name,
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
