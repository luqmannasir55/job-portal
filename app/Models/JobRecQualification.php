<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobRecQualification extends Pivot
{
    protected $table = 'jobs_rec_qualifications';
    protected $fillable = ['job_id', 'affiliate_id'];
}
