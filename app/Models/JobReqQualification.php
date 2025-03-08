<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobReqQualification extends Pivot
{
    protected $table = 'jobs_req_qualifications';
    protected $fillable = ['job_id', 'affiliate_id'];
}
