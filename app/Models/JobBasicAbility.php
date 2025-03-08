<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobBasicAbility extends Pivot
{
    protected $table = 'jobs_basic_abilities';
    protected $fillable = ['job_id', 'basic_ability_id'];
}
