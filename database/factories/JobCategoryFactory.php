<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobCategory;

class JobCategoryFactory extends Factory
{
    protected $model = JobCategory::class;

    public function definition()
    {
        // Get the latest sort_order and increment
        $lastSortOrder = JobCategory::max('sort_order') ?? 0;

        return [
            'name' => $this->faker->word,
            'sort_order' => $lastSortOrder + 1, // Sequential sort_order
            'created_by' => 1,
            'created' => now(),
            'modified' => now(),
            'deleted' => null
        ];
    }
}
