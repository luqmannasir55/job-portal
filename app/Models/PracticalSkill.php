<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticalSkill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'jobs_practical_skills');
    }
}
