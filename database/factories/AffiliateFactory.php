<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Affiliate>
 */
class AffiliateFactory extends Factory
{
    protected $model = \App\Models\Affiliate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement([1, 2, 3]), // 1 = Tools, 2 = Qualifications, 3 = Career Paths
            'created_by' => 1,
            'created' => now(),
            'modified' => now(),
            'deleted' => null
        ];
    }
}

