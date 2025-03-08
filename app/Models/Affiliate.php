<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type'];

    public function tools()
    {
        return $this->hasMany(JobTool::class, 'affiliate_id');
    }

    public function careerPaths()
    {
        return $this->hasMany(JobCareerPath::class, 'affiliate_id');
    }

    public function recQualifications()
    {
        return $this->hasMany(JobRecQualification::class, 'affiliate_id');
    }

    public function reqQualifications()
    {
        return $this->hasMany(JobReqQualification::class, 'affiliate_id');
    }
}
