<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobPracticalSkill extends Pivot
{
    protected $table = 'jobs_practical_skills';
    protected $fillable = ['job_id', 'practical_skill_id'];
}
