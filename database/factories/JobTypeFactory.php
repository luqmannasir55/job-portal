<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobType>
 */
class JobTypeFactory extends Factory
{
    protected $model = \App\Models\JobType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->jobTitle,
            'job_category_id' => \App\Models\JobCategory::inRandomOrder()->first()->id ?? 1,
            'sort_order' => $this->faker->randomNumber(),
            'created_by' => 1,
            'created' => now(),
            'modified' => now(),
            'deleted' => null
        ];
    }
}

