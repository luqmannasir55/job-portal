<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BasicAbility;
use Faker\Factory as Faker;

class BasicAbilitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Initialize Faker
        $batchSize = 1000; // Insert in batches for performance
        $totalRecords = 100000; // 100K rows

        $arrRandom = [
            'Problem Solving', 'Critical Thinking', 'Time Management', 'Creativity',
            'Adaptability', 'Leadership', 'Collaboration', 'Emotional Intelligence',
            'Decision Making', 'Communication Skills', 'Analytical Thinking', 'Attention to Detail',
            'Negotiation', 'Public Speaking', 'Self-Motivation', 'Resilience',
            'Conflict Resolution', 'Active Listening', 'Strategic Thinking', 'Teamwork'
        ];

        $bKeywordSeeded = false;

        for ($i = 0; $i < $totalRecords / $batchSize; $i++) {
            $basicAbilities = [];

            for ($j = 0; $j < $batchSize; $j++) {

                $name = '';
                if (!$bKeywordSeeded) {//seed one keyword data
                    $name =  "キャビンアテンダント Basic Ability";
                    $bKeywordSeeded = true;
                }
                else //seed random name
                    $name = $arrRandom[array_rand($arrRandom)] . " " . $faker->randomElement(['Skill', 'Ability', 'Competency']);

                $basicAbilities[] = [
                    'name' => $name,
                    'created' => now(),
                    'modified' => now(),
                    'deleted' => null
                ];

            }

            BasicAbility::insert($basicAbilities); // Batch insert
            unset($basicAbilities); // Free memory
        }
    }
}
