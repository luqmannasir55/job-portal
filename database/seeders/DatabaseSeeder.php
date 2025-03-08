<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        $this->call([
            AffiliateSeeder::class,
            BasicAbilitySeeder::class,
            JobBasicAbilitySeeder::class,
            JobCareerPathSeeder::class,
            JobCategorySeeder::class,
            JobTypeSeeder::class,
            JobPersonalitySeeder::class,
            JobPracticalSkillSeeder::class,
            JobRecQualificationSeeder::class,
            JobReqQualificationSeeder::class,
            JobSeeder::class,
            JobToolSeeder::class,
            PersonalitySeeder::class,
            PracticalSkillSeeder::class,
        ]);

        DB::statement("ALTER TABLE jobs ADD FULLTEXT(name, description, detail, business_skill, knowledge, location, activity)");
        DB::statement("ALTER TABLE job_categories ADD FULLTEXT(name)");
        DB::statement("ALTER TABLE job_types ADD FULLTEXT(name)");
        DB::statement("ALTER TABLE personalities ADD FULLTEXT(name)");
        DB::statement("ALTER TABLE practical_skills ADD FULLTEXT(name)");
        DB::statement("ALTER TABLE basic_abilities ADD FULLTEXT(name)");
        DB::statement("ALTER TABLE affiliates ADD FULLTEXT(name)");

        // Run update queries to test searching keyword (キャビンアテンダント)
        DB::table('affiliates')
            ->where('id', 52654)
            ->update(['name' => 'Affiliate 52654 (キャビンアテンダント)']);

        DB::table('affiliates')
            ->where('id', 99972)
            ->update(['name' => 'Affiliate 99972 (キャビンアテンダント)']);

        DB::table('personalities')
            ->where('id', 3822)
            ->update(['name' => 'Personality 3822 (キャビンアテンダント)']);

        DB::table('personalities')
            ->where('id', 23239)
            ->update(['name' => 'Personality 23239 (キャビンアテンダント)']);

        DB::table('jobs')
            ->where('id', 250000)
            ->update(['name' => 'Job 250000 (キャビンアテンダント)']);

    }
}
