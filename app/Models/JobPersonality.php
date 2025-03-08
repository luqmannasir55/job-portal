<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobPersonality extends Pivot
{
    protected $table = 'jobs_personalities';
    protected $fillable = ['job_id', 'personality_id'];
}
