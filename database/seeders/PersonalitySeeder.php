<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Personality;

class PersonalitySeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $arrRandom = [
            'Innovative', 'Charismatic', 'Resilient', 'Empathetic', 'Analytical', 
            'Adventurous', 'Strategic', 'Determined', 'Optimistic', 'Diplomatic',
            'Independent', 'Creative', 'Diligent', 'Visionary', 'Pragmatic',
            'Ambitious', 'Compassionate', 'Reliable', 'Assertive', 'Humble'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $personalities = [];

            for ($j = 0; $j < $batchSize; $j++) {

                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Personality";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)];

                $personalities[] = [
                    'name' => $name, // Logical name
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            Personality::insert($personalities); // Batch insert
            unset($personalities); // Free memory
        }
    }
}
