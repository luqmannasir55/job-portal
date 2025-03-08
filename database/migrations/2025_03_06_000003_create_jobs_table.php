<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::dropIfExists('jobs'); //drop existing Laravel jobs table
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('media_id')->nullable();
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('job_types')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('detail')->nullable();
            $table->text('business_skill')->nullable();
            $table->text('knowledge')->nullable();
            $table->text('location')->nullable();
            $table->text('activity')->nullable();
            $table->string('academic_degree_doctor')->default('none');
            $table->string('academic_degree_master')->default('none');
            $table->string('academic_degree_professional')->default('none');
            $table->string('academic_degree_bachelor')->default('none');
            $table->string('salary_statistic_group')->nullable();
            $table->decimal('salary_range_first_year', 10, 2)->nullable();
            $table->decimal('salary_range_average', 10, 2)->nullable();
            $table->text('salary_range_remarks')->nullable();
            $table->text('restriction')->nullable();
            $table->integer('estimated_total_workers')->nullable();
            $table->text('remarks')->nullable();
            $table->string('url')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('publish_status')->default(1);
            $table->integer('version')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('jobs');
    }
};

