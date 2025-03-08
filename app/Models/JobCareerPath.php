<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobCareerPath extends Pivot
{
    protected $table = 'jobs_career_paths';
    protected $fillable = ['job_id', 'affiliate_id'];
}
