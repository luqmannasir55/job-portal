<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobTool extends Pivot
{
    protected $table = 'jobs_tools';
    protected $fillable = ['job_id', 'affiliate_id'];
}
