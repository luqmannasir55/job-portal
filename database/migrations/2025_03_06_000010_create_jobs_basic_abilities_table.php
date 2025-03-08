<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('jobs_basic_abilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('basic_ability_id')->constrained('basic_abilities')->onDelete('cascade');
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('jobs_basic_abilities');
    }
};

