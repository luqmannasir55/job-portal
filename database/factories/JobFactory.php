<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'media_id' => null, // Assuming no default media
            'job_category_id' => \App\Models\JobCategory::inRandomOrder()->first()->id ?? 1,
            'job_type_id' => \App\Models\JobType::inRandomOrder()->first()->id ?? 1,
            'description' => $this->faker->paragraph,
            'detail' => $this->faker->text(),
            'business_skill' => $this->faker->sentence(),
            'knowledge' => $this->faker->sentence(),
            'location' => $this->faker->city(),
            'activity' => $this->faker->sentence(),
            'academic_degree_doctor' => 'none',
            'academic_degree_master' => 'none',
            'academic_degree_professional' => 'none',
            'academic_degree_bachelor' => 'none',
            'salary_statistic_group' => null,
            'salary_range_first_year' => $this->faker->randomFloat(2, 30000, 70000),
            'salary_range_average' => $this->faker->randomFloat(2, 50000, 120000),
            'salary_range_remarks' => null,
            'restriction' => null,
            'estimated_total_workers' => $this->faker->numberBetween(10, 1000),
            'remarks' => null,
            'url' => $this->faker->url(),
            'seo_description' => $this->faker->sentence(),
            'seo_keywords' => implode(',', $this->faker->words(5)),
            'sort_order' => $this->faker->numberBetween(1, 100),
            'publish_status' => 1,
            'version' => 1,
            'created_by' => 1,
            'created' => now(),
            'modified' => now(),
            'deleted' => null,
        ];
    }
}
