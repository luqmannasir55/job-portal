<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('jobs_req_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('affiliate_id')->constrained('affiliates')->onDelete('cascade'); // required qualifications in affiliates
            $table->timestamp('created')->useCurrent();
            $table->timestamp('modified')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('jobs_req_qualifications');
    }
};

