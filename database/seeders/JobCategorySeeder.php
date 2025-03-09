<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobCategory;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches to optimize performance
        $totalRecords = 100000; // 100K rows

        // Get the last sort_order from the database
        $lastSortOrder = JobCategory::max('sort_order') ?? 0;

        $arrRandom = [
            'Technology', 'Healthcare', 'Education', 'Finance', 'Marketing', 'Retail',
            'Construction', 'Engineering', 'Manufacturing', 'Transportation',
            'Hospitality', 'Entertainment', 'Sports', 'Legal', 'Real Estate',
            'Agriculture', 'Energy', 'Telecommunications', 'Automotive', 'Aerospace'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $jobCategories = [];

            for ($j = 0; $j < $batchSize; $j++) {
                
                $lastSortOrder++;
                
                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Category";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)];

                $jobCategories[] = [
                    'name' => $name, // Unique category name
                    'sort_order' => $lastSortOrder,
                    'created_by' => 1,
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            JobCategory::insert($jobCategories); // Batch insert
            unset($jobCategories); // Free memory
        }
    }
}
