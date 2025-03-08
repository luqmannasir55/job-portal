<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPersonality>
 */
class JobPersonalityFactory extends Factory
{
    protected $model = \App\Models\JobPersonality::class;

    public function definition()
    {
        return [
            'job_id' => \App\Models\Job::inRandomOrder()->first()->id,
            'personality_id' => \App\Models\Personality::inRandomOrder()->first()->id
        ];
    }
}

