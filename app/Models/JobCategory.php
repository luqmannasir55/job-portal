<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name', 'sort_order', 'created_by'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
