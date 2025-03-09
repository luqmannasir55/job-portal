<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PracticalSkill;

class PracticalSkillSeeder extends Seeder
{
    public function run()
    {
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $arrRandom = [
            'Carpentry', 'Welding', 'Plumbing', 'Electrician Work', 'Automotive Repair',
            'Cooking', 'Sewing', 'Painting', 'Machining', 'Gardening',
            'First Aid', 'Woodworking', 'Metalworking', 'Baking', 'Horticulture',
            'Tailoring', 'Handcrafting', 'Firefighting', 'Hairdressing', 'Masonry'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $practicalSkills = [];

            for ($j = 0; $j < $batchSize; $j++) {

                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Personality";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)];

                $practicalSkills[] = [
                    'name' => $name, // Logical skill name
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];
            }

            PracticalSkill::insert($practicalSkills); // Batch insert
            unset($practicalSkills); // Free memory
        }
    }
}
