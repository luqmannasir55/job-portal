<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Affiliate;
use Faker\Factory as Faker;

class AffiliateSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Initialize Faker
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $affiliates = [];

            for ($j = 0; $j < $batchSize; $j++) {

                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Affliate";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $faker->company . " " . $faker->randomElement(['Group', 'Inc.', 'Ltd.', 'Corp.', 'Solutions']);

                $affiliates[] = [
                    'name' => $name, 
                    'type' => rand(1, 5), // Random type (adjust as needed)
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            Affiliate::insert($affiliates); // Batch insert
            unset($affiliates); // Free memory
        }
    }
}
