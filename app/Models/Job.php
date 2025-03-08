<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job extends Model
{
    public $timestamps = false;
    //use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'media_id', 'job_category_id', 'job_type_id', 'description', 'detail',
        'business_skill', 'knowledge', 'location', 'activity', 'academic_degree_doctor',
        'academic_degree_master', 'academic_degree_professional', 'academic_degree_bachelor',
        'salary_statistic_group', 'salary_range_first_year', 'salary_range_average',
        'salary_range_remarks', 'restriction', 'estimated_total_workers', 'remarks', 'url',
        'seo_description', 'seo_keywords', 'sort_order', 'publish_status', 'version', 'created_by'
    ];

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function type()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function basicAbilities()
    {
        return $this->belongsToMany(BasicAbility::class, 'jobs_basic_abilities');
    }

    public function practicalSkills()
    {
        return $this->belongsToMany(PracticalSkill::class, 'jobs_practical_skills');
    }

    public function personalities()
    {
        return $this->belongsToMany(Personality::class, 'jobs_personalities');
    }

    public function tools()
    {
        return $this->belongsToMany(Affiliate::class, 'jobs_tools')->where('affiliates.type', 1);
    }

    public function careerPaths()
    {
        return $this->belongsToMany(Affiliate::class, 'jobs_career_paths')->where('affiliates.type', 3);
    }

    public function recQualifications()
    {
        return $this->belongsToMany(Affiliate::class, 'jobs_rec_qualifications')->where('affiliates.type', 2);
    }

    public function reqQualifications()
    {
        return $this->belongsToMany(Affiliate::class, 'jobs_req_qualifications')->where('affiliates.type', 2);
    }
}
